<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventAttachment extends Model
{
    protected $fillable = ['file_name','file_path'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /*
     metodo che recupera l'estensione del file.
    */
     public function getExtensionAttribute()
     {
        // estrae l'estensioen dal nome del file e la converte in minuscolo
        return strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
     }

     /**
      * 
      * Recuepra il peso del file in MB
      */
     public function getSizeInMbAttribute()
     {
        try {
            $bytes = Storage::disk('public')->size($this->file_path);
            $megabytes = $bytes / (1024 * 1024);

            return number_format($megabytes, 2);
        }
        catch(\Exception $e) {
            // se il file non esiste o c'è un errore, ritorna 0.00
            return '0.00';
        }
     }
}
