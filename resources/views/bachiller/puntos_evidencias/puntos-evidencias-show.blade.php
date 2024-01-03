@extends('layouts.dashboard')



@section('template_title')
    Puntos evidencias
@endsection

@section('head')
    {!! HTML::style(asset('/public/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_calificacion_alumno')}}" class="breadcrumb">Calificaciones</a>
    <a href="" class="breadcrumb">Puntos evidencias</a>

@endsection

@section('content')

@php
use App\Models\Bachiller\Bachiller_inscritos_evidencias;
use App\Models\Departamento;

    $aluClave = Auth::user()->username;

@endphp

<div id="table-datatables">
    <h4 class="header">PUNTOS EVIDENCIA</h4>

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
                <table id="tbl-puntos-evidencias" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Año</th>
                        <th>Grado</th>
                        <th>Grupo</th>
                        <th>Materia</th>
                        <th># Evidencia</th>
                        <th>Descripción</th>
                        <th>Puntos Máx.</th>
                        <th>Puntos Obtenidos</th>
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


    @if ($es_complementaria == "no_es_complementaria")
        @php
            $bachiller_inscritos_evidencias = Bachiller_inscritos_evidencias::select(
                'bachiller_inscritos_evidencias.id',
                'bachiller_inscritos_evidencias.bachiller_inscrito_id',
                'bachiller_inscritos_evidencias.ievPuntos',
                'bachiller_inscritos_evidencias.ievFaltas',
                'bachiller_inscritos_evidencias.ievClaveCualitativa1',
                'bachiller_inscritos_evidencias.ievClaveCualitativa2',
                'bachiller_inscritos_evidencias.ievClaveCualitativa3',
                'bachiller_evidencias.eviNumero',
                'bachiller_evidencias.eviPuntos',
                'bachiller_evidencias.eviDescripcion',
                'bachiller_materias.matNombre',
                'bachiller_materias.matClave',
                'bachiller_grupos.gpoMatComplementaria',
                'bachiller_grupos.bachiller_materia_id',
                'bachiller_grupos.bachiller_materia_acd_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'bachiller_grupos.gpoGrado',
                'bachiller_grupos.gpoClave',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'planes.planClave',
                'programas.progClave',
                'programas.progNombre',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre',
                'cualitativo1.cuaDescripcion as cuaDescripcion1',
                'cualitativo2.cuaDescripcion as cuaDescripcion2',
                'cualitativo3.cuaDescripcion as cuaDescripcion3'
            )
            ->join('bachiller_evidencias', 'bachiller_inscritos_evidencias.evidencia_id', '=', 'bachiller_evidencias.id')
            ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_evidencias.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->join('bachiller_inscritos', 'bachiller_inscritos_evidencias.bachiller_inscrito_id', '=', 'bachiller_inscritos.id')
            ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
            ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
            ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->leftJoin('bachiller_conceptos_cualitativos as cualitativo1', 'bachiller_inscritos_evidencias.ievClaveCualitativa1', '=', 'cualitativo1.id')
            ->leftJoin('bachiller_conceptos_cualitativos as cualitativo2', 'bachiller_inscritos_evidencias.ievClaveCualitativa2', '=', 'cualitativo2.id')
            ->leftJoin('bachiller_conceptos_cualitativos as cualitativo3', 'bachiller_inscritos_evidencias.ievClaveCualitativa3', '=', 'cualitativo3.id')

            ->where('alumnos.aluClave', $aluClave)
            ->where('periodos.id', $periodo_id)
            ->where('bachiller_grupos.bachiller_materia_id', $materia_id)
            ->whereNull('cursos.deleted_at')
            ->whereNull('bachiller_inscritos_evidencias.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('bachiller_grupos.deleted_at')
            ->whereNull('bachiller_inscritos.deleted_at')
            ->orderBy('bachiller_materias.matNombre', 'ASC')
            ->orderBy('bachiller_grupos.gpoMatComplementaria', 'ASC')
            ->orderBy('bachiller_evidencias.eviNumero', 'ASC')
            ->get();
        @endphp


        <h4 class="header">COMENTARIOS DEL DOCENTE</h4>

        <div class="row">
            <div class="col s12">
                <table class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        {{--  <th>#</th>  --}}
                        <th>Comentario 1</th>
                        <th>Comentario 2</th>
                        <th>Comentario 3</th>
                        
                    </tr>
                    </thead>
                    <tfoot>
                        @forelse ($bachiller_inscritos_evidencias as $item)

                            @if ($item->ievClaveCualitativa1 != "" || $item->ievClaveCualitativa2 != "" || $item->ievClaveCualitativa3 != "")
                            <tr>
                                {{--  <td>{{$item->eviNumero}}</td>  --}}
                                <td>{{$item->cuaDescripcion1}}</td>
                                <td>{{$item->cuaDescripcion2}}</td>
                                <td>{{$item->cuaDescripcion3}}</td>
                            </tr>
                            @endif

                        @empty
                            
                        @endforelse
                    </tfoot>
                </table>
            </div>
        </div>

    @else
    @php
            $bachiller_inscritos_evidencias = Bachiller_inscritos_evidencias::select(
                'bachiller_inscritos_evidencias.id',
                'bachiller_inscritos_evidencias.bachiller_inscrito_id',
                'bachiller_inscritos_evidencias.ievPuntos',
                'bachiller_inscritos_evidencias.ievFaltas',
                'bachiller_inscritos_evidencias.ievClaveCualitativa1',
                'bachiller_inscritos_evidencias.ievClaveCualitativa2',
                'bachiller_inscritos_evidencias.ievClaveCualitativa3',
                'bachiller_evidencias.eviNumero',
                'bachiller_evidencias.eviPuntos',
                'bachiller_evidencias.eviDescripcion',
                'bachiller_materias.matNombre',
                'bachiller_materias.matClave',
                'bachiller_grupos.gpoMatComplementaria',
                'bachiller_grupos.bachiller_materia_id',
                'bachiller_grupos.bachiller_materia_acd_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'bachiller_grupos.gpoGrado',
                'bachiller_grupos.gpoClave',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'planes.planClave',
                'programas.progClave',
                'programas.progNombre',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre',
                'cualitativo1.cuaDescripcion as cuaDescripcion1',
                'cualitativo2.cuaDescripcion as cuaDescripcion2',
                'cualitativo3.cuaDescripcion as cuaDescripcion3'
            )
            ->join('bachiller_evidencias', 'bachiller_inscritos_evidencias.evidencia_id', '=', 'bachiller_evidencias.id')
            ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_evidencias.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->join('bachiller_inscritos', 'bachiller_inscritos_evidencias.bachiller_inscrito_id', '=', 'bachiller_inscritos.id')
            ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
            ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
            ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->leftJoin('bachiller_conceptos_cualitativos as cualitativo1', 'bachiller_inscritos_evidencias.ievClaveCualitativa1', '=', 'cualitativo1.id')
            ->leftJoin('bachiller_conceptos_cualitativos as cualitativo2', 'bachiller_inscritos_evidencias.ievClaveCualitativa2', '=', 'cualitativo2.id')
            ->leftJoin('bachiller_conceptos_cualitativos as cualitativo3', 'bachiller_inscritos_evidencias.ievClaveCualitativa3', '=', 'cualitativo3.id')

            ->where('alumnos.aluClave', $aluClave)
            ->where('periodos.id', $periodo_id)
            ->where('bachiller_grupos.bachiller_materia_id', $materia_id)
            ->where('bachiller_grupos.bachiller_materia_acd_id', $es_complementaria)
            ->whereNull('cursos.deleted_at')
            ->whereNull('bachiller_inscritos_evidencias.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('bachiller_grupos.deleted_at')
            ->whereNull('bachiller_inscritos.deleted_at')
            ->orderBy('bachiller_materias.matNombre', 'ASC')
            ->orderBy('bachiller_grupos.gpoMatComplementaria', 'ASC')
            ->orderBy('bachiller_evidencias.eviNumero', 'ASC')
            ->get();
        @endphp


        <h4 class="header">COMENTARIOS DEL DOCENTE</h4>

        <div class="row">
            <div class="col s12">
                <table class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        {{--  <th>#</th>  --}}
                        <th>Comentario 1</th>
                        <th>Comentario 2</th>
                        <th>Comentario 3</th>
                        
                    </tr>
                    </thead>
                    <tfoot>
                        @forelse ($bachiller_inscritos_evidencias as $item)

                            @if ($item->ievClaveCualitativa1 != "" || $item->ievClaveCualitativa2 != "" || $item->ievClaveCualitativa3 != "")
                            <tr>
                                {{--  <td>{{$item->eviNumero}}</td>  --}}
                                <td>{{$item->cuaDescripcion1}}</td>
                                <td>{{$item->cuaDescripcion2}}</td>
                                <td>{{$item->cuaDescripcion3}}</td>
                            </tr>
                            @endif

                        @empty
                            
                        @endforelse
                    </tfoot>
                </table>
            </div>
        </div>
    @endif


    
    

    

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


    <script type="text/javascript">
        if("{{$es_complementaria}}" == "no_es_complementaria"){
            $(document).ready(function() {
                var aluCheckPagos = []

                $.fn.dataTable.ext.errMode = 'throw';


                $('#tbl-puntos-evidencias').dataTable({
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
                    "pageLength": 30,
                    "stateSave": true,
                    /*"order": [
                        [4, 'desc']
                    ],*/

                    "ajax": {
                        "type" : "GET",
                        'url': base_url+"/bachiller_puntos_evidencia_alumno/list/{{$materia_id}}/materia",
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
                        //{data: "materia_complementaria"},
                        {data: "numero_evidencia"},
                        {data: "eviDescripcion"},
                        {data: "puntos_maximos"},
                        {data: "puntos_obtenedios"}

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
            $(document).ready(function() {
                var aluCheckPagos = []

                $.fn.dataTable.ext.errMode = 'throw';


                $('#tbl-puntos-evidencias').dataTable({
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
                    "pageLength": 30,
                    "stateSave": true,
                    /*"order": [
                        [4, 'desc']
                    ],*/

                    "ajax": {
                        "type" : "GET",
                        'url': base_url+"/bachiller_puntos_evidencia_alumno/list/{{$materia_id}}/{{$es_complementaria}}",
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
                        //{data: "materia_complementaria"},
                        {data: "numero_evidencia"},
                        {data: "eviDescripcion"},
                        {data: "puntos_maximos"},
                        {data: "puntos_obtenedios"}

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
        var table = $('#tbl-puntos-evidencias').DataTable();

        $('#tbl-puntos-evidencias tbody')
            .on( 'mouseenter', 'td', function () {
                var colIdx = table.cell(this).index().column;

                $( table.cells().nodes() ).removeClass( 'highlight' );
                $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
            } );
    } );
</script>
@endsection
