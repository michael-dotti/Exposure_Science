<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'home');
Route::view('/team', 'team');
Route::view('/publications', 'publications');
Route::view('/news-and-events', 'news-and-events');

// CIAO A TUTTI
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
