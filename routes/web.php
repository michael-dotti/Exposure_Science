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

use App\Http\Controllers\FileController;

use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\NewsManagementController as AdminNewsManagementController;

use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\EventManagementController as AdminEventManagementController;

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
    Route::get('/public/users','index')->name('public.users.index');
    Route::get('/public/users/{user}', 'show')->name('public.users.show');
});

Route::controller(ArticleController::class)->group( function (){
    Route::get('/public/articles','index')->name('public.articles.index');
    Route::get('/public/articles/{article}', 'show')->name('public.articles.show');
});


Route::controller(NewsController::class)->group( function (){
    Route::get('/public/news', 'index');
    Route::get('/public/news/all', 'all');
    Route::get('/public/news/{news}', 'show');
});

Route::controller(FileController::class)->group( function () {
    Route::get('/files/{file}/download', 'download')->name('files.download');
    Route::get('/files/{file}/show', 'show')->name('files.show');
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
        Route::get('/admin/users/show','show')->name('admin.users.index');
        Route::get('/admin/users/edit','edit')->name('admin.users.edit');
        Route::patch('/admin/users/{user}', 'update')->name('admin.users.update');
    });

    Route::controller(AdminArticleController::class)->group(function () {
        Route::get('/admin/articles', 'index')->middleware('can:viewAny,' . Article::class)->name('admin.articles.index');
        Route::get('/admin/articles/create','create')->middleware('can:create,' . Article::class)->name('admin.articles.create');
        Route::post('/admin/articles', 'store')->middleware('can:create,' . Article::class)->name('admin.articles.store');
        Route::get('/admin/articles/{article}', 'show')->name('admin.articles.show');
        Route::get('/admin/articles/{article}/edit','edit')->name('admin.articles.edit');
        Route::patch("/admin/articles/{article}", 'update')->name('admin.articles.update');
        Route::delete('/admin/articles/{article}','destroy')->name('admin.articles.destroy');
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
            Route::delete('/admin/events-management/bulk-delete','bulkDelete')->name('admin.events-management.bulkDelete');
            Route::delete('/admin/events-management/{event}', 'destroy')->name('admin.events-management.destroy');
        });
    });
    
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

    

    Route::middleware(['permission:teaching'])->group(function () {
        Route::controller(AdminCoursesController::class)->group(function () {
            Route::get('/admin/courses', 'index')->name('admin.courses.index');
            Route::get('/admin/courses/create', 'create')->name('admin.courses.create');
            Route::post('/admin/courses', 'store')->name('admin.courses.store');
    
            Route::get('/admin/courses/{course}', 'show')->name('admin.courses.show');
            Route::get('/admin/courses/{course}/edit', 'edit')->name('admin.courses.edit');
            Route::patch('/admin/courses/{course}', 'update')->name('admin.courses.update');
            Route::delete('/admin/courses/{course}', 'destroy')->name('admin.courses.destroy');
        });
    });

    Route::controller(AdminProjectController::class)->group( function (){
        Route::get('/admin/projects', 'index')->name('admin.projects.index');
        Route::get('/admin/projects/create', 'create')->name('admin.projects.create')->middleware(['permission:management projects']);
        Route::get('/admin/projects/{project}', 'show')->name('admin.projects.show');
        Route::post('/admin/projects', 'store')->name('admin.projects.store');
        Route::get('/admin/projects/{project}/edit','edit')->name('admin.projects.edit')->middleware(['permission:management projects']);
        Route::patch('/admin/projects/{project}', 'update')->name('admin.projects.update');
        Route::delete('/admin/projects/{project}', 'destroy')->name('admin.projects.destroy');
    });
    
    Route::middleware(['permission:management users'])->group(function (){
        Route::controller(AdminUserManagementController::class)->group( function (){
            Route::get('/admin/users-management','index')->name('admin.users-management.index');
            Route::get('/admin/users-management/create','create')->name('admin.users-management.create');
            Route::get('/admin/users-management/{user}','show')->name('admin.users-management.show'); // decidere se è necessari oimplementare view user.index per user-management
            Route::post('/admin/users-management','store')->name('admin.users-management.store');
            Route::patch('/admin/users-management/{user}', 'update')->name('admin.users-management.update'); // per cambiare i permessi degli utenti in index
            Route::delete('/admin/users-management/{user}','destroy')->name('admin.users-management.destroy');
        });
    });

    
});

    
    
    

    

