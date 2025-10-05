<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    
   // protected $fillable = []; /*Do la possibilità di fare "mass assigned" agli attributi indicati nella quadra*/ 
     protected $guarded = [];// dico a queli campi bisogna fare attenzione nell'inizializzarli
    // Inserendo niente nelle quadre di “$guarded” ho praticamente disabilitato questa feature ( se non dico niente non devo controllare nessun campo)

}
