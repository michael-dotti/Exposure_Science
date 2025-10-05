<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    // Index = mostra tutti gli articoli
    public function index()
    {
        //
    }

    // create= porta alla view di creaizone di un articolo
    public function create()
    {
        //
    }

    //Show= porta alla view per vedere un singolo articolo
    public function show(Article $article)
    {
        //    
    }

    // store = esegue l'autenticazione e poi aggiunge un articolo
    public function store()
    {
        //
    }

    // edit =porta alla pagina di modifica articolo
    public function edit(Article $article)
    {
        //
    }

    // update = verifica e aggiorna un articolo
    public function update(Article $article)
    {
        //
    }

    // destroy = distrugge un articolo
    public function destroy(Article $article)
    {
        // 
    }
}
