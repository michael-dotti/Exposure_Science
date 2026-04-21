<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class PublicationsPageController extends Controller
{
    public function index(){
        $articles = Article::all();
        dd($articles);
        return view('publicationPage.index', compact('articles'));
    }
}