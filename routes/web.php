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

    Route::controller(ArticleController::class)->group(function () {
        Route::get('/articles',  'index');
        Route::get('/articles/create',  'create');
        Route::get('/articles/{article}', 'show');
        Route::post('articles', 'store');
        Route::get('/articles/{article}/edit','edit');
        Route::patch("/articles/{article}", 'update');
        Route::delete('/articles/{article}','destroy');

    });
    

    Route::view('/projects','project.index');
    Route::view('/events', 'event.index');
    Route::view('/user-management','users-management.index');
    Route::view('/news-management','news.index');
    Route::view('/event-management','events-management-index');

    
});
