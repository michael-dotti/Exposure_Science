<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProgettoFactory> */
    use HasFactory;

    protected $guarded = [];

    // gli utenti che lavorano a questo project
    public function users(): BelongsToMany  
    {
        return $this->belongsToMany(User::class)->withTrashed();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // un project può appartenere ad 1 o più aree di ricerca
    public function researchAreas(): BelongsToMany
    {
        return $this->belongsToMany(ResearchArea::class);
    }

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
