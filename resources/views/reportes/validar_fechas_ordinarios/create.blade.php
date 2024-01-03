@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Posibles hermanos</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/validar_fechas_ordinarios/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Posibles hermanos</span>
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
                  {!! Form::label('tipoReporte', 'Tipo de reporte', ['class' => '']); !!}
                  <br><br>
                  <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;" required>
                    <option value="C">Mostrar por carrera</option>
                    <option value="P">Mostrar por plan</option>
                  </select>
                </div>
              </div>
            </div>      
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::label('ubiClave', 'Campus', ['class' => '']); !!}
                  <br><br>
                  <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;" required>
                    <option value="">Seleccionar Ubicación</option>
                    @foreach ($ubicaciones as $key => $ubicacion)
                    <option value="{{$key}}">{{$ubicacion}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::label('depClave', 'Departamento', ['class' => '']); !!}
                  <br><br>
                  <select name="depClave" id="depClave" class="browser-default validate select2" required style="width:100%;">
                    <option value="">Seleccionar Departamento</option>
                    <option value="SUP">SUP</option>
                    <option value="POS">POS</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <br>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$fechaActual->year, "required")) !!}
                  {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                </div>
              </div>
               
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate', "required")) !!}
                  {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                </div>
              </div> 
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','maxlength'=>'3')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','maxlength'=>'4')) !!}
                  {!! Form::label('planClave', 'Clave de plan', array('class' => '')); !!}
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <p style="text-align:center;">Semestre</p>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('gpoSemestre', NULL, array('id' => 'gpoSemestre', 'class' => 'validate','min'=>'0','max'=>'12')) !!}
                  {!! Form::label('gpoSemestre', 'Grado', array('class' => '')); !!}
                </div> 
                <div class="input-field col s12 m6 14">
                  {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('gpoClave','Grupo', array('class' => '')); !!}
                </div> 
              </div>
              <div class="col s12 m6 l4">
                <br>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave de materia', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 16">
                  {!! Form::number('inscritos_gpo', NULL, array('id' => 'inscritos_gpo', 'class' => 'validate','min'=>'0','max'=>'12')) !!}
                  {!! Form::label('inscritos_gpo', 'No. de Inscritos', array('class' => '')); !!}
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