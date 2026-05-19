<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\ResearchArea;
use App\Models\News;

class NewsController extends Controller
{
    public function index(){
        
        //mostro nella home le tre notizie più nuove
        $news = News::latest()->get();

        //$article = Article::find(1);
        //$users = $article->users;
        //dd($users);
        //return view('publicationsPage.index', compact('articles'));
        return view('newsPage.index', ['news' => $news]);
    }
}
