<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CorsiFactory> */
    use HasFactory;

    protected $guarded = [];

    public function teachers(): BelongsToMany
    {
        // Un Corso APPARTIENE A UN insegnante(=user=ricercatore)
        return $this->belongsToMany(User::class)->withTimestamps()->withTrashed();
    }

    /**
     * Scope per filtrare i corsi per Docente (User ID)
     */
    public function scopeFilterByTeacher(Builder $query, ?int $userId): Builder
    {
        return $query->when($userId, function ($query) use ($userId) {
            $query->whereHas('teachers', function ($teacherQuery) use ($userId) {
                $teacherQuery->where('users.id', $userId);
            });
        });
    }

    /**
     * Scope Principale: Filtra i corsi in base ai permessi dell'utente.
     */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        // L'Admin vede tutto (compresi i corsi senza docenti)
        if ($user->can('manage all courses')) {
            return $query;
        }

        // Il docente vede solo i corsi in cui è presente tra i 'teachers'
        return $query->whereHas('teachers', function (Builder $q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }
}
