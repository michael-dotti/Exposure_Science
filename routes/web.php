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
use App\Http\Controllers\Admin\UserManagementController as AdminUserManagementController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\NewsManagementController as AdminNewsManagementController;

use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\EventManagementController as AdminEventManagementController;
use App\Http\Controllers\Admin\EventAttachmentController as AdminEventAttachmentController;

Route::controller(HomeController::class)->group( function (){
    Route::get('/', 'home');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('/public/projects','index');
    Route::get('/public/projects/{project}','show');
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
    Route::get('/public/news', 'index');
    Route::get('/public/news/all', 'all');
    Route::get('/public/news/{news}', 'show');
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
        Route::get('/admin/users/{user}/download','download');
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
         Route::get('/admin/events', 'index')->name('admin.events.index');
         Route::get('/admin/events/{event}', 'show')->name('admin.events.show');
         Route::delete('/admin/events/bulk-delete','bulkDelete')->name('admin.events.bulkDelete');
         Route::delete('/admin/events/{event}','destroy')->name('admin.events.destroy');
    });

    Route::middleware(['permission:management events'])->group(function (){
        Route::controller(AdminEventManagementController::class)->group(function () {
            Route::get('/admin/events-management','index')->name('admin.events-management.index');
            Route::get('/admin/events-management/create', 'create')->name('admin.events-management.create');
            Route::get('/admin/events-management/{event}','show')->name('admin.events-management.show');
            Route::post('/admin/events-management', 'store')->name('admin.events-management.store');
            Route::get('/admin/events-management/{event}/edit','edit')->name('admin.events-management.edit');
            Route::patch('/admin/events-management/{event}', 'update')->name('admin.events-management.update');
            Route::delete('/admin/events-management/bulk-delete','bulkDelete')->name('admin.events-management.bulkDelete');
            Route::delete('/admin/events-management/{event}', 'destroy')->name('admin.events-management.destroy');
        });
    });

    Route::get('/admin/attachment/{eventAttachment}/download',[AdminEventAttachmentController::class, 'download']);
 
    Route::middleware(['permission:management news'])->group(function (){
        Route::controller(AdminNewsManagementController::class)->group(function () {
            Route::get('/admin/news-management', 'index');
            Route::get('/admin/news-management/create', 'create');
            Route::get('/admin/news-management/{news}', 'show');
            Route::post('/admin/news-management', 'store');
            Route::get('/admin/news-management/{news}/edit','edit');
            Route::patch('/admin/news-management/{news}','update');
            Route::delete('/admin/news-management/{news}','destroy');
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
        Route::get('/admin/projects', 'index')->name('admin.projects.index');
        Route::get('/admin/projects/create', 'create')->name('admin.projects.create');
        Route::get('/admin/projects/{project}', 'show')->name('admin.projects.show');
        Route::post('/admin/projects', 'store')->name('admin.projects.store');
        Route::get('/admin/projects/{project}/edit','edit')->name('admin.projects.edit');
        Route::patch('/admin/projects/{project}', 'update')->name('admin.projects.update');
        Route::delete('/admin/projects/{project}', 'destroy')->name('admin.projects.destroy');
    });
    
    Route::middleware(['permission:management users'])->group(function (){
        Route::controller(AdminUserManagementController::class)->group( function (){
            Route::get('/admin/users-management','index');
        });
    });

    
});

    
    
    

    

