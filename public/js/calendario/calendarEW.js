var nuevoEvento;
$('#btnAgregar').click(function () {
    recolectarDatos();
    enviarParametros('agregar',nuevoEvento);
    iniciaCalendar();
});
$('#btnEliminar').click(function () {
    recolectarDatos();
    enviarParametros('eliminar',nuevoEvento);
});

function recolectarDatos() {
    nuevoEvento = {
        id: $('#txtID').val(),
        title: $('#txtTitulo').val(),
        color: $('#bgColor').val(),
        textColor: $('#txtColor').val(),
        start: $('#txtFecha').val() + " " + $('#txtHora').val(),
        description: $('#txtDescripcion').val(),
        end: $('#txtFechaT').val() + " " + $('#txtHoraT').val(),
    };
    return nuevoEvento;
}
function enviarParametros(accion,objEvento) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: 'getEventos/'+accion,
        data:objEvento,
        success:function (msg) {
            if(msg=='exito'){
                console.log("EXITO AJAX");
                refresh();
            }
        },
        error:function () {
            alert('ERROR');
        }

    })
}
function refresh() {
        console.log("REFRESCAE");
        $('#calendar').fullCalendar('refetchEvents');
        $('#modalCrudEvento').modal('toggle');

}

