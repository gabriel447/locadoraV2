@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Gerenciar Filmes</h5>
                                    <p class="card-text">Adicione, edite ou remova filmes do catálogo.</p>
                                    <a href="{{ route('movies.index') }}" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Gerenciar Clientes</h5>
                                    <p class="card-text">Adicione, edite ou remova clientes do sistema.</p>
                                    <a href="{{ route('clientes.index') }}" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
