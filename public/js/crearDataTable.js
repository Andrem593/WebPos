let espanol = {
    sProcessing:
        '<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div>',
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior"
    },
    oAria: {
        sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
            ": Activar para ordenar la columna de manera descendente"
    },
    buttons: {
        copy: "Copiar",
        colvis: "Visibilidad"
    }
};
$(document).ready(function() {
    let dataTable = $("#datatable").DataTable({
        destroy: true,
        processing: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        language: espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: "Bfrtilp",
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: "Exportar a Excel",
                className: "btn btn-success",
                footer: true
            },
            {
                extend: "pdfHtml5",
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: "Exportar a PDF",
                className: "btn btn-danger",
                pageSize: "TABLOID",
                footer: true
            },
            {
                extend: "print",
                text: '<i class="fa fa-print"></i> ',
                titleAttr: "Imprimir",
                className: "btn btn-info",
                footer: true,
                exportOptions: {
                    stripHtml: false
                }
            }
        ]
    });
    $("#datatable tbody").on("click", ".editar", function() {
        let data = dataTable.row($(this).parents()).data();
        $('#id_venta').val(data[0]);
        $('#nombre_producto').val(data[3]);
        $('#cantidad_producto').val(data[4]);
        $('#cantidad_inicial').val(data[4]);
        $('#precio').val(data[6]);
        $('#id').val(data[1]);
    });
    $("#datatable tbody").on("click", ".eliminar", function() {
        let data = dataTable.row($(this).parents()).data();
        $('#elemento_eliminar').val(data[3]);
        $('#cantidad_eliminar').val(data[4]);
        $('#fecha_pedido').val(data[5]);
        $('#cantidad_liberar').val(data[4]);
        $('#id_producto').val(data[1]);
        $('#id_venta').val(data[0]);
    });

    $("#datatable tbody").on("click", ".detalle", function() {
        let data = dataTable.row($(this).parents()).data();
        $('#id_detalle_venta').val(data[0]);
        $.ajax({
            url: "http://localhost:8000/venta/listar_pedidos",
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_pedido: $('#id_detalle_venta').val()
            },
            success: function(data) {
                $('#tabla_detalle tbody').html('')
                $.each(data,function(i,v){
                    $('#tabla_detalle tbody').append('<tr>'+
                        '<td>'+v.id+'</td>'+
                        '<td>'+v.nombre+'</td>'+
                        '<td>'+v.cantidad+'</td>'+
                        '<td>'+v.created_at+'</td>'+
                        '<td>'+v.precio+'</td>'+
                        '<td>'+v.total+'</td>'+
                    '</tr>')
                })
            }
        })
    })
});
