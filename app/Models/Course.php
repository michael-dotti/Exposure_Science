<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CorsiFactory> */
    use HasFactory;

    protected $guarded = [];

    public function insegnante()
    {
        // Un Corso APPARTIENE A UN insegnante(=user=ricercatore)
        return $this->belongsTo(User::class);
    }
}
