@extends('layouts.dashboard')



@section('template_title')
    Grupo faltas
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('secundaria_faltas_alumno')}}" class="breadcrumb">Grupo faltas</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Grupo faltas</h4>
    
    <br>
    <div class="row">
        <div class="col s12">

        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <table id="tbl-inscrito-secundaria-faltas" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>Grado</th>
                        <th>Grupo</th>
                        <th>Grupo ACD</th>
                        <th>Materia</th>
                        <th>Docente</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        {{--  <th>Per1</th>  --}}
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        {{--  <th>Per2</th>  --}}
                        <th>Abr</th>  
                        <th>May</th>
                        <th>Jun</th>
                        {{--  <th>Per3</th>  --}}
                        {{--  <th>Final</th>  --}}
                        {{--  <th>Acciones</th>  --}}
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        
                        {{--  <th></th>
                        <th></th>
                        <th></th>
                        <th></th>  --}}
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
                        {{--  <th class="non_searchable"></th>  --}}
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


        $('#tbl-inscrito-secundaria-faltas').dataTable({
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
                'url': base_url+"/secundaria_faltas_alumno/secundaria/list",
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
                {data: "perAnio"},
                {data: "grado"},
                {data: "grupo"},
                {data: "materiaACD"},
                {data: "materia"},
                {data: "nombreCompletoDocente"},
                {data: "inscFaltasInjSep"},
                {data: "inscFaltasInjOct"},
                {data: "inscFaltasInjNov"},
                //{data: "inscTrimestre1"},
                {data: "inscFaltasInjEne"},
                {data: "inscFaltasInjFeb"},
                {data: "inscFaltasInjMar"},
                //{data: "inscTrimestre1"},
                {data: "inscFaltasInjAbr"},
                {data: "inscFaltasInjMay"},
                {data: "inscFaltasInjJun"},
                //{data: "inscTrimestre1"},
                //{data: "inscPromedioPorMeses"}

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



</script>


@endsection
