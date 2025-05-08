/**
 * Configuração personalizada para DataTables - Tema Claro Moderno
 */
$(document).ready(function() {
    console.log('Inicializando DataTables personalizados');
    
    // Inicializa tabelas específicas
    var tables = [
        '#moviesTable', 
        '#clientesTable', 
        '#locacoesTable', 
        '#devolucoesTable'
    ];
    
    tables.forEach(function(tableId) {
        if ($(tableId).length > 0) {
            console.log('Inicializando tabela: ' + tableId);
            
            // Destruir a instância existente se houver
            if ($.fn.DataTable.isDataTable(tableId)) {
                $(tableId).DataTable().destroy();
            }
            
            // Inicializar com novas configurações
            $(tableId).DataTable({
                processing: true,
                responsive: true,
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                ordering: true,
                searching: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
                    emptyTable: "Nenhum registro encontrado",
                    info: "Mostrando _START_ até _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 até 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros no total)",
                    infoThousands: ".",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    loadingRecords: "Carregando...",
                    processing: "Processando...",
                    zeroRecords: "Nenhum registro encontrado",
                    search: "Pesquisar:",
                    paginate: {
                        next: "Próximo",
                        previous: "Anterior",
                        first: "Primeiro",
                        last: "Último"
                    }
                },
                // stripeClasses: ['even', 'odd'],
                dom: '<"clearfix"<"float-start"f><"float-end"l>>rt<"clearfix"<"float-start"i><"float-end"p>>',
            });
        }
    });
});