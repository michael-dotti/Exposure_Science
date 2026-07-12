<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\ResearchArea;

class ArticleController extends Controller
{
    public function index(Request $request){

        // 1. Recupera gli articoli usando l'Eager Loading per pre-caricare utenti e aree
        $articles = Article::with(['users', 'researchAreas'])
            ->filterByArea($request->query('areaId'))
            ->filterByUser($request->query('userId'))
            ->latest()
            ->paginate(8);

        // 2. Recupera i dati per le select/tendine dei filtri
        $users = User::all();
        $areas = ResearchArea::all();

        return view('public.articles.index', compact('articles', 'users', 'areas'));
    }

    public function show(Article $article){
        return view('public.articles.show', ['article'=> $article]);
    }
}