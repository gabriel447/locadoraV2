<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('movies', MovieController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('locacoes', LocacaoController::class);
Route::get('/devolucoes', [LocacaoController::class, 'devolucoes'])->name('devolucoes.index');
Route::put('/devolucoes/{id}', [LocacaoController::class, 'devolver'])->name('devolucoes.devolver');