@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Porcentaje de aprobación</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/porcentaje_aprobacion/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Porcentaje de aprobación</span>
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
            <!--
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('tipoReporte', 'Tipo de reporte', ['class' => '']); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                  <option value="MPA">MATERIAS POR ALUMNO</option>
                  <option value="APM">ALUMNOS POR MATERIA</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('periodosIncluir', 'Periodos a incluir', ['class' => '']); !!}
                <select name="periodosIncluir" id="periodosIncluir" class="browser-default validate select2" style="width: 100%;">
                  <option value="">SELECCIONAR</option>
                  <option value="ACTUAL">INCLUIR ACTUAL</option>
                  <option value="SIGUIENTEACTUAL">INCLUIR SIGUIENTE AL ACTUAL</option>
                </select>
              </div>


              <div class="col s12 m6 l4">
                {!! Form::label('alumnosBaja', '¿Desea incluir alumnos dados de baja?', ['class' => '']); !!}
                <select name="alumnosBaja" id="alumnosBaja" class="browser-default validate select2" style="width: 100%;">
                  <option value="NO">NO</option>
                  <option value="SI">SI</option>
                </select>
              </div>

            </div>
            <div class="row">

              <div class="col s12 m6 l4">
                {!! Form::label('incluirNoCursadas', '¿Desea incluir materias no  cursadas, o solo reprobados?', ['class' => '']); !!}
                <select name="incluirNoCursadas" id="incluirNoCursadas" class="browser-default validate select2" style="width: 100%;">
                  <option value="NO">INCLUIR NO CURSADAS</option>
                  <option value="REP">SOLO REPROBADOS</option>
                </select>
              </div>
            </div>
            <hr>
          --> 
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('ubiClave', 'Clave de campus*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('depClave', 'Clave departamento*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('escClave', 'Clave de escuela*', array('class' => '')); !!}
                </div>
              </div>
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
            </div>
    

            <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                    {!! Form::label('perNumero', 'Número de periodo*', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                    {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
                  </div>
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