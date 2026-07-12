<?php

use App\Http\Controllers\TeamPageController;
use App\Models\Article;
use App\Models\EventAttachment;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController as PublicArticleController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

use App\Http\Controllers\CoursesController as PublicCoursesController;
use App\Http\Controllers\Admin\CoursesController as AdminCoursesController;

use App\Http\Controllers\UserController as PublicUserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\EventController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsManagementController;
use App\Http\Controllers\EventManagementController;
use App\Http\Controllers\EventAttachmentController;

Route::controller(HomeController::class)->group( function (){
    Route::get('/', 'home');
});

Route::controller(PublicCoursesController::class)->group( function (){
    Route::get('/public/courses', 'index');
    Route::get('/public/courses/{course}', 'show');
});

Route::controller(PublicUserController::class)->group( function (){
    Route::get('/public/users','index');
    Route::get('/public/users/{user}', 'show');
});

Route::controller(PublicArticleController::class)->group( function (){
    Route::get('/public/articles','index');
    Route::get('/public/articles/{article}', 'show');
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
    
    
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/admin/users/show','show');
        Route::get('/admin/users/edit','edit');
        Route::patch('/admin/users/{user}', 'update');
    });

    Route::controller(AdminArticleController::class)->group(function () {
        Route::get('/admin/articles', 'index')->middleware('can:viewAny,' . Article::class);
        Route::get('/admin/articles/create','create')->middleware('can:create,' . Article::class);
        Route::post('/admin/articles', 'store')->middleware('can:create,' . Article::class);
        Route::get('/admin/articles/{article}', 'show');
        Route::get('/admin/articles/{article}/edit','edit');
        Route::patch("/admin/articles/{article}", 'update');
        Route::delete('/admin/articles/{article}','destroy');
        Route::get('/admin/articles/{article}/download','download');
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
            Route::get('/events-management/{event}','show');
            Route::post('/events-management', 'store');
            Route::get('/events-management/{event}/edit','edit');
            Route::patch('/events-management/{event}', 'update');
            Route::delete('/events-management/{event}', 'destroy');
        });
    });

    Route::middleware((['permission:teaching']))->group(function (){
        Route::controller(AdminCoursesController::class)->group( function (){
            Route::get('/admin/courses', 'index');
            Route::get('/admin/courses/{course}', 'show');
        });
    });

    Route::middleware(['permission:management users'])->group(function (){
        Route::view('/users-management','users-management.index');
    });

    Route::view('/projectsPrivate','projectsPrivate.index');
});

    
    
    

    

