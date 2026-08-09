<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    /**
     * Ottiene il modello proprietario dell'allegato (Event, Article, ecc.)
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }


    public function getExtensionAttribute()
    {
        // strtolower() converte tutto in minuscolo
        // pathinfo() prende una stringa e ne estrae solo l'estensione finale (es: .PDF)
        return strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
    }

    // ritorna la dimensione del file in MB
    public function getSizeInMbAttribute()
    {
        // Se la colonna nel DB è vuota, ritorna 0
        if (!$this->file_size) {
            return '0.00';
        }

        // Usa il valore già presente nel DB 
        $megabytes = $this->file_size / (1024 * 1024);
        
        return number_format($megabytes, 2);
    }

    protected static function booted()
    {
        // Un istante prima che un record 'file' venga eliminato dal DB
        static::deleting(function ($file){
            // elimina fisicamente il file dallo storage
            if (Storage::disk('public')->exists($file->file_path) && ($file->file_path != 'uploads/events/attachments/default_piano_di_studi_triennale_Ingegneria.pdf')){
                Storage::disk('public')->delete($file->file_path);
            }
        });
    }
}
