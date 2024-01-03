@extends('layouts.dashboard')



@section('template_title')
    Materias del alumno
@endsection

@section('head')
    {!! HTML::style(asset('/public/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
    <style type="text/css">
        .urgente-aprobar-row td {
            color: #A31818;
            font-weight: bolder;
        }
    </style>
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('adeudadas/')}}" class="breadcrumb">Materias Adeudadas del Alumno</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Materias Adeudadas del Alumno</h4>
    <div class="row">
        <div class="col s3">
            <p><b>Clave:</b> {{$alumno->aluClave}}</p>
            <p><b>Nombre:</b> {{$persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2}}</p>
        </div>
        <div class="col s9">
            <a href="{{url('bachiller_boleta_final/adeudo')}}" class="btn-large waves-effect darken-3" target="_blank" type="button">Detalle de las Materias Adeudadas 
                <i class="material-icons left">picture_as_pdf</i>
            </a>
        </div>
    </div>
    {{--
        <p><b>NOTA:</b> Las materias marcadas en <b style="color:#A31818;">rojo</b> son urgentes por aprobar. Comunícate a la brevedad con la coordinación de tu carrera.</p>
    --}}
    <br>
    <br>

    <div class="row">
        <div class="col s12">
            <table id="tbl-pagos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Nombre</th>
                        <th>Semestre</th>
                    </tr>
                </thead>
                <tfoot>
                  <tr>
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
        $('#tbl-pagos').dataTable({
            // "language":{"url":base_url+"/api/lang/javascript/datatables"},
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
            // "order": [
            //     [4, 'desc']
            // ],

            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/bachiller_adeudadas/",
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
                {data: "matNombre"},
                {data: "matSemestre"},
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
