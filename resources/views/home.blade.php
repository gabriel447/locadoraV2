@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card main-card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-center mb-5 welcome-text">Bem-vindo {{ Auth::user()->name }}!</h3>

                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('movies.index') }}" class="text-decoration-none">
                                <div class="menu-button">
                                    <p class="fs-4 mb-0">Filmes</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('clientes.index') }}" class="text-decoration-none">
                                <div class="menu-button">
                                    <p class="fs-4 mb-0">Clientes</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('locacoes.index') }}" class="text-decoration-none">
                                <div class="menu-button">
                                    <p class="fs-4 mb-0">Locações</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection