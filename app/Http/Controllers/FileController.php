<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function download(File $file)
    {
        // 1) Verifico che il file esista, altrimenti genero un errore
        if (! Storage::disk('public')->exists($file->file_path)) {
                abort(404, "File non trovato.");
        }

        // 2) Controllo che l'utente possa scaricare il file

        $parent = $file->fileable; // recupero il model collegato a questo file

        // Se il file appartiene ad un evneto è una comunicazione interna privata, quindi
        // l'utente può accedere al file solo se: è loggato AND (è il creatore OR è un destinatario)
        if ($parent instanceof Event) {

            // verifico se l'utente è loggato
            if (!Auth::check()) {
                abort(404, 'Devi effettuare il login per scaricare questo file');
            }

            // verifoc se lutente loggato è il creatore o è tra i destinatari
            $user = Auth::user();
            $isCreator = $parent->creator_user_id === $user->id;
            $isRecipient = $parent->recipients()->where('user_id', $user->id)->exists();

            if (!$isCreator && !$isRecipient) {
                abort(403,'Non Hai i Permessi per scaricare questo allegato');
            }
        }

        // il documento dell'articolo può essere scaricato da chiunque, quindi non serve fare questo controllo

        // 3) Restituisco il file
        $fullPath = Storage::disk('public')->path($file->file_path);
        return response()->download($fullPath, $file->file_name);
    }
}
