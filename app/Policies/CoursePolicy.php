<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    /**
     * Determina se l'utente può accedere alla pagina di gestione dei corsi.
     */
    public function viewAny(User $user): bool
    {
        // Possono accedere sia gli admin dei corsi sia i docenti
        return $user->hasPermissionTo('manage all courses') 
            || $user->hasPermissionTo('teaching');
    }

    /**
     * Determina se l'utente può visualizzare i dettagli di uno specifico corso.
     */
    public function view(User $user, Course $course): bool
    {
        // 1. L'admin dei corsi può vedere qualsiasi corso
        if ($user->hasPermissionTo('manage all courses')) {
            return true;
        }

        // 2. Il docente può vedere solo i corsi di cui è insegnante
        if ($user->hasPermissionTo('teaching')) {
            return $course->teachers()->where('users.id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determina se l'utente può creare nuovi corsi.
     */
    public function create(User $user): bool
    {
        // Sia l'admin che un docente con permesso 'teaching' possono creare corsi
        return $user->hasPermissionTo('manage all courses') 
            || $user->hasPermissionTo('teaching');
    }

    /**
     * Determina se l'utente può modificare uno specifico corso.
     */
    public function update(User $user, Course $course): bool
    {
        // 1. Controllo Super Admin dei corsi
        if ($user->hasPermissionTo('manage all courses')) {
            return true;
        }

        // 2. Controllo Docente: solo se è associato a quel corso
        if ($user->hasPermissionTo('teaching')) {
            return $course->teachers()->where('users.id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determina se l'utente può eliminare uno specifico corso.
     */
    public function delete(User $user, Course $course): bool
    {
        if ($user->hasPermissionTo('manage all courses')) {
            return true;
        }

        if ($user->hasPermissionTo('teaching')) {
            return $course->teachers()->where('users.id', $user->id)->exists();
        }

        return false;
    }
}
