<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\ProjectStatusType;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProgettoFactory> */
    use HasFactory;

    protected $guarded = [];

    // Cast automatico della colonna status verso l'Enum
    protected $casts = [
        'status' => ProjectStatusType::class,
    ];


    // gli utenti che lavorano a questo project (i collaboratori)
    public function users(): BelongsToMany  
    {
        return $this->belongsToMany(User::class)->withTrashed();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // un project può appartenere ad 1 o più aree di ricerca
    public function researchAreas(): BelongsToMany
    {
        return $this->belongsToMany(ResearchArea::class);
    }

    /**
     * Filtra i progetti per Creatore (solo dall'URL)
     */
    public function scopeFilterByCreator(Builder $query, ?int $creatorId): Builder
    {
        if (empty($creatorId)) return $query;

        return $query->whereHas('creator', function (Builder $q) use ($creatorId) {
            $q->where('users.id', $creatorId);
        });
    }

    /**
     * Filtra i progetti per Collaboratore (solo dall'URL)
     */
    public function scopeFilterByCollaborator(Builder $query, ?int $collaboratorId): Builder
    {
        if (empty($collaboratorId)) return $query;

        return $query->whereHas('users', function (Builder $q) use ($collaboratorId) {
            $q->where('users.id', $collaboratorId);
        });
    }

    /**
     * Filtra i progetti per Stato (Enum)
     */
    public function scopeFilterByStatus(Builder $query, ?string $status): Builder
    {
        if (empty($status)) return $query;

        return $query->where('status', $status);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES DI VISIBILITÀ E PERMESSI
    |--------------------------------------------------------------------------
    */

    /**
     * Scope Principale: Filtra automaticamente i progetti in base ai permessi dell'utente.
     */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->can('manage all projects')) {
            // SCENARIO 1: Admin - Vede tutto senza filtri
            return $query;
        }

        if ($user->can('manage my projects')) {
            // SCENARIO 2: Manager - Vede se è autore OPPURE collaboratore
            return $query->whereCreatorOrCollaborator($user->id);
        }

        // SCENARIO 3: Researcher/Base - Vede SOLO se è collaboratore
        return $query->whereCollaborator($user->id);
    }

    /**
     * Scope Granulare: Filtra solo i progetti in cui l'utente è collaboratore (tabella pivot users).
     */
    public function scopeWhereCollaborator(Builder $query, int $userId): Builder
    {
        return $query->whereHas('users', function (Builder $q) use ($userId) {
            $q->where('users.id', $userId);
        });
    }

    /**
     * Scope Granulare: Filtra i progetti in cui l'utente è autore OPPURE collaboratore.
     */
    public function scopeWhereCreatorOrCollaborator(Builder $query, int $userId): Builder
    {
        return $query->where(function (Builder $q) use ($userId) {
            $q->whereHas('creator', function (Builder $subQ) use ($userId) {
                $subQ->where('users.id', $userId);
            })
            ->orWhereHas('users', function (Builder $subQ) use ($userId) {
                $subQ->where('users.id', $userId);
            });
        });
    }
}
