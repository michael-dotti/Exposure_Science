<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CorsiFactory> */
    use HasFactory;

    protected $guarded = [];

    public function teacher(): BelongsToMany
    {
        // Un Corso APPARTIENE A UN insegnante(=user=ricercatore)
        return $this->belongsToMany(User::class);
    }

    public function news():BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
