<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $guarded = [];

    // user che ha creato l'evento
    public function user_owner()
    {
        // Un Corso APPARTIENE A UN Utente
        return $this->belongsTo(User::class);
    }

    // User collegati a questo evento
    public function users_related_to_this_event(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
