@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de grupos equivalentes</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/rel_grupos_equivalentes/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de grupos equivalentes</span>
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
                {!! Form::number('perAnio', '', array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year+1, "required")) !!}
                {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
              </div>
            </div>
            <div class="col s12 m6 l4">
                {!! Form::label('Ubicacion', 'Ubicación', ['class' => '']); !!}
                <select name="ubiClave" id="ubiClave" class="browser-default validate select2" required style="width: 100%;">
                  <option value="CME" selected>CME</option>
                  <option value="CVA">CVA</option>
                  <option value="CCH">CCH</option>
                </select>
              </div>
            
          </div>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('Departamento', 'Departamento', ['class' => '']); !!}
                <select name="depClave" id="depClave" class="browser-default validate select2" required style="width: 100%;">
                  <option value="SUP" selected>SUP</option>
                  <option value="POS">POS</option>
                </select>
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
                  {!! Form::text('planClave', '', array('id' => 'planClave', 'class' => 'validate')) !!}
                  {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('cgtGrado', '', array('id' => 'cgtGrado', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrado', 'Grado o Semestre', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field"> 
                  {!! Form::text('matClave', '', array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('cgtGrupo', '', array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grado o Semestre', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('cgtInscritos', '', array('id' => 'cgtInscritos', 'class' => 'validate')) !!}
                  {!! Form::label('cgtInscritos', 'Núm. alumnos inscritos', array('class' => '')); !!}
                </div>
              </div>
            </div>
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