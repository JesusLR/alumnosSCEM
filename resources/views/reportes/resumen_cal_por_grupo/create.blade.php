@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de calificación por grupo</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/resumen_cal_grupos/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de calificación por grupo</span>
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
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número de periodo*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
                </div>
              </div>
            </div>

            
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
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('escClave', 'Clave escuela*', array('class' => '')); !!}
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
                  {!! Form::text('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
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
                {!! Form::label('tipoCalificacion', 'Seleccionar calificacion', ['class' => '']); !!}
                <select name="tipoCalificacion" id="tipoCalificacion" class="browser-default validate select2" style="width: 100%;">
                    <option value="1P">1er Parcial</option>
                    <option value="2P">2do Parcial</option>
                    <option value="3P">3er Parcial</option>
                    <option value="ORD">Ordinario</option>
                    <option value="FINAL">Final</option>
                </select>
              </div>

              <div class="col s12 m6 l4">
                {!! Form::label('incluyeFaltas', '¿Incluye faltas?', ['class' => '']); !!}
                <select name="incluyeFaltas" id="incluyeFaltas" class="browser-default validate select2" style="width: 100%;">
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
              </div>

              <div class="col s12 m6 l4">
                {!! Form::label('incluyeMaterias', 'Incluye materias', ['class' => '']); !!}
                <select name="incluyeMaterias" id="incluyeMaterias" class="browser-default validate select2" style="width: 100%;">
                    <option value="BASICAS">BASICAS</option>
                    <option value="OPT">OPTATIVAS</option>
                    <option value="AMBAS">AMBAS</option>
                </select>
              </div>
            </div>





            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                    {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('aluClave', 'Clave pago', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                    {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('aluMatricula', 'Matricula', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido1', 'Apellido paterno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido2', 'Apellido materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
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