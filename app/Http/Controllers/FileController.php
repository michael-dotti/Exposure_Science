<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    // definisco questo array per risolvere il problema che fa si che il brwoser aprà la versione precedente del file perché ha slavato in cache quel file per quel specifico url
    private array $noCacheHeaders = [
        'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
        'Pragma'        => 'no-cache',
        'Expires'       => '0',
    ];

    public function download(File $file)
    {
        // 1) Controllo permessi tramite Policy
        Gate::authorize('view', $file);

        //2) Verifico che il file esista nel disco
        if (! Storage::disk('public')->exists($file->file_path)) {
                abort(404, "File non trovato.");
        }
        
        
        // 3) Restituisco il file in download
        $fullPath = Storage::disk('public')->path($file->file_path);
        return response()->download($fullPath, $file->file_name, $this->noCacheHeaders);
    }


    // metodo per visualizzare il file
    public function show(File $file)
    {
        // 1) Controllo permessi tramite Policy
        Gate::authorize('view', $file);

        //2) Verifico che il file esista nel disco
        if (! Storage::disk('public')->exists($file->file_path)) {
                abort(404, "File non trovato.");
        }

        // 3) Restituisco il file per la visualizzazione nel browser
        $fullPath = Storage::disk('public')->path($file->file_path);

        return response()->file($fullPath, $this->noCacheHeaders);
    }
}
