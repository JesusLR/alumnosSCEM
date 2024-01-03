@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Grupo por semestre (horarios)</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/grupo_semestre/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Grupo por semestre (horarios)</span>
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
                {!! Form::label('tipoReporte', 'Tipo Reporte', ['class' => '']); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;" required>
                  <option value="">Seleccionar</option>
                  <option value="gradoMateria">Grado-Materia</option>
                  <option value="paquete">Paquete</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                <div style="display:none;" class="tipo-grado-materia">
                  {!! Form::label('tipoGradoMateria', 'Tipo Reporte', ['class' => '']); !!}
                  <select name="tipoGradoMateria" id="tipoGradoMateria" class="browser-default validate select2" style="width: 100%;">
                    <option value="horarios">Horarios</option>
                    <option value="maestros">Maestros</option>
                  </select>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('ubiClave', 'Clave de campus *', array('class' => '')); !!}
                <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;" required>
                  @foreach ($ubicacion as $ubi)
                    <option value="{{$ubi->ubiClave}}">{{$ubi->ubiClave}} - {{$ubi->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('depClave', 'Clave departamento *', array('class' => '')); !!}
                  <select name="depClave" id="depClave" class="browser-default validate select2" style="width: 100%;" required>
                  {{-- <option value="" disabled>Seleccionar departamento</option> --}}
                    {{-- @foreach ($departamentos as $dep)
                      <option value="{{$dep->depClave}}">{{$dep->depClave}} - {{$dep->depNombre}}</option>
                    @endforeach --}}
                  </select>

              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('progClave', 'Clave de programa *', array('class' => '')); !!}
                <select name="progClave" id="progClave" class="browser-default validate select2" style="width: 100%;" required>
                  {{-- <option value="" disabled>Seleccionar programa</option> --}}
                  {{-- @foreach ($programas as $programa)
                    <option value="{{$programa->progClave}}">{{$programa->progClave}} - {{$programa->progNombre}}</option>
                  @endforeach --}}
                </select>
              </div>
            </div>
            <div class="row">
              {{-- <div class="col s12 m6 l4">
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
              </div> --}}
              <div class="col s12 m6 l4">
                {!! Form::label('periodo', 'Periodo *', ['class' => '',]); !!}
                <select name="periodo" id="periodo" class="browser-default validate select2" style="width: 100%;">
                  {{-- <option value="" disabled>Seleccionar periodo</option> --}}
                </select>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('fechaInicial', NULL, array('id' => 'fechaInicial', 'readonly')) !!}
                  {!! Form::label('fechaInicial', 'Fecha Inicial', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('fechaFinal', NULL, array('id' => 'fechaFinal','readonly')) !!}
                  {!! Form::label('fechaFinal', 'Fecha Final', array('class' => '')); !!}
                </div>
              </div>
              
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('escClave', 'Clave de escuela *', array('class' => '')); !!}
                <select name="escClave" id="escClave" class="browser-default validate select2" style="width: 100%;" required>
                  {{-- <option value="">Seleccionar escuela</option> --}}
                  {{-- @foreach ($escuelas as $escuela)
                    <option value="{{$escuela->escClave}}">{{$escuela->escClave}} - {{$escuela->escNombre}}</option>
                  @endforeach --}}
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('planClave', 'Clave del plan *', array('class' => '')); !!}
                <select name="planClave" id="planClave" class="browser-default validate select2" style="width: 100%;" required>
                  {{-- <option value="">Seleccionar plan</option> --}}
                  {{-- @foreach ($planes as $plan)
                    <option value="{{$plan->planClave}}">{{$plan->planClave}}</option>
                  @endforeach --}}
                </select>
              </div>
              
              <div class="col s12 m6 l4">
                  {!! Form::label('matClave', 'Clave materia', array('class' => '')); !!}
                  <select name="matClave" id="matClave" class="browser-default validate select2" style="width: 100%;">
                  {{-- <option value="">Seleccionar materia</option> --}}
                  {{-- @foreach ($materias as $materia)
                      <option value="{{$materia->matClave}}">{{$materia->matClave}} - {{$materia->matNombre}}</option>
                    @endforeach --}}
                  </select>
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
              <div class="col s12 m6 l4">
                {!! Form::label('empleado_id', 'Número del maestro', array('class' => '')); !!}
                <select name="empleado_id" id="empleado_id" class="browser-default validate select2" style="width: 100%;">
                  <option value="">Seleccionar maestro</option>
                  @foreach ($empleados as $empleado)
                    <option value="{{$empleado->id}}">
                      {{$empleado->id}} - {{$empleado->persona->perNombre}}
                      {{$empleado->persona->perApellido1}} {{$empleado->persona->perApellido2}}  
                    </option>
                  @endforeach
                </select>
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
  @include('scripts.obtenerDatosClaves')
@endsection