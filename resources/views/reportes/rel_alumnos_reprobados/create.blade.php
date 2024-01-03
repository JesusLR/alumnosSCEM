@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de alumnos reprobados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/rel_alumnos_reprobados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de alumnos reprobados</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>
          @if (session('status'))
          <div class="alert alert-success">
              {{ session('status') }}
          </div>
          @endif

          {{-- GENERAL BAR--}}
          <div id="filtros">
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('tipoReporte', 'Seleccione el tipo de reporte *', array('class' => '')); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" style="width: 100%;" required>
                  <option value="1">Cuatro o más reprobadas</option>
                  <option value="2">Materias Seriadas</option>
                  <option value="3">Mas de un año de antigüedad</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('formatoReporte', 'Seleccione el formato de reporte *', array('class' => '')); !!}
                <select name="formatoReporte" id="formatoReporte" class="browser-default validate select2" style="width: 100%;" required>
                  <option value="PDF">PDF</option>
                  <option value="EXCEL">EXCEL</option>
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
                {!! Form::label('ubiClave', 'Clave de ubicación', array('class' => '')); !!}
                <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width: 100%;">
                  <option value="">SELECCIONAR UBICACIÓN</option>
                  @foreach ($ubicacion as $ubi)
                    <option value="{{$ubi->ubiClave}}">{{$ubi->ubiClave}} - {{$ubi->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                <select name="depClave" id="depClave" class="browser-default validate select2" style="width: 100%;">
                  <option value="">SELECCIONAR DEPARTAMENTO</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('escClave', 'Clave de la escuela', array('class' => '')); !!}
                <select name="escClave" id="escClave" class="browser-default validate select2" style="width: 100%;">
                  <option value="">SELECCIONAR ESCUELA</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                <select name="progClave" id="progClave" class="browser-default validate select2" style="width: 100%;">
                  <option value="">SELECCIONAR PROGRAMA</option>
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

@include('scripts.obtenerDatosClaves')

@endsection