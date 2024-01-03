@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de promedios por grupo</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/resumen_promedios/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de promedios por grupo</span>
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
                {!! Form::label('tipoCalificacion', 'Calificaciones de: *', array('class' => '')); !!}
                <select name="tipoCalificacion" id="tipoCalificacion" class="browser-default validate select2" style="width: 100%;" required>
                  <option value="parcial_1">Parcial 1</option>
                  <option value="parcial_2">Parcial 2</option>
                  <option value="parcial_3">Parcial 3</option>
                  <option value="ordinario">Ordinario</option>
                  <option value="final">Final</option>
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
                {!! Form::label('ubiClave', 'Clave de campus *', array('class' => '')); !!}
                <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;" required>
                  @foreach ($ubicacion as $ubi)
                    <option value="{{$ubi->ubiClave}}">{{$ubi->ubiClave}} - {{$ubi->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('gpoSemestre', NULL, array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('gpoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate')) !!}
                  {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('progClave', 'Clave de programa *', array('class' => '')); !!}
                <select name="progClave" id="progClave" class="browser-default validate select2" style="width: 100%;" required>
                </select>
              </div>
            </div>
            
            <div class="row">
              
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matSemestre', NULL, array('id' => 'matSemestre', 'class' => 'validate', "")) !!}
                  {!! Form::label('matSemestre', 'Semestre de la materia', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                <select name="planClave" id="planClave" class="browser-default validate select2" style="width: 100%;">
                </select>
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
  $.get(base_url+`/resumen_promedios/obtenerProgramas/${ubiClave}`,function(data){
    $('#progClave').empty();
    $('#progClave').append('<option value="">Seleccionar programa</option>');
    $.each(data,function(key,value){
      $('#progClave').append('<option value="'+value.id+'">'+value.progClave+' - '+value.progNombre+'</option>');
    });
    obtenerPlanes($('#progClave').val());
  });
}

function obtenerPlanes(programa_id){
  if(programa_id){
    $.get(base_url+`/resumen_promedios/obtenerPlanes/${programa_id}`,function(data){
      $('#planClave').empty();
      if(data.length > 0){
      $('#planClave').append('<option value="">Seleccionar plan</option>');
      $.each(data,function(key,value){
        $('#planClave').append('<option value="'+value.planClave+'">'+value.planClave+'</option>');
      });
      }
    });
  }else{
    $('#planClave').empty();
  }
}

obtenerProgramas($('#ubiClave').val());

$('#ubiClave').change(function(){
  var ubiClave = $(this).val();
  obtenerProgramas(ubiClave);
});

$('#progClave').change(function(){
  var programa_id = $(this).val();
  obtenerPlanes(programa_id)
});

});
</script>
@endsection