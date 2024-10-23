$(document).ready(function() {
    $('#eventsTable').DataTable({
        // Adicione suas opções de configuração aqui, se necessário
        // Por exemplo, para ocultar a coluna de ID:
        "columnDefs": [
            { "visible": false, "targets": 0 } // Oculta a coluna ID
        ],
        "language": {
            "search": "Pesquisar:",
            "lengthMenu": "Mostrar _MENU_ eventos por página",
            "zeroRecords": "Nenhum evento encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum evento disponível",
            "infoFiltered": "(filtrado de _MAX_ eventos no total)",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Próximo",
                "previous": "Anterior"
            }
        }
    });
});