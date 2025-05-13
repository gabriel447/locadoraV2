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
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Filmes</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMovieModal">
                        Adicionar Filme
                    </button>
                </div>

                <div class="card-body">
                    <table id="moviesTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Ano</th>
                                <th>Código</th>
                                <th>Gênero</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movies as $movie)
                            <tr>
                                <td>{{ $movie->id }}</td>
                                <td>{{ $movie->nome }}</td>
                                <td>{{ $movie->ano }}</td>
                                <td>{{ $movie->codigo }}</td>
                                <td>{{ $movie->genero }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMovieModal{{ $movie->id }}">
                                        Editar
                                    </button>
                                    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este filme?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-film me-2"></i>
                                        Nenhum filme cadastrado no sistema
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Adicionar Filme -->
<div class="modal fade" id="addMovieModal" tabindex="-1" aria-labelledby="addMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMovieModalLabel">Adicionar Novo Filme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('movies.store') }}" id="movieForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Filme</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="number" class="form-control" id="ano" name="ano" min="1900" max="{{ date('Y') + 1 }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="number" class="form-control" id="codigo" name="codigo" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Gênero</label>
                        <select class="form-select" id="genero" name="genero" required>
                            <option value="" selected disabled>Selecione um gênero</option>
                            @foreach($generos as $genero)
                            <option value="{{ $genero }}">{{ $genero }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modais de Edição -->
@foreach($movies as $movie)
<div class="modal fade" id="editMovieModal{{ $movie->id }}" tabindex="-1" aria-labelledby="editMovieModalLabel{{ $movie->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMovieModalLabel{{ $movie->id }}">Editar Filme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('movies.update', $movie->id) }}" id="editMovieForm{{ $movie->id }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome{{ $movie->id }}" class="form-label">Nome do Filme</label>
                        <input type="text" class="form-control" id="nome{{ $movie->id }}" name="nome" value="{{ $movie->nome }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="ano{{ $movie->id }}" class="form-label">Ano</label>
                        <input type="number" class="form-control" id="ano{{ $movie->id }}" name="ano" min="1900" max="{{ date('Y') + 1 }}" value="{{ $movie->ano }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="codigo{{ $movie->id }}" class="form-label">Código</label>
                        <input type="number" class="form-control" id="codigo{{ $movie->id }}" name="codigo" value="{{ $movie->codigo }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero{{ $movie->id }}" class="form-label">Gênero</label>
                        <select class="form-select" id="genero{{ $movie->id }}" name="genero" required>
                            @foreach($generos as $genero)
                            <option value="{{ $genero }}" {{ $movie->genero == $genero ? 'selected' : '' }}>{{ $genero }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom-datatable.css') }}">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('js/custom-datatable.js') }}"></script>
<script src="{{ asset('js/movies-validations.js') }}"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    });
</script>
@endpush
@endsection