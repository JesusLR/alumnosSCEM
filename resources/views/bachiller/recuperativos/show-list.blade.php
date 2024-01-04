@extends('layouts.dashboard')

@section('template_title')
    Bachiller recuperativos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de recuperativos</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">RECUPERATIVOS</h4>
    <br>
    <!-- estas seguro que desea inscribirse una vez inscrito ya no puede arrepentirse -->
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-bachiller-recuperativos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Clave del examen</th>
                    <th>Clave materia</th>
                    <th>Materia</th>
                    <th>Créditos</th>
                    <th>Docente</th>
                    <th>Horario</th>
                    <th>Días de clase</th>
                    {{--  <th>Materia</th> --}}
                    {{--  <th>Optativa</th>  --}}
                    {{--  <th>Docente</th> --}}
                    {{--  <th>Fecha</th> --}}
                    {{--  <th>Hora</th> --}}
                    {{--  <th>Pago</th> --}}
                    {{--  <th>Inscritos</th> --}}
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    {{--  <th></th>  --}}
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    {{--  <th></th>  --}}
                    {{--  <th></th>  --}}
                    {{--  <th></th>  --}}
                    {{--  <th></th>  --}}
                    {{--  <th></th>  --}}
                    {{--  <th></th>  --}}
                    <th class="non_searchable"></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div id="modalValidarAlumno" class="modal">
    
    <div class="modal-content">
        <h4>Obtener Folio/Alumno/Plan</h4>
        <div class="row">
        <div class="col s12 m6 l4">
                <input type="text" placeholder="Clave del alumno" id="aluClave" name="aluClave" style="width: 100%;" />
        </div>
        <div class="col s12 m6 l4">
            <button class="btn-large waves-effect darken-3 btn-validar-alumno">
                <i class="material-icons left">account_circle</i>
                Validar Alumno
            </button>
        </div>
        </div>
        
        <table id="tbl-validar-alumno-bachiller" class="responsive-table display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Folio</th>
                <th>Ubicación</th>
                <th>Programa</th>
                <th>Plan</th>
                <th>Periodo</th>
                <th>Año</th>
                <th>Clave materia</th>
                <th>Materia</th>
                {{--  <th>Obtativa</th>  --}}
                <th>Docente</th>
                <th>iexFecha</th>
                <th>Hora</th>
                <th>Pago</th>
                <th>Calificación</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    {{--  <th></th>  --}}
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
                </tr>
            </tfoot>
        </table>
        
        <div class="preloader-modal">
            <div id="preloader-modal"></div>
        </div>
        
    </div>
    <div class="modal-footer">
        <button type="button" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
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
        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-bachiller-recuperativos').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "order": [
                [0, 'desc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/bachiller_recuperativos",
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
                {data: "extraordinario_id",name:"extraordinario_id"},
                {data: "matClave",name:"bachiller_materias.matClave"},
                {data: "matNombre",name:"bachiller_materias.matNombre"},
                {data: "matCreditos",name:"bachiller_materias.matCreditos"},
                {data: "nombreCompleto"},
                {data: "horario"},
                {data: "diasExa",name:"diasExa"},
                // {data: "progClave",name:"programas.progClave"},
                //{data: "optNombre",name:'optativas.optNombre'},
                // {data: "perNumero",name:"periodos.perNumero"},
                // {data: "fecha_extra"},
                // {data: "extHora"},
                // {data: "extPago"},
                // {data: "extAlumnosInscritos"},
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
        $('.modal').modal();

        $('.btn-validar-alumno').on('click',function(e){
            e.preventDefault();
            var aluClave = $('#aluClave').val();
            aluClave == '' ? swal('Se debe ingresar una clave de alumno para validar') : modalValidarAlumno(aluClave);
        });

        /*
        * BOTÓN PARA Generar solicitud.
        */
        $('#tbl-bachiller-recuperativos').on('click', '.btn-generar-solicitud', function() {
            var extraordinario_id = $(this).data('id');
            extraordinario_id && generar_solicitud(extraordinario_id);
        });
    });

    function generar_solicitud(extraordinario_id) {
        swal({
            type: 'warning',
            title: 'Enviar solicitud ?',
            text: 'Desea solicitar inscribirse al extraordinario con folio: #' + extraordinario_id,
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: true
        }, function(){
            $('#generar_solicitud_' + extraordinario_id).submit();
        });
    }//borrar_responsable
</script>
<script>
    $(document).on('click', '.confirm-acta-examen', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro que deseas imprimir el acta de examen de este recuperativo con folio "+$(this).data('id')+"?",
                type: "info",
                confirmButtonText: "Si",
                confirmButtonColor: '#3085d6',
                cancelButtonText: "No",
                showCancelButton: true
            },
            function() {

                $(".form-acta-examen"+id).submit();
            });
        });
</script>
<script type="text/javascript">
    function modalValidarAlumno(aluClave){

        if ($.fn.DataTable.isDataTable("#tbl-validar-alumno-bachiller")) {
                $('#tbl-validar-alumno-bachiller').DataTable().clear().destroy();
            }
    
        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-validar-alumno-bachiller').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "order": [
                [0, 'desc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/bachiller_recuperativos/validarAlumno/"+aluClave,
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
                {data: "extraordinario_id",name:"extraordinarios.id"},
                {data: "ubiNombre",name:"ubicacion.ubiNombre"},
                {data: "progNombre",name:"programas.progNombre"},
                {data: "planClave",name:"planes.planClave"},
                {data: "perNumero",name:"periodos.perNumero"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "matClave",name:"materias.matClave"},
                {data: "matNombre",name:"materias.matNombre"},
                //{data: "optNombre",name:'optativas.optNombre'},
                {data: "nombreCompleto"},
                {data: "iexFecha"},
                {data: "extHora"},
                {data: "extPago"},
                {data: "iexCalificacion"}
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
    }
</script>

@endsection