<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;

class PublicationsPageController extends Controller
{
    public function index(){
        $articles = Article::all();

        //$articles = DB::select('select * from articles');

        //$article = Article::find(1);
        //$users = $article->users;
        //dd($users->pluck('name'));
        //return view('publicationsPage.index', compact('articles'));
        return view('publicationsPage.index', ['articles' => Article::simplePaginate(8)]);
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