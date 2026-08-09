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
        'curriculm_file_path',
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
        return $this->belongsToMany(Course::class);
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
        return $this->belongsToMany(Event::class)->withPivot('deleted_at')->withTimestamps();;
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
}
