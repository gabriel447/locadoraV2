@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h2 class="text-center mb-4">Bem-vindo Gabe!</h2>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <a href="{{ route('movies.index') }}" class="btn btn-primary w-100">
                                Filmes
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('clientes.index') }}" class="btn btn-primary w-100">
                                Clientes
                            </a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('locacoes.index') }}" class="btn btn-primary w-100">
                                Locações
                            </a>
                        </div>
                        <div class="col-md-6">
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