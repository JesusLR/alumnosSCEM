@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Horario por grupo</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/horario_por_grupo/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">HORARIO POR GRUPO</span>

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
                    {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                    {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m4 l4">
                    {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                    <select name="escClave" id="escClave" class="browser-default validate select2" style="width: 100%;" required>
                      <option value="">Seleccionar</option>
                      @foreach ($escuelas as $escuela)
                        <option value="{{$escuela->escClave}}">{{$escuela->escClave}} - {{$escuela->escNombre}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="col s12 m4 l4">
                  <div class="input-field">
                    {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m4 l4">
                  <div class="input-field">
                    {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
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
@endsection