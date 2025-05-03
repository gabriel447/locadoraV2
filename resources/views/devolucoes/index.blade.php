@extends('layouts.app')

@section('content')
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
                            @foreach($locacoes as $locacao)
                            <tr>
                                <td>{{ $locacao->id }}</td>
                                <td>{{ $locacao->nome_cliente }}</td>
                                <td>{{ $locacao->nome_filme }}</td>
                                <td>{{ $locacao->codigo_filme }}</td>
                                <td>{{ \Carbon\Carbon::parse($locacao->data_locacao)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($locacao->data_devolucao)->format('d/m/Y') }}</td>
                                <td>R$ {{ number_format($locacao->valor, 2, ',', '.') }}</td>
                                <td>
                                    @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($locacao->data_devolucao)))
                                        <span class="badge bg-danger">Atrasado</span>
                                    @else
                                        <span class="badge bg-success">No Prazo</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('devolucoes.devolver', $locacao->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm">Devolver</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        $('#devolucoesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
            }
        });
    });
</script>
@endpush
@endsection