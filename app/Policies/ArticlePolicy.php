<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool 
    {
       return $user->hasPermissionTo('edit all articles') 
        || $user->hasPermissionTo('edit own articles')
        || $user->hasPermissionTo('write articles');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        // Se ha il permesso di gestire TUTTI gli articoli, può vederlo anche se non è l'autore
        if ($user->hasPermissionTo('edit all articles')) {
            return true;
        }

        // Altrimenti, può vederlo solo se è uno degli autori
        return $article->users()->where('users.id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('write articles');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
            // 1. Controllo "Super": Se hai il permesso di modificare TUTTO, salta le altre regole
            if ($user->hasPermissionTo('edit all articles')) {
                return true;
            }

            // 2. Controllo "Normale": Se ha il permesso di modificare SOLO i propri articoli
            if ($user->hasPermissionTo('edit own articles')) {
                // allora applichiamo la regola della Policy: deve essere tra gli autori
                return $article->users()->where('users.id', $user->id)->exists();
            }

            // 3. Se non ha nessuno dei due permessi, accesso negato.
            return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
            if ($user->hasPermissionTo('edit all articles')) {
                return true;
            }

            if ($user->hasPermissionTo('edit own articles')) {
                return $article->users()->where('users.id', $user->id)->exists();
            }

            return false;
    }

}
