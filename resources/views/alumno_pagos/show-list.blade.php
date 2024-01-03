@extends('layouts.dashboard')



@section('template_title')
    Pagos del alumno
@endsection

@section('head')
    {!! HTML::style(asset('/public/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('alumno_pagos/'.$alumno->id)}}" class="breadcrumb">Pagos del alumno</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Pagos del alumno</h4>
    <p><b>Clave:</b> {{$alumno->aluClave}}</p>
    <p><b>Nombre:</b> {{$persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2}}</p>
    <br>
    <br>
    <div class="row">
        <div class="col s12">

            @if ((int) $pago->importe_adeudado > 0)

                {!! Form::open(['url' => '/pagos/ficha_general/ficha_alumno', 'method' => 'POST', 'target' => '_blank', 'style' => 'display:inline-block;']) !!}
                    <input type="hidden" name="aluClave" value="{{$pago->cve_pago }}">
                    <input type="hidden" name="cuoAnio" value="{{$pago->perAnioPago}}">
                    <input type="hidden" name="cuoConcepto" value="{{$pago->conc_pago}}">
                    <input type="hidden" name="importeNormal" value="{{$pago->total_mes}}">
                    <input type="hidden" name="nomConcepto" value="{{$concepto->conpNombre . $pago->perAnioPago}}">
                    <input type="hidden" name="perNumero" value="{{$pago->perNumero}}">
                    <input type="hidden" name="convNumero" value="{{$pago->convNumero}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    {!! Form::button('<i class="material-icons left">picture_as_pdf</i> Deuda Total', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                {!! Form::close() !!}
            {{--
            @else
                {!! Form::button('<i class="material-icons left">picture_as_pdf</i> Deuda Total', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit', 'disabled']) !!}
            --}}
            @endif

			@if ((int) $pago->importe_adeudado > 0)
	            {!! Form::open(['url' => '/pagos/ficha_general/ficha_alumno', 'method' => 'POST', 'target' => '_blank', 'style' => 'display:inline-block; margin-left:10px;', 'class' => 'imprimirSeleccionados']) !!}
	                <input type="hidden" name="aluClave" value="{{$pago->cve_pago }}">
	                <input type="hidden" name="cuoAnio" value="{{$pago->perAnioPago}}">
	                <input type="hidden" name="cuoConcepto" value="{{$pago->conc_pago}}">
	                <input type="hidden" name="importeNormal" value="{{$pago->total_mes}}">
	                <input type="hidden" name="nomConcepto" value="{{$concepto->conpNombre . $pago->perAnioPago}}">
	                <input type="hidden" name="perNumero" value="{{$pago->perNumero}}">
	                <input type="hidden" name="convNumero" value="{{$pago->convNumero}}">
	                <input type="hidden" name="_token" value="{{csrf_token()}}">
	                {!! Form::button('<i class="material-icons left">picture_as_pdf</i> Pagar Seleccionados', ['class' => 'btnPagosSeleccionados btn-large waves-effect  darken-3','type' => 'submit']) !!}
	            {!! Form::close() !!}
            {{--
            @else
                {!! Form::button('<i class="material-icons left">picture_as_pdf</i> Pagar Seleccionados', ['class' => 'btnPagosSeleccionados btn-large waves-effect  darken-3','type' => 'submit', 'disabled']) !!}
            --}}
            @endif




        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <table id="tbl-pagos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Importe</th>
                        <th>Referencia</th>
                        <th>Descripción</th>
                        <th>Es deudor</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="non_searchable"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="preloader">
    <div id="preloader"></div>
</div>


@endsection

@section('footer_scripts')

{!! HTML::script(asset('/public/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/public/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {
        var aluCheckPagos = []

        $(document).on("click", ".btnPagosSeleccionados", function (e) {
            e.preventDefault()

            if (aluCheckPagos.length > 0) {
                var importe = 0;
                $(".checkpago").each(function( index ) {
                    var checkbox = $(this);
                    if (aluCheckPagos.includes(checkbox.data("id"))) {
                        importe += parseFloat(checkbox.data("importe"))
                    }
                });

                $(".btnPagosSeleccionados").closest("form").find('input[name ="importeNormal"]').val(importe.toFixed(2))
                $('.imprimirSeleccionados').submit();
            }
        })


        $(document).on("click", ".checkpago", function (e) {
            var id = $(this).data("id");
            if ($(this).is(":checked")) {
                if (!aluCheckPagos.includes(id)) {
                    aluCheckPagos.push(id)
                }
            } else {
                aluCheckPagos =  aluCheckPagos.filter(function(value, index, arr){
                    return value == id;
                })
            }

        })

        $.fn.dataTable.ext.errMode = 'throw';


        $('#tbl-pagos').on( 'draw.dt', function () {
            if (aluCheckPagos.length > 0) {
                $(".checkpago").each(function( index ) {
                    var checkbox = $(this);
                    if (aluCheckPagos.includes(checkbox.data("id"))) {
                        console.log("entra");
                        checkbox.prop( "checked", true );
                    }
                });
            }
        });
        $('#tbl-pagos').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "order": [
                [4, 'desc']
            ],

            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/alumno_pagos/" + {!! json_encode($alumno->id)!!},
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                    console.log(aluCheckPagos);

                }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (errorThrown === "Unauthorized") {
                        swal({
                            title: "Ups...",
                            text: "La sesion ha expirado",
                            type: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            showCancelButton: false
                            }, function(isConfirm) {
                            if (isConfirm) {
                                window.location.href = 'login';
                            } else {
                                window.location.href = 'login';
                            }
                        });
                    }
                }
            },
            "columns":[
                {data: "conc_pago", "orderable": false},
                {data: "total_mes", "orderable": false},
                {data: "pagRefPago", "orderable": false},
                {data: "descripcion_pago", "orderable": false},
                {data: "esDeuda"},
                {data: "action"}

            ],
            //Apply the search
            initComplete: function () {

                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))

                var index = 0
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");


                        var columnDataOld = searchFill.columns[index].search.search
                        $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);


                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }

                    index ++
                });
            },

            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            }

        });



        /*
        * BOTÓN PARA ELIMINAR CALENDARIO.
        */
        $('#tbl-restringidos').on('click', '.btn-borrar', function() {
            var restringido_id = $(this).data('id');
            restringido_id && borrar_restringido(restringido_id);
        });





    });


    function borrar_restringido(restringido_id) {
        swal({
            type: 'warning',
            title: 'Borrar registro #'+restringido_id,
            text: 'Seguro que deseas eliminar este registro?',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: false
        }, function(){
            $('#delete_'+restringido_id).submit();
        });
    }//borrar_responsable







</script>


@endsection
