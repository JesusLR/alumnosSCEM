@extends('layouts.dashboard')



@section('template_title')
    Pagos del alumno
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
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
    @if ((int) $pago->importe_adeudado > 0)
       {{-- <p style="color:darkred;font-weight: bold; font-size: 16px">Adeudo actual de pago de colegiaturas y/ó inscripciones: ${{number_format((float)$pago->importe_adeudado, 2, '.', ',')}} M.N.</p> --}}
        <p style="color:darkred;font-weight: bold; font-size: 18px">Usted presenta un ADEUDO DE PAGOS DE COLEGIATURAS Y/Ó INSCRIPCIONES.</p>
        @if ($info->depClave == "MAT" || $info->depClave == "PRE" || $info->depClave == "PRI" || $info->depClave == "SEC" || $info->depClave == "BAC")
            @if ($info->ubiClave == "CME")
                <p style="color:black;font-weight: bold; font-size: 16px">Cualquier duda ó aclaración, favor de comunicarse al área de contabilidad de la Escuela Modelo.
                <br>Susana Valencia<br>Tel.: 999 - 9279833 ext. 118  o al 999 - 92799166225<br>Email: svalencia@modelo.edu.mx</p>
            @endif

            @if ($info->ubiClave == "CVA")
                <p style="color:black;font-weight: bold; font-size: 16px">Cualquier duda ó aclaración, favor de comunicarse a la oficina de Control Escolar de la Escuela Modelo.
                <br>Mariana Tuz<br>Tel.: 985 - 8561572<br>Email: mtuz@modelo.edu.mx
                <br>María Carrillo<br>Tel.: 985 - 8561572<br>Email: maria.carrillo@modelo.edu.mx</p>
            @endif
        @endif

        @if ($info->depClave == "SUP" || $info->depClave == "POS")
            @if ($info->ubiClave == "CME")
                <p style="color:black;font-weight: bold; font-size: 16px">Cualquier duda ó aclaración, favor de comunicarte a la Coordinación Administrativa de la Universidad Modelo.
                <br>Coordinación administrativa<br>Tel.: 999 - 9301900 ext. 1151  o al celular 999 135 6225<br>Email: coordinacion.administrativa@modelo.edu.mx</p>
            @endif

            @if ($info->ubiClave == "CVA")
                <p style="color:black;font-weight: bold; font-size: 16px">Cualquier duda ó aclaración, favor de comunicarse a la oficina de Control Escolar de la Universidad Modelo.
                <br>Mariana Tuz<br>Tel.: 985 - 8561572<br>Email: mtuz@modelo.edu.mx
                <br>María Carrillo<br>Tel.: 985 - 8561572<br>Email: maria.carrillo@modelo.edu.mx</p>
            @endif

            @if ($info->ubiClave == "CCH")
                <p style="color:black;font-weight: bold; font-size: 16px">Cualquier duda ó aclaración, favor de comunicarse al área de control de pagos y becas del departamento de control escolar de la Universidad Modelo.
                <br>Área de control de pagos y becas<br>Tel.: 983 - 6882211 ext. 115  o al 983 - 6882216 ext. 115<br>Email: pagoscch@modelo.edu.mx</p>
            @endif
        @endif
    @endif
    <br>
    <div class="row">
        <div class="col s12">

        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <table id="tbl-pagos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        {{-- <th>Importe</th> --}}
                        <th>Concepto</th>
                        <th>Referencia</th>
                        <th>Adeudo vigente</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                       {{-- <th></th> --}}
                        <th></th>
                        <th></th>
                        <th></th>
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

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {
        var aluCheckPagos = []

        $.fn.dataTable.ext.errMode = 'throw';


        $('#tbl-pagos').dataTable({
            {{-- "language":{"url":base_url+"/api/lang/javascript/datatables"}, --}}
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "No se encontraron registros.",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles.",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                }
            },
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            /*"order": [
                [4, 'desc']
            ],*/

            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/alumno_pagos/" + {!! json_encode($alumno->id)!!},
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                    //console.log(aluCheckPagos);

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
                {data: "descripcion_pago", "orderable": false},
                {{-- {data: "total_mes", "orderable": false}, --}}
                {data: "conc_pago", "orderable": false},
                {data: "pagRefPago", "orderable": false},
                {data: "esDeuda","orderable": false}
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

    });



</script>


@endsection
