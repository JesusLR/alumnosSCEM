@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de alumnos becados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/alumnos_becados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de alumnos becados</span>
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
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('imprValidarHrmnos', '¿Imprimir para validar hermanos?', ['class' => '']); !!}
                <select name="imprValidarHrmnos" id="imprValidarHrmnos" class="browser-default validate select2" style="width: 100%;">
                  <option value="NO">NO</option>
                  <option value="SI">SI</option>
                </select>
              </div>


              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('tipoReporte', 'Tipo de reporte', ['class' => '']); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;">
                  <option value="N">Normal</option>
                  <option value="F">Solo firmas</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m12 l12">
                <hr />
              </div>
            </div>



            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate', 'required')) !!}
                  {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate')) !!}
                  {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate')) !!}
                    {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
              </div>

              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perAnioPago', NULL, array('id' => 'perAnioPago', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('perAnioPago', 'Año inicio curso', array('class' => '')); !!}
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate', "")) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matrícula', array('class' => '')); !!}
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

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('cgtGradoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                </div>
              </div>

              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('curTipoBeca', 'Tipo beca', ['class' => '']); !!}
                <select name="curTipoBeca" id="curTipoBeca" class="browser-default validate select2" style="width: 100%;">
                  <option value="">Seleccionar</option>
                  @foreach ($tiposBeca as $beca)
                    <option value="{{$beca->bcaClave}}">{{$beca->bcaNombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('curPorcentajeBeca', NULL, array('id' => 'curPorcentajeBeca', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('curPorcentajeBeca', 'Porcentaje beca', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('curObservacionesBeca', NULL, array('id' => 'curObservacionesBeca', 'class' => 'validate')) !!}
                  {!! Form::label('curObservacionesBeca', 'Observaciones', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::label('curFechaRegistro', 'Fecha registro', ['class' => '', 'style' => 'margin-top: -16px;']); !!}
                  <input id="curFechaRegistro" name="curFechaRegistro" class="validate" type="date" value="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('curEstado', 'Curso estado *', ['class' => '']); !!}
                <select name="curEstado" id="curEstado" class="browser-default validate select2 required" style="width: 100%;">
                  <option value="">TODOS</option>
                  @foreach ($estadosCurso as $key => $estadoCurso)
                    <option value="{{$key}}">{{$estadoCurso}}</option>
                  @endforeach
                </select>
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
@endsection