@extends('layouts.dashboard')

@section('template_title')
    Calificaciones
@endsection

@section('head')
    {!! HTML::style(asset('/public/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar/grupo')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar/grupo')}}" class="breadcrumb">Lista de calificaciones</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Calificaciones</h4>
    <div class="row">
        <div class="col s12">
            <table id="tbl-grupo" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubicación</th>
                    <th>Año Escolar</th>
                    <th>Plan</th>
                    <th>Programa</th>
                    <th>Clave-Materia</th>
                    <th>Materia</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Turno</th>
                    <th>Calificaciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Ubicación</th>
                    <th>Año Escolar</th>
                    <th>Plan</th>
                    <th>Programa</th>
                    <th>Clave-Materia</th>
                    <th>Materia</th>
                    <th>Grado-Semestre</th>
                    <th>Grupo</th>
                    <th>Turno</th>
                    <th>Calificaciones</th>
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
        $('#tbl-grupo').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "stateSave": true,
            "pageLength": 10,
            "order": [
                [6, 'asc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/grupo",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "plan.programa.escuela.departamento.ubicacion.ubiNombre"},
                {data: "periodo.perAnio"},
                {data: "plan.planClave"},
                {data: "plan.programa.progNombre"},
                {data: "preescolar_materia.matClave"},
                {data: "preescolar_materia.matNombre"},
                {data: "gpoGrado"},
                {data: "gpoClave"},
                {data: "gpoTurno"},
                {data: "action"}
            ]
        });
    });
</script>


@endsection
