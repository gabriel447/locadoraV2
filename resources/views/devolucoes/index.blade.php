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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Filmes para Devolução</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#historicoModal">
                        Histórico
                    </button>
                </div>

                <div class="card-body">
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
                            @forelse($locacoes as $locacao)
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
                                            <span class="badge bg-success text-white">No Prazo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-primary btn-sm devolver-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#devolverModal" 
                                                data-locacao-id="{{ $locacao->id }}"
                                                data-cliente="{{ $locacao->nome_cliente }}"
                                                data-filme="{{ $locacao->nome_filme }}"
                                                data-valor="{{ $locacao->valor }}"
                                                data-multa="{{ $locacao->atrasado ? $locacao->valor_total - $locacao->valor : 0 }}"
                                                data-data-locacao="{{ $locacao->data_locacao->format('Y-m-d') }}"
                                                data-data-devolucao="{{ $locacao->data_devolucao->format('Y-m-d') }}">
                                            Devolver
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Não há filmes para devolução no momento.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Devolução -->
<div class="modal fade" id="devolverModal" tabindex="-1" aria-labelledby="devolverModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="devolverModalLabel">Devolver Filme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="devolucaoForm" method="POST" action="{{ route('devolucoes.confirmar') }}">
                @csrf
                <input type="hidden" name="locacao_id" id="locacao_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Valor da Locação</label>
                        <input type="text" class="form-control" id="valor_locacao" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Multa</label>
                        <input type="text" class="form-control" id="multa" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Desconto</label>
                        <input type="text" class="form-control" id="desconto" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Valor Total</label>
                        <input type="text" class="form-control" id="valor_total" readonly>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="tem_observacoes" name="tem_observacoes">
                            <label class="form-check-label" for="tem_observacoes">
                                Adicionar Observações
                            </label>
                        </div>
                        <div id="observacoes_container" style="display: none;" class="mt-2">
                            <textarea class="form-control" name="observacoes" id="observacoes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Histórico -->
<div class="modal fade" id="historicoModal" tabindex="-1" aria-labelledby="historicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historicoModalLabel">Histórico de Devoluções</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Filme</th>
                                <th>Data Locação</th>
                                <th>Data Devolução</th>
                                <th>Valor</th>
                                <th>Multa</th>
                                <th>Desconto</th>
                                <th>Observações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historico as $registro)
                                <tr>
                                    <td>{{ $registro->nome_cliente }}</td>
                                    <td>{{ $registro->nome_filme }}</td>
                                    <td>{{ \Carbon\Carbon::parse($registro->data_locacao)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($registro->data_devolucao)->format('d/m/Y') }}</td>
                                    <td>R$ {{ number_format($registro->valor, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($registro->multa, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($registro->desconto, 2, ',', '.') }}</td>
                                    <td>{{ $registro->observacoes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Nenhum registro encontrado no histórico.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

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
<script>
    $(document).ready(function() {
        // Destruir a instância existente do DataTable se houver
        if ($.fn.DataTable.isDataTable('#devolucoesTable')) {
            $('#devolucoesTable').DataTable().destroy();
        }
        
        // Inicializar o DataTable
        $('#devolucoesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
            }
        });

        // Código do alert
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);

        // Manipulação do modal de devolução
        $('#devolverModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var locacaoId = button.data('locacao-id');
            var valor = parseFloat(button.data('valor'));
            var multa = parseFloat(button.data('multa'));
            var desconto = 0;
            
            // Calcula desconto se devolver antes da data
            var dataLocacao = new Date(button.data('data-locacao'));
            var dataDevolucao = new Date(button.data('data-devolucao'));
            var hoje = new Date();
            
            if (hoje < dataDevolucao) {
                var diasAntecipados = Math.floor((dataDevolucao - hoje) / (1000 * 60 * 60 * 24));
                desconto = diasAntecipados * (valor * 0.1); // 10% de desconto por dia antecipado
            }

            var valorTotal = valor + multa - desconto;

            var modal = $(this);
            modal.find('#locacao_id').val(locacaoId);
            modal.find('#valor_locacao').val('R$ ' + valor.toFixed(2).replace('.', ','));
            modal.find('#multa').val('R$ ' + multa.toFixed(2).replace('.', ','));
            modal.find('#desconto').val('R$ ' + desconto.toFixed(2).replace('.', ','));
            modal.find('#valor_total').val('R$ ' + valorTotal.toFixed(2).replace('.', ','));

            // Adiciona campos hidden para o formulário
            if (!modal.find('input[name="valor"]').length) {
                modal.find('form').append('<input type="hidden" name="valor" value="' + valor + '">');
                modal.find('form').append('<input type="hidden" name="multa" value="' + multa + '">');
                modal.find('form').append('<input type="hidden" name="desconto" value="' + desconto + '">');
                modal.find('form').append('<input type="hidden" name="valor_total" value="' + valorTotal + '">');
            } else {
                modal.find('input[name="valor"]').val(valor);
                modal.find('input[name="multa"]').val(multa);
                modal.find('input[name="desconto"]').val(desconto);
                modal.find('input[name="valor_total"]').val(valorTotal);
            }
        });

        // Manipulação do checkbox de observações
        $('#tem_observacoes').change(function() {
            if($(this).is(':checked')) {
                $('#observacoes_container').slideDown();
            } else {
                $('#observacoes_container').slideUp();
                $('#observacoes').val('');
            }
        });

        // Limpar formulário ao fechar o modal
        $('#devolverModal').on('hidden.bs.modal', function () {
            $('#devolucaoForm')[0].reset();
            $('#observacoes_container').hide();
        });
        
        // Carregar histórico quando o modal for aberto
        $('#historicoModal').on('show.bs.modal', function (e) {
            $.ajax({
                url: "{{ route('devolucoes.historico') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var tbody = $('#historicoTable tbody');
                    tbody.empty();
                    
                    // Verifica se data é null, undefined ou vazio
                    if (!data || data.length === 0 || Object.keys(data).length === 0) {
                        tbody.append('<tr><td colspan="8" class="text-center">Nenhum registro encontrado no histórico.</td></tr>');
                        return;
                    }
                    
                    $.each(data, function(index, item) {
                        // Verifica se o item é válido
                        if (!item) return;
                        
                        try {
                            var dataLocacao = new Date(item.data_locacao);
                            var dataDevolucao = new Date(item.data_devolucao);
                            
                            var row = '<tr>' +
                                '<td>' + (item.nome_cliente || '-') + '</td>' +
                                '<td>' + (item.nome_filme || '-') + '</td>' +
                                '<td>' + (dataLocacao.toLocaleDateString('pt-BR') || '-') + '</td>' +
                                '<td>' + (dataDevolucao.toLocaleDateString('pt-BR') || '-') + '</td>' +
                                '<td>R$ ' + (parseFloat(item.valor || 0).toFixed(2).replace('.', ',')) + '</td>' +
                                '<td>R$ ' + (parseFloat(item.multa || 0).toFixed(2).replace('.', ',')) + '</td>' +
                                '<td>R$ ' + (parseFloat(item.desconto || 0).toFixed(2).replace('.', ',')) + '</td>' +
                                '<td>' + (item.observacoes || '-') + '</td>' +
                                '</tr>';
                            
                            tbody.append(row);
                        } catch (error) {
                            console.error('Erro ao processar item do histórico:', error);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    var tbody = $('#historicoTable tbody');
                    tbody.empty();
                    tbody.append('<tr><td colspan="8" class="text-center">Erro ao carregar o histórico. Por favor, tente novamente.</td></tr>');
                    console.error("Erro ao carregar histórico:", error);
                }
            });
        });
    });
</script>
<script>
$(document).ready(function() {
    $('#devolucaoForm').submit(function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: "{{ route('devolucoes.confirmar') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#devolverModal').modal('hide');
                    location.reload();
                } else {
                    alert('Erro ao processar devolução: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Erro ao processar devolução. Por favor, tente novamente.');
            }
        });
    });
});
</script>
@endpush
@endsection