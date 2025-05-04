<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Rotas de Filmes
    Route::resource('movies', MovieController::class);
    
    // Rotas de Clientes
    Route::resource('clientes', ClienteController::class);
    
    // Rotas de Locações
    Route::resource('locacoes', LocacaoController::class);
    
    // Rotas de Devoluções
    Route::get('/devolucoes', [LocacaoController::class, 'devolucoes'])->name('devolucoes.index');
    Route::put('/devolucoes/{id}', [LocacaoController::class, 'devolver'])->name('devolucoes.devolver');
});