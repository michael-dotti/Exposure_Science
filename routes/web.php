<?php

use App\Http\Controllers\TeamPageController;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicationsPageController;
use App\Http\Controllers\FileController;

Route::view('/', 'home');


Route::controller(TeamPageController::class)->group( function (){
    Route::get('/teamPage','index');
    Route::get('/teamPage/{user}', 'show');
});

Route::controller(PublicationsPageController::class)->group( function (){
    Route::get('/publications','index');
    //Route::get('/publications/search','search');
    Route::get('/publications/{article}', 'show');
});

Route::controller(FileController::class)->group( function (){
    Route::get('/download/{fileName}', 'download');
});


//Route::view('/publications', 'publications');
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
        Route::get('/articles', 'index');
        Route::get('/articles/create','create');
        Route::post('/articles', 'store');
        Route::get('/articles/{article}', 'show');
        Route::get('/articles/{article}/edit','edit');
        Route::patch("/articles/{article}", 'update');
        Route::delete('/articles/{article}','destroy');
    });
    
    Route::controller(UserController::class)->group(function () {
        Route::patch('/dashboard/{user}', 'update');
    });

    Route::controller(EventController::class)->group(function () {
         Route::get('/events', 'index');
         Route::get('/events/create', 'create');
         Route::get('/events/{event}', 'show');
         Route::post('/events', 'store');
         Route::get('/events/{event}/edit', 'edit');
         Route::patch('/events/{event}','update');
         Route::delete('/events/{event}','destroy');
    });

    Route::view('/projects','project.index');
    Route::view('/user-management','users-management.index');
    Route::view('/news-management','news.index');
    Route::view('/event-management','events-management-index');

    
});
