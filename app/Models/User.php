<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Course;
use App\Models\Article;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Project;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'website',
        'bio',
        'profile_photo_path',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // indica la relazione tra utente e corsi
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }


    /**
     * Gli articoli a cui l'utente ha accesso.
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    // I progetti a cui l'utente ha accesso
    public function projects(): BelongsToMany  
    {
        return $this->belongsToMany(Project::class);
    }

    public function projects_created(): HasMany 
    {
        return $this->hasMany(Project::class, 'creator_id');
    }

    // eventi generati dall'utente
    public function events_created(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    // Eventi associati a questo user
    public function events_receives(): BelongsToMany  
    {
        return $this->belongsToMany(Event::class)->withPivot('deleted_at')->withTimestamps();
    }

    public function curriculum()
    {
        // Collega User al modello File (il suo curriculum) tramite il prefisso 'fileable'
        return $this->morphOne(File::class, 'fileable');
    }


    // filtra gli utenti in base allo stato (attivi, cestinati, o tutti)
    public function scopeFilterByStatus($query, $status)
    {
        if ($status === 'trashed') {
            // estrate solo gli utenti nel cestino
            return $query->onlyTrashed();
        }

        if ($status === 'all'){
            return $query->withTrashed();
        }

        // comporamento di defualt: se $stato è vuoto
        // significa che l'utente vuole vedere solo gli utenti attivi
        return $query;

        // Nota: di default, grazie a SoftDeletes, Laraver non mostrerà gli utenti cestianti
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 1) se il percorso nel DB esiste e il file è fisicamente presente nello storage  
                if($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)){
                    return Storage::url($this->profile_photo_path);
                }

                // 2) Altrimenti restituisci l'immagine di default presente in public per gli user
                return asset('images/defaultUsers/no_image_user.webp');
            }
        );
    }

    protected static function booted()
    {   
        // Un attimo prima che l'utente venga eliminato definitivamente
        static::forceDeleting(function ($user){

            // Carica la relazione 'curriculum' se non è già presente in memoria, cosi da evitare il Lazy Loading
            $user->loadMissing('curriculum');

            // Cicla su tutti gli allegati e invoca il loro metodo delete()
            // Questo scatenerà l'evneto 'deleting' dentro il modello File che cancellerà il file fisico!
            if ($user->curriculum){
                $user->curriculum->delete();
            }
        });
    }

    /**
     * Filtra i ruoli per la visualizzazione
     */
    protected function displayRoles(): Attribute
    {
        return Attribute::make(
            get: function() {
                // 1) recupera l'elenco dei ruoli di questo User
                $roles = $this->roles->loadMissing('permissions');


                // 2) se l'utente è admin, ignora tutti gli altri ruoli e mostra solo questo ruolo
                if ($roles->contains('name', 'admin')) {
                    return collect(['admin']);
                }


                // 3) creo una collection vuota
                $topLevelRoles = collect(); 

                // 4) Confronto i ruoli posseduti dall'utente tra di loro
                // primo ciclo, scorro tutti i ruoli dell'utente
                foreach ($roles as $currentRole) {
                    $isSubsumed = false;
                    $currentPerms = $currentRole->permissions->pluck('name'); // estrae i permessi legati a questo ruolo

                    // secondo ciclo per confrontare il ruolo attuale con gli altri ruoli
                    foreach ($roles as $otherRole) {
                        // Non confrontare il ruolo con se stesso
                        if ($currentRole->id === $otherRole->id) {
                            continue;
                        }

                        $otherPerms = $otherRole->permissions->pluck('name'); // estraggo i permessi del secondo ruolo

                        
                        // Se la differenza tra i permessi correnti e gli altri è vuota,
                        // significa che $otherRole possiede TUTTI i permessi di $currentRole.
                        // Se $otherRole ha anche PIÙ permessi, allora $currentRole è un sottoinsieme.
                        if ($currentPerms->diff($otherPerms)->isEmpty() && $otherPerms->count() > $currentPerms->count()) { 
                            $isSubsumed = true;
                            break; // Inutile controllare altri ruoli, questo è già "assorbito"
                        }

                        // $group1->diff($group2) = prende gli elementi del primo e rimuove quelli presenti nel secondo
                        // $otherPerms->count() > $currentPerms->count() = verifica che il ruolo B ($otherPerms) contiene davvero più permessi del ruolo A ($currentPerms)
                    }

                    // Se il ruolo non è stato assorbito da nessun altro ruolo più grande, lo teniamo
                    if (!$isSubsumed) {
                        $topLevelRoles->push($currentRole->name);
                    }
                }

                return $topLevelRoles;
            }
        );
    }
}
