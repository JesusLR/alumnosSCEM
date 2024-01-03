@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Indice de reprobación</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/indice_reprobacion/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Indice de reprobación</span>
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
              <div class="input-field">
                {!! Form::number('perNumero', '', array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                {!! Form::label('perNumero', 'Número de periodo*', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::number('perAnio', '', array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
              <div class="input-field">
                {!! Form::text('ubiClave', '', array('id' => 'ubiClave', 'class' => 'validate', "required")) !!}
                {!! Form::label('ubiClave', 'Clave de campus*', array('class' => '')); !!}
              </div>
            </div>
            
          </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', '', array('id' => 'depClave', 'class' => 'validate')) !!}
                  {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', '', array('id' => 'escClave', 'class' => 'validate')) !!}
                  {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', '', array('id' => 'progClave', 'class' => 'validate')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('cgtGrado', '', array('id' => 'cgtGrado', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrado', 'Grado o Semestre', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('cgtGrupo', '', array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              
              
              <div class="col s12 m6 l4">
                {!! Form::label('Estado', 'Estado en curso', ['class' => '']); !!}
                <select name="curEstado" id="curEstado" class="browser-default validate select2" style="width: 100%;">
                  <option value="R" selected>Regulares</option>
                  <option value="P">Pre-inscritos</option>
                  <option value="B">Baja</option>
                  <option value="C">Condicionados</option>
                  <option value="A">Condicionados 2</option>
                  <option value="">Todos</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('Evaluacion', 'Identificación de la evaluación', ['class' => '']); !!}
                <select name="evaluacion" id="evaluacion" class="browser-default validate select2" required style="width: 100%;">
                  <option value="1" selected>Primer parcial</option>
                  <option value="2">Segundo parcial</option>
                  <option value="3">Tercer parcial</option>
                  <option value="O">Examen ordinario</option>
                  <option value="F">Examen final</option>
                  {{-- <option value="E">Extraordinarios</option> --}}
                </select>
              </div>
            </div>
    

            
           <!--
            <div class="row">
              <div class="col s12 m6 l6">
                <p style="margin-bottom: -15px;">Poner clave de materia si quiere incluir una materia específica.</p>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave de materia', ['class' => '']); !!}

                </div>
              </div>
            </div>
          -->
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
  @include('scripts.grupo-semestre')
@endsection