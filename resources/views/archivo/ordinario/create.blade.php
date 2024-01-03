@extends('layouts.dashboard')

@section('template_title')
    Archivos SEP
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('archivo/ordinario')}}" class="breadcrumb">Generar archivo ordinario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'archivo/ordinario/descargar', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">GENERAR ARCHIVO ORDINARIO</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="filtros">

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" name="ubicacion_id" style="width: 100%;" required>
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" name="departamento_id" style="width: 100%;" required>
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    {{-- <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela (opcional)', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" class="browser-default validate select2" name="periodo_id" style="width: 100%;" required>
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tipo', 'Tipo *', array('class' => '')); !!}
                        <select id="tipo" class="browser-default validate select2" name="tipo" style="width: 100%;" required>
                            @foreach($tipos as $key => $value)
                                <option value="{{$key}}" @if(old('tipo') == $key) {{ 'selected' }} @endif>{{$key}}){{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">note_add</i> GENERAR ARCHIVOS', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection


@section('footer_scripts')

@include('scripts.departamentos')
<script type="text/javascript">
    $(document).ready(function() {
        function obtenerEscuelas (departamentoId) {

            console.log(departamentoId)
            $("#escuela_id").empty();
            
            $("#periodo_id").empty();
            $("#programa_id").empty();
            $("#plan_id").empty();
            $("#cgt_id").empty();
            $("#materia_id").empty();
            $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            
            $("#perFechaInicial").val('');
            $("#perFechaFinal").val('');



            // $.get(base_url+`/api/escuelas/${departamentoId}`,function(res,sta){

            //     //seleccionar el post preservado
            //     var escuelaSeleccionadoOld = $("#escuela_id").data("escuela-idold")
            //     $("#escuela_id").empty()

            //     res.forEach(element => {
            //         var selected = "";
            //         if (element.id === escuelaSeleccionadoOld) {
            //             selected = "selected";
            //         }

            //         $("#escuela_id").append(`<option value=${element.id} ${selected}>${element.escClave}-${element.escNombre}</option>`);
            //     });

            //     $('#escuela_id').trigger('change'); // Notify only Select2 of changes

            // });

            //OBTENER PERIODOS
            $.get(base_url+`/api/periodos/${departamentoId}`,function(res2,sta){
                var perSeleccionado;


                var periodoSeleccionadoOld = $("#periodo_id").data("periodo-idold")

                console.log(periodoSeleccionadoOld)
                $("#periodo_id").empty()
                res2.forEach(element => {

                    var selected = "";
                    if (element.id === periodoSeleccionadoOld) {
                        selected = "selected";
                    }

                    $("#periodo_id").append(`<option value=${element.id} ${selected}>${element.perNumero}-${element.perAnio}</option>`);
                });
                //OBTENER FECHA INICIAL Y FINAL DEL PERIODO SELECCIONADO
                $.get(base_url+`/api/periodo/${perSeleccionado}`,function(res3,sta){
                    $("#perFechaInicial").val(res3.perFechaInicial);
                    $("#perFechaFinal").val(res3.perFechaFinal);
                    Materialize.updateTextFields();
                });

                $('#periodo_id').trigger('change'); // Notify only Select2 of changes
            });//TERMINA PERIODO
        }


        $("#departamento_id").change( event => {
            obtenerEscuelas(event.target.value)
        });
     });
</script>
@include('scripts.periodos')

@endsection