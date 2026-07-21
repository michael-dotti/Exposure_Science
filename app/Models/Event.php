<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $guarded = [];

    // user che ha creato l'evento
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    // User collegati a questo evento
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('deleted_at')->withTimestamps();;
    }

    public function attachments()
    {
        return $this->hasMany(EventAttachment::class);
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


            foreach($event->attachments as $attachment) {
                if (Storage::disk('public')->exists($attachment->file_path) && ($attachment->file_path != 'uploads/events/attachments/default_piano_di_studi_triennale_Ingegneria.pdf')){
                    Storage::disk('public')->delete($attachment->file_path);
                }
                 $attachment->delete();
            }
        });
    }
}
