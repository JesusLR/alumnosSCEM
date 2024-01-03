@extends('layouts.dashboard')



@section('template_title')
    Horarios del alumno
@endsection

@section('head')
    {!! HTML::style(asset('/public/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_horario_alumno')}}" class="breadcrumb">Horarios del alumno</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Horarios del alumno</h4>
    <p><b>Clave:</b> {{$alumno->aluClave}}</p>
    <p><b>Nombre:</b> {{$persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2}} <a href="{{route('bachiller.bachiller_horario_clases_alumno.imprimir', ['aluClave' => $alumno->aluClave])}}" type="buttton" target="_blank" class="btn-large waves-effect darken-3"><i class="material-icons left">picture_as_pdf</i> Horario</a></p>
    <br>
    <br>
    
    <div class="row">
        <div class="col s12">
            <table id="tbl-horario-alumno" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Clave Materia</th>
                        <th>Materia</th>
                        <th>Materia complementaria</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
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
       
        
        $.fn.dataTable.ext.errMode = 'throw';
        
        $('#tbl-horario-alumno').dataTable({
            // "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "order": [[ 0, 'asc' ]],
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "columnDefs":[
                {
                    "targets": [0],
                    "visible": false,
                }            
                
            ],


            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/bachiller_horario_alumno/",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
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
                {data: "matClave"},
                {data: "materia"},
                {data: "materia_acd"},
                {data: "lunes"},
                {data: "martes"},
                {data: "miercoles"},
                {data: "jueves"},
                {data: "viernes"},
                {data: "sabado"}

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



</script>*/


@endsection