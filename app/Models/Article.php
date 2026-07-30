<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    
   // protected $fillable = []; /*Do la possibilità di fare "mass assigned" agli attributi indicati nella quadra*/ 
     protected $guarded = [];// dico a queli campi bisogna fare attenzione nell'inizializzarli
    // Inserendo niente nelle quadre di “$guarded” ho praticamente disabilitato questa feature ( se non dico niente non devo controllare nessun campo)


    /**
     * Gli utenti che possiedono/hanno accesso a questo articolo.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    // area di ricerca a cui appartiene l'articolo
    public function researchAreas(): BelongsToMany
    {
        return $this->belongsToMany(ResearchArea::class);
    }

    public function document()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function scopeFilterByUser($query,$userId) // Nota bene: la differenza con il filtraggio per Tipo in event, è che in event il tipo è una colonna della tabella event, inve User non è una colonna in article ma è collegat ad essa tramite una tabella intermedia articles_users perché sono in una relaizone molti a molti 
    {   
        if(empty($userId))
        {
            return $query;
        }
        return $query->whereRelation('users', 'users.id', $userId);
        /*
        $query = costruttore della query passato direttamente
        metodo whereRelation:
            primo elemento = users = nome della relazione
            secondo elemento = user.id = nome colonna della tabella finale
            terzo elemento = $userID =valore che vuoi cercare
        */
    }

    public function scopeFilterByArea($query,$areaId) 
    {   
        if(empty($areaId))
        {
            return $query;
        }
        return $query->whereRelation('researchAreas', 'research_areas.id', $areaId);
    }

    protected static function booted()
    {   
        // un istante prima che l'articolo venga eliminato esegui il codice nelle quadre
        static::deleting(function ($article){

            // Carica la relazione 'document' se non è già presente in memoria, cosi da evitare il Lazy Loading
            $article->loadMissing('document');

            $article->document->each->delete();
        });
    }
}
