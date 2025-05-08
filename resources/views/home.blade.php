@extends('layouts.app')

@section('content')
<style>
body {
    background-color: #fff !important;
    min-height: 100vh;
}
.card {
    margin: 2rem auto;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    max-width: 1200px;
}
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 15px;
}
.card-header {
    font-size: 1rem;
}
h2 {
    font-size: 1.5rem !important;
}
.btn {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body mb-2">
                    <h2 class="text-center mb-4">Bem-vindo {{ Auth::user()->name }}!</h2>
                    
                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-3 px-2">
                            <a href="{{ route('movies.index') }}" class="btn btn-primary w-100">
                                Filmes
                            </a>
                        </div>
                        <div class="col-md-3 px-2">
                            <a href="{{ route('clientes.index') }}" class="btn btn-primary w-100">
                                Clientes
                            </a>
                        </div>
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-3 px-2">
                            <a href="{{ route('locacoes.index') }}" class="btn btn-primary w-100">
                                Locações
                            </a>
                        </div>
                        <div class="col-md-3 px-2">
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