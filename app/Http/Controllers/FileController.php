<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function download($fileName): StreamedResponse
    {

        $path = Storage::disk('public')->path($fileName);


        dd([
            'File cercato' => $fileName,
            'Perc Compl' => $path,
            'Esiste' => Storage::disk('public')->exists($path)
        ]
        );


        if(Storage::disk('public')->exists($fileName)){
            return Storage::disk('public')->download($fileName);
        } else {
            abort(404, "File non trovato.");
        }
    }
}
