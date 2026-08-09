<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function projects_created(): BelongsToMany  
    {
        return $this->belongsToMany(Project::class);
    }

    // eventi generati dall'utente (
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
        // un istante prima che l'user venga eliminato esegui il codice nelle graffe
        static::deleting(function ($user){

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
     * Filtra i ruoli per la visualizzazione in admin.users-management.index
     */
    protected function displayRoles(): Attribute
    {
        return Attribute::make(
            get: function() {
                // 1) recupera l'elenco dei ruoli (come stringhe)
                $allRoles = $this->roles->pluck('name');


                // 2) se l'utente è admin, ignora tutti gli altri ruoli e mostra solo questo ruolo
                if ($allRoles->contains('admin')) {
                    return collect(['admin']);
                }


                // 3) altrimenti, rimuovo il ruolo base "researcher"
                $filteredRoles = $allRoles->reject(fn($role) => $role === 'researcher');

                // 4) se l'utente non ha più ruoli, significa che era solo un ricercatore base, quindi restituisco quel ruolo
                if ($filteredRoles->isEmpty() && $allRoles->contains('researcher')) {
                    
                    return collect(['researcher']);
                }

                // 5) altrimenti, restituisco tutti i ruoli "speciali" (gestore notizie, gestore progetti, ecc...)
                return $filteredRoles;
            }
        );
    }
}
