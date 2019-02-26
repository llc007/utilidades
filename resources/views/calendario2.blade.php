@extends('layout.master')

@section('content')

    <style>
        .fc-view-container{
            background: rgba(255, 255, 255, 0.6) !important;
            border-radius: 20px;
            border: 0px solid !important;

        }
    </style>

<div class="container-fluid" id="calendario">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-sm-12">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        escritura = true;
        $('#calendar').fullCalendar({
            header: {
                left: 'month,listWeek',
                center: 'title',
                right: 'prevYear,prev,next,nextYear',
            },
            themeSystem: 'bootstrap4',
            events: '/getEventos',
            dayClick: function (date, jsEvent, view) {
                    limpiarForm();
                    fechaHora = date.format();
                    fechaHora = fechaHora.split("-");
                    fechaHoraFormat = fechaHora[2] + "-" + fechaHora[1] + "-" + fechaHora[0];
                    $('#tituloEvento').html("Agregar evento - " + fechaHoraFormat);
                    $('#txtFecha').val(fechaHora);
                    $('#txtFechaT').prop('min', fechaHora[0] + "-" + fechaHora[1] + "-" + fechaHora[2]);
                    $('#btnAgregar').prop('disabled', false);
                    $('#btnModificar').prop('disabled', true);
                    $('#btnEliminar').prop('disabled', true);
                    $('#modalCrudEvento').modal();

            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#txtID').val(calEvent.id);
                $('#txtTitulo').val(calEvent.title);
                $('#tituloEvento').html(calEvent.title + " - " + calEvent.start.format('D MMM YYYY'));
                $('#txtDescripcion').val(calEvent.description);
                $('#bgColor').val(calEvent.color);
                $('#txtColor').val(calEvent.textColor);
                fechaHora = calEvent.start._i.split(" ");
                $('#txtFecha').val(fechaHora[0]);
                $('#txtHora').val(fechaHora[1]);
                fechaHoraT = calEvent.end._i.split(" ");
                $('#txtFechaT').val(fechaHoraT[0]);
                $('#txtHoraT').val(fechaHoraT[1]);
                var tipoEvento = $('#tipoEvento option');
                for (var i = 0; i < tipoEvento.length; i++) {
                    valor = tipoEvento[i].value.split("-");
                    if (calEvent.tipoEvento == valor[0]) {
                        $('#tipoEvento option').eq(i).prop('selected', true);
                    }
                }
                vistaPrevia();
                if (escritura) {
                    $('#btnAgregar').prop('disabled', true);
                    $('#btnModificar').prop('disabled', false);
                    $('#btnEliminar').prop('disabled', false);
                } else {
                    $('#btnAgregar').prop('disabled', true);
                    $('#btnModificar').prop('disabled', true);
                    $('#btnEliminar').prop('disabled', true);
                }
                $('#modalCrudEvento').modal();
            },
            editable: escritura,
            eventDrop: function (calEvent) {
                $('#txtID').val(calEvent.id);
                $('#txtTitulo').val(calEvent.title);
                $('#txtDescripcion').val(calEvent.description);
                $('#bgColor').val(calEvent.color);
                $('#txtColor').val(calEvent.textColor);
                $('#idTipoEvento').val(calEvent.tipoEvento);
                var fechaHora = calEvent.start.format().split("T");
                $('#txtFecha').val(fechaHora[0]);
                $('#txtHora').val(fechaHora[1]);
                var fechaHoraT = calEvent.end.format().split("T");
                $('#txtHoraT').val(fechaHoraT[1]);
                $('#txtFechaT').val(fechaHoraT[0]);
                recolectarDatos();
                enviarParametros('modificar', nuevoEvento, true);
            }
        });
    })
</script>

<!-- Modal Para CRUD de EVENTOS-->
<div class="modal fade" id="modalCrudEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloEvento"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="txtID" name="ID"/>
                <input type="hidden" id="txtFecha" name="fecha"/>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label>Titulo:</label>
                        <input placeholder="Titulo del evento" class="form-control" type="text" id="txtTitulo"
                               name="title"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Hora inicio:</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input type="text" id="txtHora" class="form-control" name="hora" value="10:30:00"/>
                        </div>
                    </div>
                    <div class="form-group col-md-8">
                        <label id="labelFT">Fecha termino:</label>
                        <input required class="form-control" type="date" id="txtFechaT"
                               name="fechaT"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Hora termino:</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input class="form-control" type="text" id="txtHoraT" name="horaT" value="10:40:00"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Descripcion:</label>
                        <textarea class="form-control" id="txtDescripcion" name="description" rows="2"></textarea>
                    </div>
                    <div class="form-group col-md-6 ocultar">
                        <label>Tipo de evento:</label>
                        <select class="form-control" name="tipoEvento" id="tipoEvento" onchange="vistaPrevia()"
                                required>
                            <option selected disabled hidden value> Tipo de evento</option>
                            @foreach($tipoEvento as $TE)
                                <option value="{{$TE->id}}-{{$TE->color}}-{{$TE->textColor}}-{{$TE->tipo}}">{{$TE->tipo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4 text-center ocultar">
                        <label>Vista Previa:</label>
                        <h5 id="vistaPrevia">Evento</h5>
                    </div>
                    <div class="form-group col-md-2 text-center ocultar">
                        <label>Editar</label> <br>
                        <h4 onclick="lanzarTipoEvento()" style="cursor: pointer" class="far fa-edit"></h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" hidden id="idTipoEvento">
                <button type="button" id="btnAgregar" class="btn btn-success">Agregar</button>
                <button type="button" id="btnModificar" class="btn btn-primary">Modificar</button>
                <button type="button" id="btnEliminar" class="btn btn-danger">Borrar</button>
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
            </div>
        </div>
    </div>
</div>

<!-- Modal Para CRUD de TipoEventos-->
<div class="modal fade" id="modalCrudTipoEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloTipoEvento">Administrar tipo de eventos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Tipo de evento:</label>
                        <select class="form-control" name="tipoEvento" id="tipoEventoEdit" onchange="vistaPreviaEdit()"
                                required>
                            <option selected disabled hidden value> Tipo de evento</option>
                            @foreach($tipoEvento as $TE)
                                <option value="{{$TE->id}}-{{$TE->color}}-{{$TE->textColor}}-{{$TE->tipo}}">{{$TE->tipo}}</option>
                            @endforeach
                            <option value="nuevo">Nuevo tipo de evento</option>
                        </select>

                    </div>

                    <div class="form-group col-md-8">
                        <label>Titulo:</label>
                        <input placeholder="Titulo del evento" class="form-control" type="text" id="txtTituloEdit"
                               name="title"/>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Fondo:</label>
                        <input class="form-control" type="color" value="#ff0000" id="bgColorEdit" name="color">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Texto:</label>
                        <input class="form-control" type="color" value="#ffffff" id="txtColorEdit" name="textColor">
                    </div>
                    <div class="form-group col-md-12 text-center">
                        <h5 id="vistaPreviaEdit">Vista Previa</h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" hidden id="idTipoEventoEdit">
                <button type="button" id="btnAgregarEdit" class="btn btn-success">Agregar</button>
                <button type="button" id="btnModificarEdit" class="btn btn-primary">Modificar</button>
                <button type="button" id="btnEliminarEdit" class="btn btn-danger">Borrar</button>
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
            </div>
        </div>
    </div>
</div>

<script>
    var nuevoEvento;
    $('#btnAgregar').click(function () {
        recolectarDatos();
        enviarParametros('agregar', nuevoEvento);
    });
    $('#btnEliminar').click(function () {
        recolectarDatos();
        enviarParametros('eliminar', nuevoEvento);
    });
    $('#btnModificar').click(function () {
        recolectarDatos();
        enviarParametros('modificar', nuevoEvento);
    });
    function recolectarDatos() {
        nuevoEvento = {
            id: $('#txtID').val(),
            title: $('#txtTitulo').val(),
            start: $('#txtFecha').val() + " " + $('#txtHora').val(),
            description: $('#txtDescripcion').val(),
            end: $('#txtFechaT').val() + " " + $('#txtHoraT').val(),
            tipoevento: $('#idTipoEvento').val()
        };
        return nuevoEvento;
    }
    function enviarParametros(accion, objEvento, modal) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'getEventos/' + accion,
            data: objEvento,
            success: function (msg) {
                if (msg) {
                    $('#calendar').fullCalendar('refetchEvents');
                    if (!modal) {
                        $('#modalCrudEvento').modal('toggle');
                    }
                } else if (msg == "error") {
                    console.log("ERROR EN EL CONTROLADOR");
                }
            },
            error: function () {
                swal(
                    'Alerta',
                    'Compruebe que los datos esten correctos',
                    'error'
                )
            }
        })
    }
    function refresh() {
        $('#calendar').fullCalendar('refetchEvents');
        $('#modalCrudEvento').modal('toggle');
    }
    $('.calendario').flatpickr({
        dateFormat: "Y-m-d",
    });
    $('.clockpicker').clockpicker();
    function limpiarForm() {
        var tipoEvento = document.getElementById('tipoEvento');
        $('#txtID').val('');
        $('#txtTitulo').val('');
        $('#txtDescripcion').val('');
        $('#txtFechaT').val('');
        tipoEvento.selectedIndex = 0;
        var vp = document.getElementById('vistaPrevia');
        vp.style.backgroundColor = '#ffffff';
        vp.style.color = '#ffffff';
    }
    function vistaPrevia() {
        var tipoEvento = document.getElementById('tipoEvento');
        var vp = document.getElementById('vistaPrevia');
        var idTipoEvento = document.getElementById('idTipoEvento');
        tipoEvento = tipoEvento.value.split("-");
        vp.style.backgroundColor = tipoEvento[1];
        vp.style.color = tipoEvento[2];
        vp.style.borderRadius = "10px";
        idTipoEvento.value = tipoEvento[0];
    }
    var indexSeleccionado;
    function vistaPreviaEdit() {
        var tipoEvento = document.getElementById('tipoEventoEdit');
        var vp = document.getElementById('vistaPreviaEdit');
        var idTipoEvento = document.getElementById('idTipoEventoEdit');
        indexSeleccionado = tipoEvento.selectedIndex;
        if (tipoEvento.value === "nuevo") {
            $('#btnAgregarEdit').prop("disabled", false);
            $('#btnModificarEdit').prop("disabled", true);
            $('#btnEliminarEdit').prop("disabled", true);
            $('#txtTituloEdit').val('');
            $('#bgColorEdit').val('#ff0000');
            $('#txtColorEdit').val('#ffffff');
            vp.style.backgroundColor = '#ff0000';
            vp.style.color = "#ffffff";
            vp.style.borderRadius = "10px";
        } else {
            tipoEvento = tipoEvento.value.split("-");
            $('#btnAgregarEdit').prop("disabled", true);
            $('#btnModificarEdit').prop("disabled", false);
            $('#btnEliminarEdit').prop("disabled", false);
            $('#txtTituloEdit').val(tipoEvento[3]);
            $('#bgColorEdit').val(tipoEvento[1]);
            $('#txtColorEdit').val(tipoEvento[2]);
            vp.style.backgroundColor = tipoEvento[1];
            vp.style.color = tipoEvento[2];
            vp.style.borderRadius = "10px";
            idTipoEvento.value = tipoEvento[0];
        }
    }
    function lanzarTipoEvento() {
        $('#modalCrudTipoEvento').modal();
        $('#modalCrudEvento').modal('toggle');
    }
    //    SECCION PARA CRUD TIPO EVENTO USANDO AJAX
    var nuevoTipoEvento;
    $('#btnAgregarEdit').click(function () {
        recolectarDatosTE();
        enviarParametrosTE('agregar', nuevoTipoEvento);
    });
    $('#btnEliminarEdit').click(function () {
        recolectarDatosTE();
        enviarParametrosTE('eliminar', nuevoTipoEvento);
    });
    $('#btnModificarEdit').click(function () {
        recolectarDatosTE();
        enviarParametrosTE('modificar', nuevoTipoEvento);
    });
    function recolectarDatosTE() {
        nuevoTipoEvento = {
            id: $('#idTipoEventoEdit').val(),
            tipo: $('#txtTituloEdit').val(),
            color: $('#bgColorEdit').val(),
            textColor: $('#txtColorEdit').val()
        };
        return nuevoTipoEvento;
    }
    function enviarParametrosTE(accion, objEvento, modal) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'crudTipoEvento/' + accion,
            data: objEvento,
            success: function (msg) {
                if (msg) {
                    console.log(msg);
                    $('#calendar').fullCalendar('refetchEvents');
                    if (accion === 'agregar') {
                        var value = msg + "-" + objEvento.color + "-" + objEvento.textColor + "-" + objEvento.tipo;
                        $('#tipoEventoEdit').prepend('<option value="' + value + '" selected="selected">' + objEvento.tipo + '</option>');
                        $('#tipoEvento').prepend('<option value="' + value + '">' + objEvento.tipo + '</option>');
                    } else if (accion === 'modificar') {
                        var x = document.getElementById("tipoEventoEdit");
                        x.remove(x.selectedIndex);
                        var value = msg + "-" + objEvento.color + "-" + objEvento.textColor + "-" + objEvento.tipo;
                        $('#tipoEventoEdit').prepend('<option value="' + value + '" selected="selected">' + objEvento.tipo + '</option>');
                        $('#tipoEvento option').remove();
                        $('#tipoEventoEdit option').clone().appendTo("#tipoEvento");
                    } else if (accion === 'eliminar') {
                        console.log('Se elimino bien');
                        var x = document.getElementById("tipoEventoEdit");
                        x.remove(x.selectedIndex);
                        $('#tipoEvento option').remove();
                        $('#tipoEventoEdit option').clone().appendTo("#tipoEvento");
                    }
                } else if (msg == "error") {
                    console.log("ERROR EN EL CONTROLADOR");
                }
            },
            error: function () {
                alert('ERROR');
            }
        })
    }
</script>
@endsection