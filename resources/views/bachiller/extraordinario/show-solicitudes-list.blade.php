@extends('layouts.dashboard')

@section('template_title')
    Recuperativo Calificaciones
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_solicitudes_recuperativos')}}" class="breadcrumb">Recuperativos Inscritos</a>
    <label class="breadcrumb">Calificaciones</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">CALIFICACIONES DE RECUPERATIVOS INSCRITOS</h4>

    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-extra-solic" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Clave Pago</th>
                    <th>Nombre Alumno</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Folio</th>
                    <th>Ubicación</th>
                    <th>Programa</th>
                    <th>Plan</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    <th>Clave materia</th>
                    <th>Materia</th>
                    <th>Calificación</th>
                    {{--  <th>Estado</th> --}}
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    {{--  <th></th>  --}}
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


        $('#tbl-extra-solic').dataTable({
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
            "pageLength": 5,
            "stateSave": true,
            /*"order": [
                [4, 'desc']
            ],*/

            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/solicitud/bachiller_recuperativos",
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
                {data: "extFecha", name:"bachiller_extraordinarios.extFecha"},
                {data: "aluClave",name:"alumnos.aluClave"},
                {data: "nombre_alumno"},
                {data: "apellido1"},
                {data: "apellido2"},
                {data: "extraordinario_id",name:"bachiller_extraordinarios.id"},
                {data: "ubiClave",name:"ubicacion.ubiClave"},
                {data: "progClave",name:"programas.progClave"},
                {data: "planClave",name:"planes.planClave"},
                {data: "perNumero",name:"periodos.perNumero"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "matClave",name:"bachiller_materias.matClave"},
                {data: "matNombre",name:"bachiller_materias.matNombre"},
                {data: "iexCalificacion"}
                //,{data: "estadodepago"}
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
