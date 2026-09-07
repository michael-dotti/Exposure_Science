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
    public function index()
    {
        //mostro nella home le tre notizie più recenti
        $news = News::latest()->take(5)->get();

        return view('public.news.index', ['news' => $news]);
    }

    public function all(Request $request)
    {
        //mostro nella home le tre notizie più nuove
        $news = News::sortByDate($request->query('sort', 'desc'))
            ->paginate(12)
            ->withQueryString();

        return view('public.news.all', ['news' => $news]);
    }

    public function show(News $news)
    {
        return view('public.news.show', ['n'=> $news]);
    }
}
