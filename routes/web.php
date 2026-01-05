<?php

use App\Models\Article;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::view('/', 'home');
Route::view('/team', 'team');
Route::view('/publications', 'publications');
Route::view('/news-and-events', 'news-and-events');


/*
Route::get('/', function () {
    
    return view('home');
});
*/
Route::middleware([ 
    'auth:sanctum', // solo utenti autenticati possono accedere a queste rotte
    config('jetstream.auth_session'), // applica un middleware fornito da Jetstream che gestisce la sessione di autenticazione.
    'verified', // assicura che l'utente abbia verificato la propria email prima di accedere.
])->group(function () { // definizione di un'insieme di rotte che avranno tutte quante il middleware sopra
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard'); // do come nome alla rotta "dashboard"

    Route::get('/article', [ArticleController::class, 'index']);
    Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create');
    
    Route::view('/project','project.index');
    Route::view('/event', 'event.index');
    Route::view('/user-management','users-management.index');
    Route::view('/news-management','news.index');
    Route::view('/event-management','events-management-index');

    
});
