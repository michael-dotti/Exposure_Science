<?php

use App\Http\Controllers\TeamPageController;
use App\Models\Article;
use App\Models\EventAttachment;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicationsPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsManagementController;
use App\Http\Controllers\EventManagementController;
use App\Http\Controllers\EventAttachmentController;

Route::controller(HomeController::class)->group( function (){
    Route::get('/', 'home');
});


Route::controller(TeamPageController::class)->group( function (){
    Route::get('/teamPage','index');
    Route::get('/teamPage/{user}', 'show');
});

Route::controller(PublicationsPageController::class)->group( function (){
    Route::get('/publications','index');
    Route::get('/publications/{article}', 'show');
});


Route::controller(NewsController::class)->group( function (){
    Route::get('/news', 'index');
    Route::get('/news/all', 'all');
    Route::get('/news/{news}', 'show');
});


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
        Route::get('/articles', 'index')->middleware('can:viewAny,' . Article::class);
        Route::get('/articles/create','create')->middleware('can:create,' . Article::class);
        Route::post('/articles', 'store')->middleware('can:create,' . Article::class);
        Route::get('/articles/{article}', 'show');
        Route::get('/articles/{article}/edit','edit');
        Route::patch("/articles/{article}", 'update');
        Route::delete('/articles/{article}','destroy');
        Route::get('/articles/{article}/download','download');
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
         Route::delete('/events/bulk-delete','bulkDelete');
         Route::delete('/events/{event}','destroy');
    });

    Route::get('/attachment/{eventAttachment}/download',[EventAttachmentController::class, 'download']);
 
    Route::middleware(['permission:management news'])->group(function (){
        Route::controller(NewsManagementController::class)->group(function () {
            Route::get('/news-management', 'index');
            Route::get('/news-management/create', 'create');
             Route::get('/news-management/{news}', 'show');
            Route::post('/news-management', 'store');
            Route::get('/news-management/{news}/edit','edit');
            Route::patch('/news-management/{news}','update');
            Route::delete('/news-management/{news}','destroy');
        });
    });

    Route::middleware(['permission:management events'])->group(function (){
        Route::controller(EventManagementController::class)->group(function () {
            Route::get('/events-management','index');
            Route::get('/events-management/create', 'create');
            Route::post('/events-management', 'store');
            Route::get('/events-management/{event}/edit','edit');
        });
    });

    Route::middleware(['permission:management users'])->group(function (){
        Route::view('/users-management','users-management.index');
    });

    Route::view('/projects','projects.index');
});

    
    
    

    

