@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bem-vindo!</div>

                <div class="card-body text-center">
                    <h2 class="text-center mb-4">Seja Bem-vindo {{ Auth::user()->name }}!</h2>
                    
                    <a href="{{ route('movies.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-film me-2"></i>
                        Gerenciar Filmes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .btn-lg {
        padding: 15px 30px;
        font-size: 1.2rem;
    }
    
    .card-body {
        padding: 3rem;
    }
</style>
@endpush
