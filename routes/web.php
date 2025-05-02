<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
})->middleware('guest');

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/movies', [App\Http\Controllers\MovieController::class, 'index'])->name('movies.index');
Route::post('/movies', [App\Http\Controllers\MovieController::class, 'store'])->name('movies.store');