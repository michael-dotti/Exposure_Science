<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    
    public function view(?User $user, File $file): Response
    {
        $parent = $file->fileable; // recupero il model collegato a questo file

        // se un file appartiene a un evento, applico le restrizioni
        if ($parent instanceof Event) {
            
            // 1) controllo che l'utente sia loggato
            if(!$user){
                return Response::deny('Devi effettuare il login per scaricare questo file');
            }

            // 2) // verifico se l'utente loggato è il creatore o è tra i destinatari
            $isCreator = $parent->creator_user_id === $user->id;
            $isRecipient = $parent->recipients()->where('user_id', $user->id)->exists();

            if (!$isCreator && !$isRecipient) {
                return Response::deny('Non Hai i Permessi per scaricare questo allegato');
            }

        }

        return Response::allow();
    }

    
}
