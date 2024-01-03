@extends('layouts.dashboard')

@section('template_title')
    Historico
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Listado historico de calificaciones</label>
@endsection

@section('content')
    <div id="table-datatables">
        <h4 class="header">HISTORICO</h4>
        @php use App\Models\User; @endphp
        @if (User::permiso("abreviatura") != "D" && User::permiso("abreviatura") != "P")
            <a href="{{ url('historico/create') }}" class="btn-large waves-effect  darken-3" type="button">
                Agregar
                <i class="material-icons left">add</i>
            </a>
            <br>
            <br>
        @endif
        <div class="row">
            <div class="col s12">
                <table id="tbl-historico" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Clave de pago</th>
                            <th>Nombre alumno</th>
                            <th>Plan</th>
                            <th>Prog. clave</th>
                            <th>Prog. nombre</th>
                            <th>Clave materia</th>
                            <th>Materia nombre</th>
                            <th>Período</th>
                            <th>Año</th>
                            <th>per/tipo acr</th>
                            <th>Calificación</th>
                            <th>fecha examen</th>
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
            $('#tbl-historico').dataTable({
                "language":{"url":base_url + "/api/lang/javascript/datatables"},
                "serverSide": true,
                "dom": '"top"i',
                "pageLength": 5,
                "stateSave": true,
                "order": [
                    [1, 'asc']
                ],
                "ajax": {
                    "type" : "GET",
                    'url': base_url + "/api/historico",
                    beforeSend: function () {
                        $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                    },
                    complete: function () {
                        $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                    },
                },
                "columns":[
                    {data: "aluClave",name:"alumnos.aluClave"},
                    {data: "nombreCompleto"},
                    {data: "planClave", name: "planes.planClave"},
                    {data: "progClave", name: "programas.progClave"},
                    {data: "progNombre", name: "programas.progNombre"},
                    {data: "matClave", name: "materias.matClave"},
                    {data: "matNombre", name: "materias.matNombre"},
                    {data: "perNumero", name: "periodos.perNumero"},
                    {data: "perAnio", name: "periodos.perAnio"},
                    {data: "acrPeriTipo"},
                    {data: "histCalificacion"},
                    {data: "histFechaExamen"},
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