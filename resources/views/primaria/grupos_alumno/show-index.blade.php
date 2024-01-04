@extends('layouts.dashboard')



@section('template_title')
    Calificaciones
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('calificacion_alumno_primaria')}}" class="breadcrumb">Calificaciones</a>
@endsection

@section('content')
@php
use App\Http\Helpers\Utils;
@endphp
<div id="table-datatables">
    <h4 class="header">Boleta de Calificaciones</h4>


    @if ($validandoFecha == "true" && $curso->curEstado == "R")

        <div class="row">
            <div class="col s12 m8 l8">
                <p>Estimado(a) padre/madre de familia: En el siguiente botón puede visualizar y descargar la última boleta de calificaciones del alumno(a).</p>

                <a href="{{url('primaria_boleta/'.$curso->id)}}" class="btn-large waves-effect darken-3" target="_blank" type="button">Visualizar Boleta
                    <i class="material-icons left">picture_as_pdf</i>
                </a>
            </div>
        </div>


    @else

        {{--  <div class="row">
            <div class="col s12 m8 l8">
                <p style="color:#aa093f; font-size:20px;"><b>INFORMACIÓN IMPORTANTE:</b></p>
                <p>Estimado(a) padre/madre de familia: Por el momento, la boleta de calificaciones no se encuentra disponible para su descarga ya que nos encontramos en el periodo de evaluación del mes en turno. <br>La publicación de resultados está acorde al calendario de la dirección correspondiente. Para cualquier aclaración, favor de comunicarse al departamento de control escolar del nivel educativo de la institución.</p>
            </div>
        </div>  --}}

        <div class="row">
            <div class="col s12 m8 l8">
                <p style="color:#aa093f; font-size:20px;"><b>INFORMACIÓN IMPORTANTE:</b></p>
                <p>Estimado(a) padre/madre de familia: Por el momento, la boleta de calificaciones no se encuentra disponible para su
                    descarga, ya que nos encontramos en el periodo de <b>EVALUACIÓN DEL MES DE {{$mesActual}}.</b>
                <br>La consulta de la boleta de calificación, estará de nuevo disponible, posterior a la fecha: <b>{{Utils::fecha_string($ultimoDiaDeRevision, $ultimoDiaDeRevision)}}.</b>
                <br>Para cualquier aclaración, favor de comunicarse al departamento de control escolar del nivel educativo de la institución.</p>
            </div>
        </div>

    @endif

    {{--
    <br>
    <div class="row">
        <div class="col s12">

        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <table id="tbl-inscrito-secundaria" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>Grado</th>
                        <th>Grupo</th>
                        <th>Grupo ACD</th>
                        <th>Materia</th>
                        <th>Clave Asignatura</th>
                        <th>Nombre Asignatura</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Abr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Final</th>
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
--}}

@endsection

@section('footer_scripts')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">

 /*
    $(document).ready(function() {
        var aluCheckPagos = []

        $.fn.dataTable.ext.errMode = 'throw';

        $('#tbl-inscrito-secundaria').dataTable({
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

            "ajax": {
                "type" : "GET",
                'url': base_url+"/calificacion_alumno_primaria/primaria/list",
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
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "gpoGrado",name:"primaria_grupos.gpoGrado"},
                {data: "gpoClave",name:"primaria_grupos.gpoClave"},
                {data: "gpoMatComplementaria",name:"primaria_grupos.gpoMatComplementaria"},
                {data: "matNombre",name:"primaria_materias.matNombre"},
                {data: "matClaveAsignatura",name:"primaria_materias_asignaturas.matClaveAsignatura"},
                {data: "matNombreAsignatura",name:"primaria_materias_asignaturas.matNombreAsignatura"},
                {data: "calificacion_sep"},
                {data: "calificacion_oct"},
                {data: "calificacion_nov"},
                {data: "calificacion_ene"},
                {data: "calificacion_feb"},
                {data: "calificacion_mar"},
                {data: "calificacion_abr"},
                {data: "calificacion_may"},
                {data: "calificacion_jun"},
                {data: "inscPromedioMes"}

            ],

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
*/


</script>


@endsection
