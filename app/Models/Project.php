<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProgettoFactory> */
    use HasFactory;

    protected $guarded = [];

    // gli utenti che lavorano a questo project
    public function projects(): BelongsToMany  
    {
        return $this->belongsToMany(User::class);
    }
}
