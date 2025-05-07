@extends('layouts.app')

@section('content')
<style>
html, body {
    height: 100vh;
    margin: 0;
}
#app {
    min-height: 100vh;
    background-color: #f8f9fa;
}
.card {
    margin-top: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
.btn-primary {
    padding: 0.75rem;
    font-size: 1rem;
    margin: 0.3rem 0;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
.card-body {
    padding: 1.5rem;
}
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h2 class="text-center mb-4">Bem-vindo {{ Auth::user()->name }}!</h2>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 px-2">
                            <a href="{{ route('movies.index') }}" class="btn btn-primary w-100">
                                Filmes
                            </a>
                        </div>
                        <div class="col-md-6 px-2">
                            <a href="{{ route('clientes.index') }}" class="btn btn-primary w-100">
                                Clientes
                            </a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 px-2">
                            <a href="{{ route('locacoes.index') }}" class="btn btn-primary w-100">
                                Locações
                            </a>
                        </div>
                        <div class="col-md-6 px-2">
                            <a href="{{ route('devolucoes.index') }}" class="btn btn-primary w-100">
                                Devoluções
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection