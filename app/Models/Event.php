<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $guarded = [];

    // user che ha creato l'evento
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id')->withTrashed();
    }

    // User collegati a questo evento
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('deleted_at')->withTimestamps()->withTrashed();
    }

    // metodo che lega Event ai suoi allegati che sono File
    public function attachments(): MorphMany
    {
        // Collega Event al modello File tramite il prefisso 'fileable'
        return $this->morphMany(File::class, 'fileable');
    }

    // Scope per filtrare gli eventi per tipo (sposta la logica di filtraggio qui)
    public function scopeFilterByType($query, $type)
    {
        if (empty($type)) { // se type è null o è una stringa vuota allora non filtro
            return $query;
        }
        
        return $query->where('events.type', $type);
    }

    protected static function booted()
    {   
        // un istante prima che l'evento venga eliminato esegui il codice nelle quadre
        static::deleting(function ($event){

            // Carica la relazione 'attachments' se non è già presente in memoria, cosi da evitare il Lazy Loading
            $event->loadMissing('attachments');

            // Cicla su tutti gli allegati e invoca il loro metodo delete()
            // Questo scatenerà l'evneto 'deleting' dentro il modello File che cancellerà il file fisico!
            if ($event->attachments){
                $event->attachments->each->delete();
            }
        });
    }
}
