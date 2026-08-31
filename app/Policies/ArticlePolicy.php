<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Tutti gli utenti loggati possono vedere la lista articoli.
     */
    public function viewAny(User $user): bool 
    {
        return true;
    }

    /**
     * Chi può vedere il dettaglio di uno specifico articolo.
     */
    public function view(User $user, Article $article): bool
    {
        if ($user->hasPermissionTo('edit all articles')) {
            return true;
        }

        return $article->users()->where('users.id', $user->id)->exists();
    }

    /**
     * Tutti gli utenti loggati possono creare un articolo.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Chi può modificare un articolo (Admin/Articles Admin OPPURE autore dell'articolo).
     */
    public function update(User $user, Article $article): bool
    {
        // 1. L'admin/articles admin può modificare qualsiasi articolo
        if ($user->hasPermissionTo('edit all articles')) {
            return true;
        }

        // 2. Qualsiasi altro utente registrato può modificare SOLO i propri articoli
        return $article->users()->where('users.id', $user->id)->exists();
    }

    /**
     * Chi può eliminare un articolo (Admin/Articles Admin OPPURE autore dell'articolo).
     */
    public function delete(User $user, Article $article): bool
    {
        if ($user->hasPermissionTo('edit all articles')) {
            return true;
        }

        return $article->users()->where('users.id', $user->id)->exists();
    }

}
