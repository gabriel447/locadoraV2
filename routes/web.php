<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->middleware('auth');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Rotas de Filmes
    Route::resource('movies', MovieController::class);
    
    // Rotas de Clientes
    Route::resource('clientes', ClienteController::class);
    
    // Rotas de Locações e Devoluções
    Route::resource('locacoes', LocacaoController::class);
    Route::get('/devolucoes', [LocacaoController::class, 'devolucoes'])->name('devolucoes.index');
    Route::post('/devolucoes/confirmar', [LocacaoController::class, 'confirmarDevolucao'])->name('devolucoes.confirmar');
    Route::get('/devolucoes/historico', [LocacaoController::class, 'historico'])->name('devolucoes.historico');
    Route::post('/devolucoes/store', [LocacaoController::class, 'confirmarDevolucao'])->name('devolucoes.store');
});