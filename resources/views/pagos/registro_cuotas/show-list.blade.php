@extends('layouts.dashboard')

@section('template_title')
    Cuota
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Registro de cuotas</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">REGISTRO DE CUOTAS</h4>
    @php use App\Models\User; @endphp
    {{-- @if (User::permiso("ubicacion") != "D" && User::permiso("ubicacion") != "P") --}}
    <a href="{{ url('/pagos/registro_cuotas/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    {{-- @endif --}}
    <div class="row">
        <div class="col s12">
            <table id="tbl-ubicacion" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Año cuota</th>
                    <th>Importe mens 10</th>
                    <th>Importe mens 11</th>
                    <th>Importe mens 12</th>

                    <th>Importe insc. 1</th>
                    <th>Fecha Limite</th>
                    <th>Importe insc. 2</th>
                    <th>Fecha Limite</th>


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
        $('#tbl-ubicacion').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "ajax": {
              "type" : "GET",
              'url': base_url+"/api/registro_cuotas",
              beforeSend: function () {
                $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
              },
              complete: function () {
                $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
              },
            },
            "columns":[
                {data: "cuoTipo", name: 'cuotas.cuoTipo'},
                {data: "cuoAnio", name: 'cuotas.cuoAnio'},

                {data: "cuoImporteMensualidad10", name: 'cuotas.cuoImporteMensualidad10'},
                {data: "cuoImporteMensualidad11", name: 'cuotas.cuoImporteMensualidad11'},
                {data: "cuoImporteMensualidad12", name: 'cuotas.cuoImporteMensualidad12'},

                {data: "cuoImporteInscripcion1", name: 'cuotas.cuoImporteInscripcion1'},
                {data: "cuoFechaLimiteInscripcion1", name: 'cuotas.cuoFechaLimiteInscripcion1'},

                {data: "cuoImporteInscripcion2", name: 'cuotas.cuoImporteInscripcion2'},
                {data: "cuoFechaLimiteInscripcion2", name: 'cuotas.cuoFechaLimiteInscripcion2'},

                // {data: "ubiNombre"},
                // {data: "edoNombre",name:"estados.edoNombre"},
                // {data: "munNombre",name:"municipios.munNombre"},
                {data: "action"}
            ],
            //Apply the search
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");
                        $(input).attr("placeholder", "Buscar");
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }
                });
            }
        });
    });
</script>


@endsection