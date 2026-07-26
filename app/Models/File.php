<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
}
