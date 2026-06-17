<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\ResearchArea;

class PublicationsPageController extends Controller
{
    public function index(){

        // 1. Recupera gli articoli usando l'Eager Loading per pre-caricare utenti e aree
        $articles = Article::with(['users', 'researchAreas'])->paginate(8);

        // 2. Recupera i dati per le select/tendine dei filtri
        $users = User::all();
        $areas = ResearchArea::all();
       

        return view('publicationsPage.index', compact('articles', 'users', 'areas'));
    }

    public function authorFiltered($id){
        $articles = User::findOrFail($id)->articles()->with(['users', 'researchAreas']);
        $users = User::all();
        $areas = ResearchArea::all();

        return view('publicationsPage.index', ['articles' => $articles->paginate(8)])->with('users', $users)->with('areas', $areas);
    }

    public function areaFiltered($id){
        $articles = ResearchArea::findOrFail($id)->articles()->with(['users', 'researchAreas']);
        $users = User::all();
        $areas = ResearchArea::all();

        return view('publicationsPage.index', ['articles' => $articles->paginate(8)])->with('users', $users)->with('areas', $areas);
    }

    /*public function search(Request $request){
        //$articles = Article::all();
        //dd($request->input('search'));

        $articles = Article::where('title', 'LIKE', $request->input('title') . '*')->get()->paginate(8);

        //$article = Article::find(1);
        //$users = $article->users;
        //dd($articles);
        //return view('publicationsPage.index', compact('articles'));
        return view('publicationsPage.index', ['articles' => $articles]);
    }*/

    public function show(Article $article){
        return view('publicationsPage.show', ['article'=> $article]);
    }
}