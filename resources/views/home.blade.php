@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Bem-vindo, {{ Auth::user()->name }}!</h1>
        <p>Selecione uma das opções abaixo para gerenciar sua locadora</p>
    </div>

    <div class="dashboard-cards">
        <a href="{{ route('movies.index') }}" class="dashboard-card card-filmes">
            <div class="dashboard-card-body">
                <i class="fas fa-film dashboard-card-icon"></i>
                <h3 class="dashboard-card-title">Filmes</h3>
                <p class="dashboard-card-text">Gerencie o catálogo de filmes disponíveis para locação</p>
            </div>
        </a>

        <a href="{{ route('clientes.index') }}" class="dashboard-card card-clientes">
            <div class="dashboard-card-body">
                <i class="fas fa-users dashboard-card-icon"></i>
                <h3 class="dashboard-card-title">Clientes</h3>
                <p class="dashboard-card-text">Cadastre e gerencie os clientes da locadora</p>
            </div>
        </a>

        <a href="{{ route('locacoes.index') }}" class="dashboard-card card-locacoes">
            <div class="dashboard-card-body">
                <i class="fas fa-handshake dashboard-card-icon"></i>
                <h3 class="dashboard-card-title">Locações</h3>
                <p class="dashboard-card-text">Registre e acompanhe as locações de filmes</p>
            </div>
        </a>

        <a href="{{ route('devolucoes.index') }}" class="dashboard-card card-devolucoes">
            <div class="dashboard-card-body">
                <i class="fas fa-undo-alt dashboard-card-icon"></i>
                <h3 class="dashboard-card-title">Devoluções</h3>
                <p class="dashboard-card-text">Registre as devoluções de filmes locados</p>
            </div>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush

@push('styles')
<link href="{{ asset('css/dashboard-custom.css') }}" rel="stylesheet">
@endpush