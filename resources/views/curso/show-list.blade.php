@extends('layouts.dashboard')

@section('template_title')
    Preinscritos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('curso')}}" class="breadcrumb">Lista de preinscritos</a>
@endsection

@section('content')


<div id="table-datatables">
    <h4 class="header">PREINSCRITOS</h4>
    @php use App\Models\User; @endphp
    @if (User::permiso("curso") != "D" && User::permiso("curso") != "P")
        <a href="{{ url('/curso/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
            <i class="material-icons left">add</i>
        </a>
        <br><br>
    @endif
    <div class="row">
        <div class="col s12">
            <table id="tbl-curso" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Per</th>
                        <th>Año</th>
                        <th>Clave Alumno</th>
                        <th>Matrícula</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombre(s) Alumno</th>
                        <th>Edo</th>
                        <th>TI</th>
                        <th>Gdo</th>
                        <th>Gpo</th>
                        <th>Beca</th>
                        <th>Ubic</th>
                        <th>Dep</th>
                        <th>Esc</th>
                        <th>Prog</th>
                        <th>Plan</th>
                        <th>Acciones/Registro</th>
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

@include('modales.modalPreinscritoDetalle')
@include('modales.modalHistorialPagos')
@include('modales.modalBajaCurso')
@include('modales.modalBajaARegular')
@include('modales.modalAlumnoDetalle')

@endsection

@section('footer_scripts')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}


<script type="text/javascript">
    $(document).on("click", ".btn-modal-ficha-pago", function(e) {
        e.preventDefault()

        var cursoId = $(this).data("curso-id");

        swal({
            title: "Validar Pago Ceneval",
            text: "¿El alumno ya pagó su examen Ceneval?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#0277bd',
            confirmButtonText: 'SI',
            cancelButtonText: "NO",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {

            if (isConfirm) {
                window.open("crearReferencia/" + cursoId + "/" + "si", "_blank");
            } else {
                window.open("crearReferencia/" + cursoId + "/" + "no", "_blank");
            }
            swal.close()
        });
    })
</script>


<!-- crearReferencia/'.$query->curso_id.' -->
<script type="text/javascript">
    function modalHistorialPagos(curso_id) {
        //MOSTRAR MODAL
        $('.modal').modal();
        //MOSTRAR GRUPOS
        if ($.fn.DataTable.isDataTable("#tbl-historial-pagos")) {
            $('#tbl-historial-pagos').DataTable().clear().destroy();
        }

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-historial-pagos').dataTable({
            "destroy": true,
            "language":{"url":"api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "bSort": false,
            "ajax": {
                "type" : "GET",
                'url': base_url + "/api/curso/listHistorialPagos/" + curso_id,
                beforeSend: function () {
                    $('.preloader-modal').fadeIn(200, function() {
                        $(this).append('<div id="preloader-modal"></div>');
                    });
                },
                complete: function (data) {
                    if (data.responseJSON.data) {
                        var obj = data.responseJSON.data[0];
                    }

                    $('.preloader-modal').fadeOut(200, function() {
                        $('#preloader-modal').remove();
                    });
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
                                window.location.href = 'login';
                        });
                    }
                }
            },
            "columns": [
                {data: "conpNombre"},
                {data: "pagImpPago"},
                {data: "pagRefPago"},
                {data: "pagFechaPago"},
                {data: "pagComentario"},
            ],
            //Apply the search
            initComplete: function () {
                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))


                var index = 0
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if (columnClass != 'non_searchable') {
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

    function modalHistorialPagosAluClave(aluClave) {
        //MOSTRAR MODAL
        $('.modal').modal();
        //MOSTRAR GRUPOS
        if ($.fn.DataTable.isDataTable("#tbl-historial-pagos-alu")) {
            $('#tbl-historial-pagos-alu').DataTable().clear().destroy();
        }

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-historial-pagos-alu').dataTable({
            "destroy": true,
            "language":{"url":"api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "bSort": false,
            "ajax": {
                "type" : "GET",
                'url': base_url + "/api/alumno/listHistorialPagosAluclave/" + aluClave,
                beforeSend: function () {
                    $('.preloader-modal').fadeIn(200, function() {
                        $(this).append('<div id="preloader-modal"></div>');
                    });
                },
                complete: function (data) {
                    if (data.responseJSON.data) {
                        var obj = data.responseJSON.data[0];

                        console.log(data.responseJSON);

                        // $(".modal-titulo-periodo").html(obj.periodo.perNumero)
                        // $(".modal-periodo-anio").html(obj.periodo.perAnio)
                    }

                    $('.preloader-modal').fadeOut(200, function() {
                        $('#preloader-modal').remove();
                    });
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
            "columns": [
                {data: "conpNombre"},
                {data: "pagImpPago"},
                {data: "pagRefPago"},
                {data: "pagFechaPago"},
                {data: "pagComentario"},
            ],
            //Apply the search
            initComplete: function () {
                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))


                var index = 0
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if (columnClass != 'non_searchable') {
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

    $(document).on("click", ".btn-modal-historial-pagos", function (e) {
        e.preventDefault()

        var curso_id = $(this).data("curso-id")
        var nombres = $(this).data("nombres")
        var aluclave = $(this).data("aluclave")
        console.log("aluclave")
        console.log(aluclave)

        console.log(nombres)
        $('.modalNombres').html(nombres)

        modalHistorialPagos(curso_id)
        modalHistorialPagosAluClave(aluclave)

    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.modal').modal();

        $(document).on("click", ".btn-modal-preinscrito-detalle", function (e) {
            e.preventDefault()
            var curso_id = $(this).data("curso-id");

            $.get(base_url+`/api/curso/${curso_id}`, function(res,sta) {
                $(".modalCursoId").html(res.curso.id);
                
                if (!res.curso.curExaniFoto.includes(".pdf")) {
                    $('.curexaniimg').attr("src", base_url + "/exani_images/" + res.curso.curExaniFoto)
                    $(".curexaniimg").show()
                    $(".curexanipdf").hide()
                } else {
                    $('.curexanipdf').attr("src", base_url + "/exani_images/" + res.curso.curExaniFoto)
                    $(".curexaniimg").hide()
                    $(".curexanipdf").show()
                }

                $('#curExani').val( res.curso.curExani)
                $(".modalUbiClave").val(res.curso.cgt.plan.programa.escuela.departamento.ubicacion.ubiNombre)
                $(".modalDepartamentoId").val(res.curso.cgt.plan.programa.escuela.departamento.depNombre)
                $(".modalEscuelaId").val(res.curso.cgt.plan.programa.escuela.escNombre)
                $(".modalPeriodo").val(res.curso.cgt.periodo.perNumero + "-" + res.curso.cgt.periodo.perAnio)
                $(".modalPerFechaInicial").val(res.curso.cgt.periodo.perFechaInicial)
                $(".modalPerFechaFinal").val(res.curso.cgt.periodo.perFechaFinal)
                $(".modalProgNombre").val(res.curso.cgt.plan.programa.progNombre)
                $(".modalPlanClave").val(res.curso.cgt.plan.planClave)
                $(".modalCgtGradoSemestre").val(res.curso.cgt.cgtGradoSemestre + "-" + res.curso.cgt.cgtGrupo + "-"+ res.curso.cgt.cgtTurno)
                $(".modalPerNombre").val(res.curso.alumno.persona.perNombre + " " + res.curso.alumno.persona.perApellido1 + " " + res.curso.alumno.persona.perApellido2)

                $(".modalCurEstado").val(res.curEstado)
                $(".modalCurTipoIngreso").val(res.curTipoIngreso)
                $(".modalCurOpcionTitulo").val(res.curOpcionTitulo)

                $(".modalCurAnioCuotas").val(res.curso.curAnioCuotas)
                $(".modalCurImporteInscripcion").val(res.curso.curImporteInscripcion)
                $(".modalCurImporteMensualidad").val(res.curso.curImporteMensualidad)
                $(".modalCurImporteVencimiento").val(res.curso.curImporteVencimiento)
                $(".modalCurImporteDescuento").val(res.curso.curImporteDescuento)
                $(".modalCurDiasProntoPago").val(res.curso.curDiasProntoPago)

                $(".modalCurPlanPago").val(res.curPlanPago)
                $(".modalCurTipoBeca").val(res.curTipoBeca)

                $(".modalCurPorcentajeBeca").val(res.curso.curPorcentajeBeca)
                $(".modalCurObservacionesBeca").val(res.curso.curObservacionesBeca)

                $("#modalPreinscritoDetalle label").addClass("active")
            });
            $('.modal').modal();
        })

    })
</script>

<script>
$(document).on('click', '.confirmar-baja-alumno', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    swal({
            title: "¿Estás seguro?",
            text: "¿Estas seguro que deseas dar de baja a este alumno?",
            type: "warning",
            confirmButtonText: "Si",
            confirmButtonColor: '#3085d6',
            cancelButtonText: "No",
            showCancelButton: true
        },
        function() {
            $(".form-baja-alumno").submit();
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('.modal').modal();

        $(document).on("click", ".btn-modal-baja-curso", function (e) {
            e.preventDefault()
            var curso_id = $(this).data("curso-id");
            $(".modalCursoId").val(curso_id)

            $.get(base_url+`/api/curso/infoBaja/` + curso_id, function(res, sta) {
                console.log(res);
                $(".modalAlumnoClave").html(res.aluClave)
                $(".modalAlumnoNombre").html(res.alumno)

                console.log(res)
                if (res.cantidadInscritos > 0) {
                    $(".modalCursosInfo").html("Esta inscrito a grupos y tiene " + res.cantidadInscritos + " materias.")
                }
                if (res.cantidadInscritos == 0) {
                    $(".modalCursosInfo").html("Este alumno no esta en grupos." )
                }
            })

            $.get(base_url+`/api/curso/conceptosBaja`, function(res,sta) {
                res.forEach(element => {
                    $("#conceptosBaja").append(`<option value=${element.conbClave}>${element.conbNombre}</option>`);
                });
            })

            if ($.fn.DataTable.isDataTable("#tbl-posibles-hermanos")) {
                $('#tbl-posibles-hermanos').DataTable().clear().destroy();
            }
            $.fn.dataTable.ext.errMode = 'throw';
            $('#tbl-posibles-hermanos').dataTable({
                "language":{"url":"api/lang/javascript/datatables"},
                "serverSide": true,
                "dom": '"top"i',
                "ajax": {
                    "type" : "GET",
                    'url': "api/curso/listPosiblesHermanos/" + curso_id,
                    beforeSend: function () {
                        $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
                    },
                    complete: function () {
                        $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
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
                    {data:"aluClave"},
                    {data: "nombreCompleto"},
                ],
            });

            // $.get(base_url+`/api/curso/${curso_id}`, function(res,sta) {
            // });
            $('.modal').modal();
        })
    })
</script>



<script>
    $(document).on('click', '.confirmar-alta-alumno', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
            title: "¿Estás seguro?",
            text: "¿Estas seguro que deseas dar de alta a este alumno?",
            type: "warning",
            confirmButtonText: "Si",
            confirmButtonColor: '#3085d6',
            cancelButtonText: "No",
            showCancelButton: true
        },
        function() {
            $(".form-alta-alumno").submit();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.modal').modal();

        $(document).on("click", ".btn-modal-baja-a-regular", function (e) {
            e.preventDefault()
            var curso_id = $(this).data("curso-id");
            $(".modalCursoId").val(curso_id)

            $.get(base_url + `/api/curso/infoBaja/` + curso_id, function(res, sta) {
                $(".modalAlumnoClave").html(res.aluClave)
                $(".modalAlumnoNombre").html(res.alumno)
                $(".modalProgClave").html(res.progClave)
                $(".modalProgNombre").html(res.progNombre)
                $(".modalPerNumero").html(res.perNumero)
                $(".modalPerAnio").html(res.perAnio)
            })

            $('.modal').modal();
        })
    })
</script>





<script type="text/javascript">
    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'throw';
        var tableCurso = $('#tbl-curso').dataTable({
            "language":{"url":"api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url +"/api/curso",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
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
                {data: "perNumero",name:"periodos.perNumero"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "aluClave",name:"alumnos.aluClave"},
                {data: "aluMatricula",name:"alumnos.aluMatricula"},
                {data:'perApellido1',name: "personas.perApellido1"},
                {data:'perApellido2',name: "personas.perApellido2"},
                {data:'perNombre',name: "personas.perNombre"},
                {data: "curEstado"},
                {data: "curTipoIngreso"},
                {data: "cgtGradoSemestre",name:"cgt.cgtGradoSemestre"},
                {data: "cgtGrupo",name:"cgt.cgtGrupo"},
                {data: "beca"},
                {data: "ubiClave",name:"ubicacion.ubiClave"},
                {data: "depClave",name:"departamentos.depClave"},
                {data: "escClave",name:"escuelas.escClave"},
                {data: "progClave",name:"programas.progClave"},
                {data: "planClave",name:"planes.planClave"},
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
