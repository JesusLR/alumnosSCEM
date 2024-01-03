@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de alumnos no inscritos/bajas del siguiente curso</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/res_alumnos_no_inscritos/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de alumnos no inscritos/bajas del siguiente curso</span>
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
                {!! Form::label('periodoSiguiente', 'Seleccione el curso a validar inscripción *', array('class' => '')); !!}
                <select name="periodoSiguiente" id="periodoSiguiente" class="browser-default validate select2" style="width: 100%;" required>
                  <option value="uno">Siguiente período</option>
                  <option value="dos">Dos períodos después</option>
                </select>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', 'required')) !!}
                  {!! Form::label('perNumero', 'Número de periodo *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, 'required')) !!}
                  {!! Form::label('perAnio', 'Año de periodo *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('ubiClave', 'Clave de ubicación *', array('class' => '')); !!}
                <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;" required>
                  @foreach ($ubicacion as $ubi)
                    <option value="{{$ubi->ubiClave}}">{{$ubi->ubiClave}} - {{$ubi->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('progClave', 'Clave de programa *', array('class' => '')); !!}
                <select name="progClave" id="progClave" class="browser-default validate select2" style="width: 100%;" required>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('escClave', 'Clave de la escuela', array('class' => '')); !!}
                <select name="escClave" id="escClave" class="browser-default validate select2" style="width: 100%;">
                </select>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
                </div>
              </div>
            </div>

        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
<script>
$(document).ready(function(){
function obtenerProgramas(ubiClave){
  $.get(base_url+`/res_alumnos_no_inscritos/obtenerProgramas/${ubiClave}`,function(data){
    $('#progClave').empty();
    $.each(data,function(key,value){
      $('#progClave').append('<option value="'+value.progClave+'">'+value.progClave+' - '+value.progNombre+'</option>');
    });
  });
}

function obtenerEscuelas(ubiClave){
  if(ubiClave){
    $.get(base_url+`/res_alumnos_no_inscritos/obtenerEscuelas/${ubiClave}`,function(data){
      $('#escClave').empty();
      if(data.length > 0){
      $('#escClave').append('<option value="">Seleccionar escuela</option>');
      $.each(data,function(key,value){
        $('#escClave').append('<option value="'+value.escClave+'">'+value.escClave+' - '+value.escNombre+'</option>');
      });
      }
    });
  }else{
    $('#escClave').empty();
  }
}

obtenerProgramas($('#ubiClave').val());
obtenerEscuelas($('#ubiClave').val());

$('#ubiClave').change(function(){
  var ubiClave = $(this).val();
  obtenerProgramas(ubiClave);
  obtenerEscuelas(ubiClave);
});

});
</script>
@endsection