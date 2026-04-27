<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class PublicationsPageController extends Controller
{
    public function index(){
        $articles = Article::all();
        //dd($articles);
        return view('publicationsPage.index', compact('articles'));
    }

    public function show(Article $article){
        return view('publicationsPage.show', ['article'=> $article]);
    }
}