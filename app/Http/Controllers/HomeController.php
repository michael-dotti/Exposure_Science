<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\News;

class HomeController extends Controller
{
    public function home(){
        //$articles = Article::all();

        $news = News::latest()->take(3)->get();

        //$article = Article::find(1);
        //$users = $article->users;
        //dd($users);
        //return view('publicationsPage.index', compact('articles'));
        return view('home', ['news' => $news]);
    }
}
