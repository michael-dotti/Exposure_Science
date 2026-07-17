<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\News;

class HomeController extends Controller
{
    public function home(){

        //mostro nella home le tre notizie più recenti
        $news = News::latest()->take(3)->get();

        return view('public.home', ['news' => $news]);
    }
}
