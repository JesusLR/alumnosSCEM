@extends('layouts.dashboard')

@section('template_title')
    Referencia de pago
@endsection

@section('head')
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('pago')}}" class="breadcrumb">Referencia de pago</a>
@endsection

@section('content')
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'storeFichaGeneral', 'method' => 'POST',  "target" => "_blank"]) !!}
    <div class="card ">
        <div class="card-content ">
        <span class="card-title">GENERAR REFERENCIA DE PAGO</span>

        {{-- NAVIGATION BAR--}}
        <nav class="nav-extended">
            <div class="nav-content">
            <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#general">General</a></li>
            </ul>
            </div>
        </nav>

        {{-- GENERAL BAR--}}
        <div id="general">
            <div class="row">
                <input id="curso_id" name="curso_id" value="" type="hidden" />
                <input id="cursoAlumno" name="cursoAlumno" value="" type="hidden" />
                <div class="col s12 l3">
                    {!! Form::label('cuoFecha', 'Fecha del día de hoy *', ['class' => '']); !!}
                    <input id="cuoFecha" name="cuoFecha" class="validate" type="date" required value="<?= date("Y-m-d"); ?>">
                </div>
                <div class="col s12 l3">
                    <div class="input-field">
                    {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                    {!! Form::label('aluClave', 'Clave de alumno *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l3">
                    <div class="input-field">
                    {!! Form::number('cuoAnio', NULL, array('id' => 'cuoAnio', 'class' => 'validate','maxLength' => '4','required')) !!}
                    {!! Form::label('cuoAnio', 'Año de inicio de curso *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l3">
                    {!! Form::button('<i class="material-icons left">search</i> Buscar', ['id'=>'buscarAlumno','class' => 'btn-large waves-effect  darken-3']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('ubiNombre', NULL, array('id' => 'ubiNombre', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('ubiNombre', 'Ubicación (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('perNumero', 'Periodo (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div>
                <div class="col s12">
                    <div class="input-field">
                    {!! Form::text('aluNombre', NULL, array('id' => 'aluNombre', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('aluNombre', 'Nombre de alumno (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col s12 m6 l3">

                    {!! Form::label('cuoConcepto', 'Concepto *', ['class' => '']); !!}
                    <select id="cuoConcepto" class="browser-default validate select2" required name="cuoConcepto" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        @foreach($conceptosPago as $concepto)
                            <option value="{{$concepto->conpClave}}">{{$concepto->conpClave}} {{$concepto->conpNombre}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col s12 l3">
                    {!! Form::button('<i class="material-icons left">search</i> Buscar', ['id'=>'buscarConcepto','class' => 'btn-large waves-effect  darken-3']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <div class="input-field">
                    {!! Form::text('nomConcepto', NULL, array('id' => 'nomConcepto', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('nomConcepto', 'Nombre de concepto (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l3">
                    <div class="input-field">
                    {!! Form::text('importeNormal', NULL, array('id' => 'importeNormal', 'class' => 'validate','required')) !!}
                    {!! Form::label('importeNormal', 'Importe pago normal *', ['class' => '']); !!}
                    </div>
                </div>

                <div class="col s12 l3">
                    {!! Form::label('cuoFechaVenc', 'Fecha de vencimiento (opcional)', ['class' => '']); !!}
                    <input id="cuoFechaVenc" name="cuoFechaVenc" class="validate" type="date" value="">
                </div>
            </div>

        </div>

        </div>
        <div class="card-action">
        {!! Form::button('<i class="material-icons left">save</i> Generar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('footer_scripts')
<script type="text/javascript">

   $(document).on('click', '#buscarAlumno', function (e) {
       var aluClave = $('#aluClave').val();
       var cuoAnio = $('#cuoAnio').val();
        $.get(base_url+`/api/curso/alumno/${aluClave}/${cuoAnio}`, function(res,sta) {
            if(jQuery.isEmptyObject(res)){
                swal({
                    title: "Ups...",
                    text: "No se encontro el alumno",
                    type: "warning",
                    confirmButtonText: "Ok",
                    confirmButtonColor: '#3085d6',
                    showCancelButton: false
                });
            }else{

                $("#cursoAlumno").val(JSON.stringify(res))

                $('#curso_id').val(res.id);
                $('#ubiNombre').val(res.cgt.periodo.departamento.ubicacion.ubiNombre);
                $('#perNumero').val(res.cgt.cgtGradoSemestre + ' SEMESTRE DE ' + res.cgt.plan.programa.progNombre);
                $('#aluNombre').val(res.alumno.persona.perNombre + ' ' + res.alumno.persona.perApellido1 + ' ' + res.alumno.persona.perApellido2);
                Materialize.updateTextFields();
            }
        });
    });

    console.log(base_url);

    $(document).on('click', '#buscarConcepto', function (e) {
      var cuoConcepto = $('#cuoConcepto').val();
      console.log(cuoConcepto)

      $.get(base_url + `/pagos/ficha_general/obtenerCuotaConcepto/${cuoConcepto}`, function(res, sta) {
        var concepto = JSON.parse(res)


        var cursoAlumno = $("#cursoAlumno").val()
        cursoAlumno = JSON.parse(cursoAlumno)
        console.log(concepto)


        var perAnioPago = cursoAlumno.cgt.periodo.perAnioPago;
        if (parseInt(concepto.conpClave) >= 5 && cuoConcepto != 99) {
            perAnioPago = parseInt(cursoAlumno.cgt.periodo.perAnioPago) + 1;
        }

        if ([1,2,3,4].includes(parseInt(concepto.conpClave))) {
            perAnioPago = cursoAlumno.cgt.periodo.perAnioPago
        }


        if (!(cuoConcepto >= 1 && cuoConcepto <= 12)) {
            perAnioPago = ""
        }



        if (jQuery.isEmptyObject(concepto)) {
          swal({
              title: "Ups...",
              text: "No se encontro el concepto",
              type: "warning",
              confirmButtonText: "Ok",
              confirmButtonColor: '#3085d6',
              showCancelButton: false
          });
          return;
        }

        $("#nomConcepto").val(concepto.conpNombre + " " + perAnioPago)
        Materialize.updateTextFields();
      });
    });

</script>
@endsection