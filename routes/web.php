<?php

use App\Http\Controllers\TeamPageController;
use App\Models\Article;
use App\Models\EventAttachment;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\Admin\CoursesController as AdminCoursesController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsManagementController;

use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\EventManagementController as AdminEventManagementController;
use App\Http\Controllers\Admin\EventAttachmentController as AdminEventAttachmentController;

Route::controller(HomeController::class)->group( function (){
    Route::get('/', 'home');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('/public/projects','index');
    Route::get('/public/projects/{projects}','show');
});

Route::controller(CoursesController::class)->group( function (){
    Route::get('/public/courses', 'index');
    Route::get('/public/courses/{course}', 'show');
});

Route::controller(UserController::class)->group( function (){
    Route::get('/public/users','index');
    Route::get('/public/users/{user}', 'show');
});

Route::controller(ArticleController::class)->group( function (){
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

    Route::controller(AdminEventController::class)->group(function () {
         Route::get('/admin/events', 'index');
         Route::get('/admin/events/{event}', 'show');
         Route::delete('/admin/events/bulk-delete','bulkDelete');
         Route::delete('/admin/events/{event}','destroy');
    });

    Route::middleware(['permission:management events'])->group(function (){
        Route::controller(AdminEventManagementController::class)->group(function () {
            Route::get('/admin/events-management','index');
            Route::get('/admin/events-management/create', 'create');
            Route::get('/admin/events-management/{event}','show');
            Route::post('/admin/events-management', 'store');
            Route::get('/admin/events-management/{event}/edit','edit');
            Route::patch('/admin/events-management/{event}', 'update');
            Route::delete('/admin/events-management/{event}', 'destroy');
        });
    });

    Route::get('/admin/attachment/{eventAttachment}/download',[AdminEventAttachmentController::class, 'download']);
 
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

    

    Route::middleware((['permission:teaching']))->group(function (){
        Route::controller(AdminCoursesController::class)->group( function (){
            Route::get('/admin/courses', 'index');
            Route::get('/admin/courses/create', 'create');
            Route::get('/admin/courses/{course}', 'show');
            Route::post('/admin/courses', 'store');
            Route::get('/admin/courses/{event}/edit','edit');
            Route::patch('/admin/courses/{event}', 'update');
            Route::delete('/admin/courses/{event}', 'destroy');
        });
    });

    Route::controller(AdminProjectController::class)->group( function (){
        Route::get('/admin/projects', 'index');
        Route::get('/admin/projects/create', 'create');
        Route::get('/admin/projects/{projects}', 'show');
        Route::post('/admin/project', 'store');
        Route::get('/admin/project/{event}/edit','edit');
        Route::patch('/admin/project/{event}', 'update');
        Route::delete('/admin/project/{event}', 'destroy');
    });
    
    Route::middleware(['permission:management users'])->group(function (){
        Route::view('/admin/users-management','admin.users-management.index');
    });

    
});

    
    
    

    

