@extends('layouts.dashboard')

@section('template_title')
    Bachiller solicitud recuperativo
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_recuperativos')}}" class="breadcrumb">Lista de recuperativo</a>
    <label class="breadcrumb">Lista de solicitudes</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">SOLICITUDES DE RECUPERATIVOS</h4>
    {{--  @php use App\Models\User; @endphp  --}}
    {{--  @if (User::permiso("solicitud_extraordinario") != "D" && User::permiso("solicitud_extraordinario") != "P")  --}}
    <a href="{{ url('create/bachiller_solicitud') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>

    <a href="{{ route('bachiller.bachiller_recuperativos.fecha_general_index') }}" class="btn-large waves-effect  darken-3" type="button">Ficha general
        <i class="material-icons left">add</i>
    </a>

    @if (auth()->user()->empleado_id == 4818 || auth()->user()->empleado_id == 4684)
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.updateEstadoPago', 'method' => 'POST', 'style' => 'display: inline;']) !!}
    {!! Form::button('<i class="material-icons left">refresh</i> Actualizar estado de pago', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
    {!! Form::close() !!}
    @endif

    
    <br>
    <br>
    {{--  @endif  --}}
    <div class="row">
        <div class="col s12">
            <table id="tbl-extra-solic" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    {{-- <th>Id</th> --}}
                    <th>Folio</th>
                    <th>Ubicación</th>
                    <th>Programa</th>
                    <th>Plan</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    <th>Clave materia</th>
                    <th>Materia</th>
                    {{--  <th>Optativa</th>  --}}
                    <th>Clave Pago</th>
                    <th>Nombre Alumno</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Fecha</th>
                    <th>Calificación</th>
                    <th>Estado</th>
                    <th>Tipo de pago</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    {{-- <th></th> --}}
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

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl-extra-solic').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "stateSave": true,
            "dom": '"top"i',
            "pageLength": 5,
            "order": [
                [0, 'desc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/solicitud/bachiller_recuperativos",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                //{data: "inscritoExtraordinario_id",name: "bachiller_inscritosextraordinarios.id"},
                {data: "extraordinario_id",name:"bachiller_extraordinarios.id"},
                {data: "ubiClave",name:"ubicacion.ubiClave"},
                {data: "progClave",name:"programas.progClave"},
                {data: "planClave",name:"planes.planClave"},
                {data: "perNumero",name:"periodos.perNumero"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "matClave",name:"bachiller_materias.matClave"},
                {data: "matNombre",name:"bachiller_materias.matNombre"},
                //{data: "optNombre",name:"optativas.matNombre"},
                {data: "aluClave",name:"alumnos.aluClave"},
                {data: "nombre_alumno"},
                {data: "apellido1"},
                {data: "apellido2"},
                {data: "extFecha", name:"bachiller_extraordinarios.extFecha"},
                {data: "iexCalificacion"},
                {data: "iexEstado_"},
                {data: "tipo_pago"},
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
    });
</script>


@endsection