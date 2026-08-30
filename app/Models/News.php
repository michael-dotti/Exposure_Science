<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    /** @use HasFactory<\Database\Factories\NewsFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * Ordina le notizie in base alla data di creazione (default: latest/desc)
     */
    public function scopeSortByDate(Builder $query, ?string $direction = 'desc'): Builder
    {
        if ($direction === 'oldest') {
            return $query->oldest(); // Equivalente a orderBy('created_at', 'asc')
        }

        return $query->latest(); // Equivalente a orderBy('created_at', 'desc')
    }
}
