<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;

class PublicationsPageController extends Controller
{
    public function index(){
        //$articles = Article::all();

        $articles = DB::select('select * from articles');
        $users = User::all();

        //$article = Article::find(1);
        //$users = $article->users;
        //dd($users);
        //return view('publicationsPage.index', compact('articles'));
        return view('publicationsPage.index', ['articles' => Article::paginate(8)])->with('users', $users);
    }

    public function authorFiltered($id){

        //dd(User::find($id));

        $articles = User::find($id)->articles();
        $users = User::all();

        return view('publicationsPage.index', ['articles' => $articles->paginate(8)])->with('users', $users);
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