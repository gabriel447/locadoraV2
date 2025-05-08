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
                    <span>Clientes</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClienteModal">
                        Adicionar Cliente
                    </button>
                </div>

                <div class="card-body">
                    <table id="clientesTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Idade</th>
                                <th>Cidade</th>
                                <th>Bairro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nome }}</td>
                                <td>{{ $cliente->cpf }}</td>
                                <td>{{ $cliente->idade }}</td>
                                <td>{{ $cliente->cidade }}</td>
                                <td>{{ $cliente->bairro }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editClienteModal{{ $cliente->id }}">
                                        Editar
                                    </button>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users me-2"></i>
                                        Nenhum cliente cadastrado no sistema
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

<!-- Modal de Adicionar Cliente -->
<div class="modal fade" id="addClienteModal" tabindex="-1" aria-labelledby="addClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClienteModalLabel">Adicionar Novo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('clientes.store') }}" id="clienteForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="idade" class="form-label">Idade</label>
                            <input type="number" class="form-control" id="idade" name="idade" min="1" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="rua" name="rua" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento">
                        </div>
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

<!-- Modais de Visualização -->
@foreach($clientes as $cliente)
<div class="modal fade" id="viewClienteModal{{ $cliente->id }}" tabindex="-1" aria-labelledby="viewClienteModalLabel{{ $cliente->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewClienteModalLabel{{ $cliente->id }}">Detalhes do Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nome:</strong> {{ $cliente->nome }}</p>
                        <p><strong>Idade:</strong> {{ $cliente->idade }}</p>
                        <p><strong>CPF:</strong> {{ $cliente->cpf }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>CEP:</strong> {{ $cliente->cep }}</p>
                        <p><strong>Endereço:</strong> {{ $cliente->rua }}, {{ $cliente->numero }}</p>
                        <p><strong>Bairro:</strong> {{ $cliente->bairro }}</p>
                        <p><strong>Cidade:</strong> {{ $cliente->cidade }}</p>
                        @if($cliente->complemento)
                        <p><strong>Complemento:</strong> {{ $cliente->complemento }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modais de Edição -->
@foreach($clientes as $cliente)
<div class="modal fade" id="editClienteModal{{ $cliente->id }}" tabindex="-1" aria-labelledby="editClienteModalLabel{{ $cliente->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClienteModalLabel{{ $cliente->id }}">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" id="editClienteForm{{ $cliente->id }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome{{ $cliente->id }}" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome{{ $cliente->id }}" name="nome" value="{{ $cliente->nome }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="idade{{ $cliente->id }}" class="form-label">Idade</label>
                            <input type="number" class="form-control" id="idade{{ $cliente->id }}" name="idade" min="1" value="{{ $cliente->idade }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cpf{{ $cliente->id }}" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf{{ $cliente->id }}" name="cpf" value="{{ $cliente->cpf }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cep{{ $cliente->id }}" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep{{ $cliente->id }}" name="cep" value="{{ $cliente->cep }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rua{{ $cliente->id }}" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="rua{{ $cliente->id }}" name="rua" value="{{ $cliente->rua }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="numero{{ $cliente->id }}" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero{{ $cliente->id }}" name="numero" value="{{ $cliente->numero }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cidade{{ $cliente->id }}" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade{{ $cliente->id }}" name="cidade" value="{{ $cliente->cidade }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="bairro{{ $cliente->id }}" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro{{ $cliente->id }}" name="bairro" value="{{ $cliente->bairro }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="complemento{{ $cliente->id }}" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento{{ $cliente->id }}" name="complemento" value="{{ $cliente->complemento }}">
                        </div>
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script src="{{ asset('js/clientes-validations.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#clientesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
            }
        });

        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    });
</script>
@endpush
@endsection