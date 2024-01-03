@extends('layouts.dashboard')



@section('template_title')
    Avance Calificaciones
@endsection

@section('head')
    {!! HTML::style(asset('/public/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_calificacion_alumno')}}" class="breadcrumb">Grupos Calificaciones</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Grupos Materias - Avance Calificaciones del Curso Actual</h4>

    {{--  @if ($validandoFecha == "true" && $curso->curEstado == "R")  --}}

        <div class="row">
            {{--  <div class="col s12">
                <a href="{{url('secundaria_boleta/'.$curso->id)}}" class="btn-large waves-effect darken-3" target="_blank" type="button">Boleta
                    <i class="material-icons left">picture_as_pdf</i>
                </a>
            </div>  --}}
        </div>


        <div class="row">
            <div class="col s12">
                <table id="tbl-calificaciones-bachiller-inscrito" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Año</th>
                        <th>Grado</th>
                        <th>Grupo</th>
                        <th>Materia</th>
                        <th>Complementaria</th>

                        {{--  <th>Puntos <br> 1er Corte</th>
                        <th>Puntos <br> 2do Corte</th>
                        <th>Puntos <br> 3er Corte</th>  --}}
                        <th>Total de puntos obtenidos</th>
                        <th>% de Aprovechamiento<br> Acumulado Parcial</th>

                        
                        
                        {{--
                         <th>Docente</th>
                        <th>Calificación Parcial 3</th>
                        <th>Faltas Parcial 3</th>
                        <th>Promedio Parcial</th>
                        <th>Promedio Final</th>
                        --}}

                        @if ($parametroMostrar)
                        <th>Puntos <br> Ordinario</th>
                        <th>Calificación <br> Final</th>
                        @endif

                        <th>Acciones</th>

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
                        
                        @if ($parametroMostrar)
                        <th></th>                      
                        <th></th>
                        @endif
                        
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    {{--  @else

        <div class="row">
            <div class="col s12 m8 l8">
                <p style="color:#aa093f; font-size:20px;"><b>INFORMACIÓN IMPORTANTE:</b></p>
                <p>Estimado(a) padre/madre de familia: Por el momento, la boleta de calificaciones no se encuentra disponible para su descarga ya que nos encontramos en el periodo de evaluación del mes en turno. <br>La publicación de resultados está acorde al calendario de la dirección correspondiente. Para cualquier aclaración, favor de comunicarse al departamento de control escolar del nivel educativo de la institución.</p>
            </div>
        </div>

    @endif  --}}


</div>

<div class="preloader">
    <div id="preloader"></div>
</div>

<style>
    td.highlight {
        background-color: whitesmoke !important;
    }
</style>
@endsection

@section('footer_scripts')
{!! HTML::script(asset('/public/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/public/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script>
    var parametroMostrar = "{{$parametroMostrar}}";
</script>
<script type="text/javascript">

    

    if(parametroMostrar){
        $(document).ready(function() {
            var aluCheckPagos = []
    
            $.fn.dataTable.ext.errMode = 'throw';
    
    
            $('#tbl-calificaciones-bachiller-inscrito').dataTable({
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
                    'url': base_url+"/bachiller_calificacion_alumno/list",
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
                    {data: "periodo_anio"},
                    {data: "grado"},
                    {data: "grupo"},
                    {data: "materia"},
                    {data: "grupoACD"},
                    //{data: "primerCorte"},
                    //{data: "segundoCorte"},
                    //{data: "tercerCorte"},
                    {data: "acumuladoCorte"},
                    {data: "acumuladoAprovechamiento"},
                    {data: "ordinarioCorte"},
                    {data: "insPuntosObtenidosFinal"},
                    /*
                    {data: "docente"},
                    {data: "parcial1"},
                    {data: "faltas_parcial1"},
                    {data: "parcial2"},
                    {data: "faltas_parcial2"},
                    {data: "parcial3"},
                    {data: "faltas_parcial3"},
                    {data: "insFaltasParcial3"},
                    {data: "insCalificacionFinal"},
                    */
                    {data: "action"}
    
    
    
    //{data: "action"}
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
    }else{
        //Si no ha llegado la fecha de ordinario se muestra 

        $(document).ready(function() {
            var aluCheckPagos = []
    
            $.fn.dataTable.ext.errMode = 'throw';
    
    
            $('#tbl-calificaciones-bachiller-inscrito').dataTable({
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
                    'url': base_url+"/bachiller_calificacion_alumno/list",
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
                    {data: "periodo_anio"},
                    {data: "grado"},
                    {data: "grupo"},
                    {data: "materia"},
                    {data: "grupoACD"},
                    //{data: "primerCorte"},
                    //{data: "segundoCorte"},
                    //{data: "tercerCorte"},
                    {data: "acumuladoCorte"},
                    {data: "acumuladoAprovechamiento"},
                    //{data: "ordinarioCorte"},
                    //{data: "insPuntosObtenidosFinal"},
                    /*
                    {data: "docente"},
                    {data: "parcial1"},
                    {data: "faltas_parcial1"},
                    {data: "parcial2"},
                    {data: "faltas_parcial2"},
                    {data: "parcial3"},
                    {data: "faltas_parcial3"},
                    {data: "insFaltasParcial3"},
                    {data: "insCalificacionFinal"},
                    */
                    {data: "action"}
    
    
    
    //{data: "action"}
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
    }





</script>

<script>
$(document).ready(function() {
var table = $('#tbl-calificaciones-bachiller-inscrito').DataTable();

$('#tbl-calificaciones-bachiller-inscrito tbody')
.on( 'mouseenter', 'td', function () {
var colIdx = table.cell(this).index().column;

$( table.cells().nodes() ).removeClass( 'highlight' );
$( table.column( colIdx ).nodes() ).addClass( 'highlight' );
} );
} );
</script>
@endsection
