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
        if ($user->hasPermissionTo('manage all projects')) {
            return true;
        }

        $isCreator = $project->creator_id === $user->id;
        $isCollaborator = $project->collaborators()->where('users.id', $user->id)->exists();

        return $isCreator || $isCollaborator;
    }

    /**
     * Chi può creare nuovi progetti?
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create projects');
    }

    /**
     * Chi può modificare uno specifico progetto?
     */
    public function update(User $user, Project $project): bool
    {
        if ($user->hasPermissionTo('manage all projects')) {
            return true;
        }

        // Usa 'manage my projects' come definito nel Seeder
        if ($user->hasPermissionTo('manage my projects')) {
            return $project->creator_id === $user->id;
        }

        return false;
    }

    /**
     * Chi può eliminare uno specifico progetto?
     */
    public function delete(User $user, Project $project): bool
    {
        if ($user->hasPermissionTo('manage all projects')) {
            return true;
        }

        // Usa 'manage my projects' come definito nel Seeder
        if ($user->hasPermissionTo('manage my projects')) {
            return $project->creator_id === $user->id;
        }

        return false;
    }
}
