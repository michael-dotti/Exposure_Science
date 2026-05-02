<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;

class PublicationsPageController extends Controller
{
    public function index(){
        $articles = Article::all();
        //$article = Article::find(1);
        //$users = $article->users;
        //dd($users->pluck('name'));
        //return view('publicationsPage.index', compact('articles'));
        return view('publicationsPage.index', ['articles' => Article::paginate(8)]);
    }

    public function show(Article $article){
        return view('publicationsPage.show', ['article'=> $article]);
    }
}