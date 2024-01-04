@extends('layouts.dashboard')



@section('template_title')
    Calificaciones del alumno
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('calificaciones')}}" class="breadcrumb">Calificaciones del alumno</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Calificaciones del alumno</h4>
    <p><b>Clave:</b> {{$alumno->aluClave}}</p>
    <p><b>Nombre:</b> {{$persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2}}</p>
    <br>
    <br>
    
    <div class="row">
        <div class="col s12">
            <table id="tbl-pagos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Parcial 1</th>
                        <th>Parcial 2</th>
                        @if ($perAnioPago <= 2022)
                        <th>Parcial 3</th>
                        @endif
                        <th>Promedio</th>
                        <th>Ordinario</th>
                        <th>Calif. Final</th>
                    </tr>
                </thead>
                <tfoot>
                  <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      @if ($perAnioPago <= 2022)
                      <th></th>
                      @endif
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
        const perAnioPago ={{ $perAnioPago }};
        let columns;

        if (perAnioPago <= 2022) {
            columns = [
                {data: "materia"},
                {data: "parcial1"},
                {data: "parcial2"},
                {data: "parcial3"},
                {data: "promedio"},
                {data: "ordinario"},
                {data: "final"},
            ];
        } else {
            columns = [
                {data: "materia"},
                {data: "parcial1"},
                {data: "parcial2"},
                {data: "promedio"},
                {data: "ordinario"},
                {data: "final"},
            ];
        }

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-pagos').dataTable({
            // "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            // "order": [
            //     [4, 'desc']
            // ],
            
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/calificaciones/",
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
            "columns":columns,
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