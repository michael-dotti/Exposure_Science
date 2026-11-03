<?php

namespace App\Models;

use App\Enums\ResearchAreaType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Article;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ResearchArea extends Model
{
    /** @use HasFactory<\Database\Factories\ResearchAreaFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description'];
    
    // un'area di ricerca può essere associata a più project
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    // articoli di questa area di ricerca
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public function getEnumDescription(): string
    {
        return ResearchAreaType::tryFrom($this->name)?->description() 
               ?? 'Nessuna descrizione disponibile.';
    }
}
