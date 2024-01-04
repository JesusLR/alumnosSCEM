@extends('layouts.dashboard')

@section('template_title')
    Registrarse a extraodinario
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
    <style type="text/css">
        .urgente-aprobar-row td {
            font-weight: bolder;
            color: #A31818;
        }
    </style>
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('inscribirse_extraordinario')}}" class="breadcrumb">Solicitud de Extraordinarios</a>
@endsection

@section('content')

    @php
        $alumno_id = $alumno->id;
    @endphp
<div id="table-datatables">
    <h4 class="header">Solicitud de Exámenes Extraordinarios</h4>
    <p><b>Clave:</b> {{$alumno->aluClave}}</p>
    <p><b>Nombre:</b> {{$persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2}}</p>

    {{-- SI ES DEUDOR , NO ENTRA --}}
    @if (floatval($pago->importe_adeudado) > 0)
        <p style="color:#aa093f; font-size:20px;"><b>Aviso Importante: Su matrícula presenta una deuda en pago de colegiaturas ó inscripciones.</b></p>
        <p style="color:black;font-weight: bold; font-size: 16px">Favor de comunicarse a la oficina de:
            <br>Coordinación Administrativa<br>Teléfonos: 9999-301900 ext. 1151 ó 9991-356225 <br>Email: coordinacion.administrativa@modelo.edu.mx</p>
    @else

        {{-- CONDICION PARA EQ, LO MANDO A DEPARTAMENTO CON CELIA --}}
        @if ($curTipoIngreso == 'EQ')
            <p style="color:#aa093f; font-size:20px;"><b>Estimado alumno(a): Usted solicitó la revalidación de materias dentro de los últimos 4 periodos de su plan de estudios. <br>Es importante que se dirija personalmente a la oficina de Secretaría Académica, para inscribirse a sus exámenes extraordinarios.</b></p>
            <p style="color:black;font-weight: bold; font-size: 16px">Favor de comunicarse a la brevedad:
                <br>Secretaría Académica<br>M.G.E. SILVIA CANDELARIA BARAHONA RAMÍREZ<br>Tel.: 999 - 9301900 ext. 1130<br>Email: sil_bar@modelo.edu.mx</p>
        @else

            {{-- NO TIENE MATERIAS REPROBADAS SEGUN EL SP --}}
            @if($reprobadas->isEmpty())
                <p style="color:#18A330; font-size:20px;"><b>No tienes materias reprobadas disponibles</b></p>

            @else

                {{-- NO TIENE EXAMENES DISPONIBLES PARA LA MATERIA QUE NECESITA APROBAR --}}
                @if($reprobadasSinExtrasSinEduVida->isNotEmpty())
                    <p><b>NOTA:</b> Las materias marcadas en <b style="color:#A31818;">rojo</b> son urgentes por aprobar.</p>
                    <hr>

                    <p>Las siguientes materias no tienen creado un extraordinario. Solicita a tu coordinador que agende extraordinarios para estas materias.</p>
                    <ul>
                        @foreach($reprobadasSinExtras as $reprobada)
                            <li style="{{$reprobada->maxSemestre - $reprobada->matSemestre > 1 ? 'color: #A31818;' : ''}}">
                                {{$reprobada->matClave}} - {{$reprobada->matNombre}}
                            </li>
                        @endforeach
                    </ul>

                @else

                    {{-- PUEDE SELECCIONAR EXAMENES EXTRAS --}}
                    <p><b>NOTA:</b> Las materias marcadas en <b style="color:#A31818;">rojo</b> son urgentes por aprobar.</p>
                    <hr>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <form action="{{route('inscribirse_extraordinario.store')}}" method="POST" id="form_inscribir">
                                @csrf
                                <input type="hidden" name="alumno_id" id="alumno_id" value="{{$alumno_id}}">
                                <input type="hidden" name="total_a_pagar" id="total_a_pagar" value="0.00">
                                <button id="btn_inscribir" class="btn-large waves-effect darken-3">Generar la Ficha de Pago<i class="material-icons right">forward</i>
                                </button>
                            </form>
                        </div>
                        <div class="col s12 m6 l4 offset-m2 offset-l4">
                            <div class="input-field">
                                <input type="number" name="total_pagos" id="total_pagos" value="0.00" class="validate" step="0.01" readonly>
                                <label for="total_pagos">TOTAL A PAGAR</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col s12">
                            <table id="tbl-extraordinarios" class="responsive-table display" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    {{-- <th>No.</th> --}}
                                    <th>Folio</th>
                                    <th>Ubicacion</th>
                                    <th>Carrera</th>
                                    <th>Plan</th>
                                    <th>Mat.Clave</th>
                                    <th>Materia</th>
                                    <th>Docente</th>
                                    <th width="70">Fecha</th>
                                    <th width="50">Hora</th>
                                    <th width="50">Costo</th>
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
                                    <th width="70" class="non_searchable"></th>
                                    <th width="50" class="non_searchable"></th>
                                    <th width="50" class="non_searchable"></th>
                                    <th class="non_searchable"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="preloader">
                        <div id="preloader"></div>
                    </div>

                @endif



            @endif


        @endif


    @endif

    {{-- CONDICION PARA HABILITAR SOLICITUD DE EXAMENES --}}
    {{--
    @if ($alumno->aluClave !== '000')
        <p style="color:#aa093f; font-size:20px;"><b>Aviso Importante: La solicitud de extraordinarios ha concluido. Favor de dirigirse con su Coordinador de Carrera, para resolver cualquier aclaración.</b></p>
    @else
    --}}



</div>




@endsection

@section('footer_scripts')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}

<script type="text/javascript">
    $(document).ready(function() {

        const alumno_id = {!! json_encode($alumno_id) !!};
        const reprobadas = {!! json_encode($reprobadas) !!};

        $.fn.dataTable.ext.errMode = 'throw';
        const tbl_extras = $('#tbl-extraordinarios').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "ordering": false,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/inscribirse_extraordinario/" + alumno_id,
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                    verificar_cantidad_extras(checkboxes_id, reprobadas); //Impide seleccionar más de 15.
                    mantener_checked(checkboxes_id); //evita uncheck al recargar DataTable.
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
            "createdRow": function(row, data, index) {
                /*
                if(reprobadas.length >= 5 && data.DT_RowIndex > 5) {
                    $(row).find('.check_inscribir').attr('disabled', true);
                }
                */
            },
            "columns":[
                {data: "id", name: "id"},
                {data: "materia.plan.programa.escuela.departamento.ubicacion.ubiNombre", name:"materia.plan.programa.escuela.departamento.ubicacion.ubiNombre"},
                {data: "materia.plan.programa.progNombre", name:"materia.plan.programa.progNombre"},
                {data: "materia.plan.planClave", name:"materia.plan.planClave"},
                {data: "materia.matClave", name:"materia.matClave"},
                {data: "matNombreCompleto", name:"matNombreCompleto"},
                {data: "nombreDocente", name:"nombreDocente"},
                {data: "extFecha", name:"extFecha"},
                {data: "extHora", name:"extHora"},
                {data: "extPago", name:"extPago"},
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

        $('#btn_inscribir').on('click', function(e) {
            e.preventDefault();
            $(this).prop('disabled', true);
            $('#form_inscribir').submit();
        });



        /** ###############################################################
        * Esta sección manipula los checkboxes del DataTable.
        * --------------------------------------------------------------- */

        var total_pagos = 0;
        var checkboxes_id = []; //evitará que se pierda la selección de checkboxes al recargar el DataTable.

        $('#tbl-extraordinarios').on('click', '.check_inscribir', function() {
            var costo = parseFloat($(this).data('costo')) || 0;
            var extra_id = $(this).prop('id');
            var value_id = $(this).val();
            var input_id = 'examen_' + value_id;

            if($(this).is(':checked')) {
                total_pagos += costo;
                addInput('form_inscribir', input_id, value_id)
            } else {
                total_pagos -= costo;
                $('#' + input_id).remove();
            }

            $('#total_pagos').val(total_pagos.toFixed(2));
            $('#total_a_pagar').val(total_pagos.toFixed(2));
            actualizar_array(checkboxes_id, extra_id);
            verificar_cantidad_extras(checkboxes_id, reprobadas); //Impide seleccionar más de 15.
            mantener_checked(checkboxes_id); //evita el uncheck al recargar DataTable.
        });

    }); //document.ready function


    function verificar_cantidad_extras(checkboxes_id = [], reprobadas = []) {
        var cantidad = checkboxes_id.length;
        array_maped = checkboxes_id.map((value) => {return '#'+value});
        var unchecked_boxes = $('.check_inscribir').not(array_maped.join(','));
        if(reprobadas.length < 15){
            cantidad >= 15 ? unchecked_boxes.prop('disabled',true) : unchecked_boxes.removeAttr('disabled');
        }
        // Botón "Inscribirse y pagar"
        cantidad < 1 ? $('#btn_inscribir').prop('disabled', true) : $('#btn_inscribir').removeAttr('disabled');

    }//verificar_cantidad_extras

    function actualizar_array(checkboxes_id, extra_id) {
        if(checkboxes_id.includes(extra_id)) {
            index_extra = checkboxes_id.indexOf(extra_id);
            checkboxes_id.splice(index_extra, 1);
        } else {
            checkboxes_id.push(extra_id);
        }
    }//actualizar_array.

    function mantener_checked(checkboxes_id) {
        $.each(checkboxes_id, function(key, value) {
            $('#' + value).prop('checked', true);
        });
    }//mantener_checked.

    function addInput(targetForm, id, value) {
      var newInput = `<input type="hidden" id="${id}" name="extraordinarios_id[]" value="${value}">`;
      $('#' + targetForm).append(newInput);
    }//addInput.





</script>

@endsection
