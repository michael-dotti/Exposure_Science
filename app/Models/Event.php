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
    public function creator()
    {
        // Un Corso APPARTIENE A UN Utente
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    // User collegati a questo evento
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function documents()
    {
        return $this->hasMany(EventDocument::class);
    }

    // Scope per filtrare gli eventi per tipo (sposta la logica di filtraggio qui)
    public function scopeFilterByType($query, $type)
{
    if ($type) {
        return $query->where('events.type', $type);
    }
    return $query;
}
}
