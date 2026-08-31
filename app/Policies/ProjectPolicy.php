<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Chi può vedere il dettaglio di uno SPECIFICO progetto?
     */
    public function view(User $user, Project $project): bool
    {
        // 1. Admin vede tutto
        if ($user->hasPermissionTo('manage all projects')) {
            return true;
        }

        // 2. PM e Researcher possono vederlo se ne sono creatori o collaboratori
        $isCreator = $project->author_id === $user->id;
        $isCollaborator = $project->collaborators()->where('users.id', $user->id)->exists();

        return $isCreator || $isCollaborator;
    }

    /**
     * Chi può creare nuovi progetti?
     */
    public function create(User $user): bool
    {
        // Solo Admin e PM
        return $user->hasPermissionTo('manage all projects') 
            || $user->hasPermissionTo('manage own projects');
    }

    /**
     * Chi può modificare uno SPECIFICO progetto?
     */
    public function update(User $user, Project $project): bool
    {
        // 1. Admin modifica tutto
        if ($user->hasPermissionTo('manage all projects')) {
            return true;
        }

        // 2. PM modifica SOLO se è l'autore (Researcher viene bloccato in automatico perché non ha questo permesso)
        if ($user->hasPermissionTo('manage own projects')) {
            return $project->author_id === $user->id;
        }

        return false;
    }

    /**
     * Chi può eliminare uno SPECIFICO progetto?
     */
    public function delete(User $user, Project $project): bool
    {
        if ($user->hasPermissionTo('manage all projects')) {
            return true;
        }

        if ($user->hasPermissionTo('manage own projects')) {
            return $project->author_id === $user->id;
        }

        return false;
    }
}
