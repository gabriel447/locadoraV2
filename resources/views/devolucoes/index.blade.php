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

            <div class="card">
                <div class="card-header">
                    <span>Filmes para Devolução</span>
                </div>

                <div class="card-body">
                    @forelse($locacoes as $locacao)
                        @if($loop->first)
                            <table id="devolucoesTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Filme</th>
                                        <th>Código</th>
                                        <th>Data de Locação</th>
                                        <th>Data de Devolução</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @endif
                                    <tr>
                                        <td>{{ $locacao->id }}</td>
                                        <td>{{ $locacao->nome_cliente }}</td>
                                        <td>{{ $locacao->nome_filme }}</td>
                                        <td>{{ $locacao->codigo_filme }}</td>
                                        <td>{{ $locacao->data_locacao->format('d/m/Y') }}</td>
                                        <td>{{ $locacao->data_devolucao->format('d/m/Y') }}</td>
                                        <td>
                                            @if($locacao->atrasado)
                                                <span class="text-danger">
                                                    R$ {{ number_format($locacao->valor_total, 2, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="text-success">
                                                    R$ {{ number_format($locacao->valor, 2, ',', '.') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($locacao->atrasado)
                                                <span class="badge bg-danger">Atrasado ({{ $locacao->dias_atraso }} dias)</span>
                                            @else
                                                <span class="badge bg-success">No Prazo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('devolucoes.devolver', $locacao->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm">Devolver</button>
                                            </form>
                                        </td>
                                    </tr>
                        @if($loop->last)
                                </tbody>
                            </table>
                        @endif
                    @empty
                        <table id="devolucoesTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Filme</th>
                                    <th>Código do Filme</th>
                                    <th>Data de Locação</th>
                                    <th>Data de Devolução</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle">
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        Não há filmes para devolução no momento.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

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
        if (document.getElementById('devolucoesTable')) {
            $('#devolucoesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
                },
                order: [[0, 'asc']] // Ordena pela primeira coluna (ID) em ordem crescente
            });
        }
    });
</script>
@endpush
@endsection