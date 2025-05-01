<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
})->middleware('guest');

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
