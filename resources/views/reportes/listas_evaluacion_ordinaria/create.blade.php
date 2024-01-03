@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Listas para evaluación ordinaria</a>
@endsection

@section('content')
  <div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/listas_evaluacion_ordinaria/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">LISTAS PARA EVALUACIÓN ORDINARIA</span>

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
                    {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                  </div>
                </div>
                
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 14">
                    {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                    {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 14">
                    {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate', "required")) !!}
                    {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 14">
                    {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 14">
                    {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 14">
                    {!! Form::number('gpoSemestre', NULL, array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('gpoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 14">
                    {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate')) !!}
                    {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                    {!! Form::label('matClave', 'Clave de materia', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('empleado_id', NULL, array('id' => 'empleado_id', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col s12 m3 l1" style="margin-top: 33px!important;">
                  <select name="filtroNumAlumnos" id="filtroNumAlumnos" class="browser-default select2" style="width: 100%;">
                    <option value="mayor">Mayor que</option>
                    <option value="menor">Menor que</option>
                    <option value="igual">Igual a</option>
                  </select>
                </div>
                <div class="col s12 m6 l3">
                  <div class="input-field">
                    {!! Form::number('numAlumnos', NULL, array('id' => 'numAlumnos', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('numAlumnos', 'Número de alumnos', array('class' => '')); !!}
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
    @include('scripts.preferencias')
@endsection