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
                <div class="card-header">
                    <span>Filmes Disponíveis para Locação</span>
                </div>

                <div class="card-body">
                    <table id="locacoesTable" class="table table-striped">
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
                            @php $temFilmeDisponivel = false; @endphp
                            
                            @forelse($movies as $movie)
                                @if($movie->disponivel)
                                    @php $temFilmeDisponivel = true; @endphp
                                    <tr>
                                        <td>{{ $movie->id }}</td>
                                        <td>{{ $movie->nome }}</td>
                                        <td>{{ $movie->ano }}</td>
                                        <td>{{ $movie->codigo }}</td>
                                        <td>{{ $movie->genero }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#locarMovieModal{{ $movie->id }}">
                                                Locar
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="align-middle">
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Não há filmes disponíveis para locação no momento.
                                    </td>
                                </tr>
                            @endforelse

                            @if(!$temFilmeDisponivel && count($movies) > 0)
                                <tr class="align-middle">
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Não há filmes disponíveis para locação no momento.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Locação -->
@foreach($movies as $movie)
@if($movie->disponivel)
<div class="modal fade" id="locarMovieModal{{ $movie->id }}" tabindex="-1" aria-labelledby="locarMovieModalLabel{{ $movie->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="locarMovieModalLabel{{ $movie->id }}">Locar Filme: {{ $movie->nome }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('locacoes.store') }}">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select class="form-select" id="cliente_id" name="cliente_id" required>
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="data_devolucao" class="form-label">Data de Devolução</label>
                        <input type="date" 
                               class="form-control" 
                               id="data_devolucao" 
                               name="data_devolucao" 
                               required
                               min="{{ date('Y-m-d') }}"
                               onchange="validarDataDevolucao(this)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Locação</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#locacoesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
            },
            order: [[0, 'asc']] // Ordena pela primeira coluna (ID) em ordem crescente
        });

        function validarDataDevolucao(input) {
            const data = new Date(input.value);
            const diaSemana = data.getDay();
            const hoje = new Date();
            hoje.setHours(0, 0, 0, 0);
            data.setHours(0, 0, 0, 0);
            
            // Verifica se é a data de hoje
            if (data.getTime() === hoje.getTime()) {
                alert('A data de devolução não pode ser hoje.');
                input.value = '';
                return;
            }
            
            // Verifica se é sábado ou domingo
            if (diaSemana === 0 || diaSemana === 6) {
                alert('Não é possível agendar devoluções para sábados ou domingos.');
                input.value = '';
            }
        }
    });
</script>
@endpush
@endsection
