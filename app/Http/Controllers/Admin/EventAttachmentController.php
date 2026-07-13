<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\EventAttachment;
use Illuminate\Support\Facades\Storage;

class EventAttachmentController extends Controller
{
    public function download(EventAttachment $eventAttachment)
    {

        // se non trovo il file genero un errore
       if (! Storage::disk('public')->exists($eventAttachment->file_path)) {
            abort(404, "File non trovato.");
       }

       // prendo il percorso del file
        $filePath = Storage::disk('public')->path($eventAttachment->file_path);

        // restituisco il file con il suo nome originale
        return response()->download(
            $filePath,
            $eventAttachment->file_name
        );
    }
}
