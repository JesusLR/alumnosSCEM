@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de inscritos</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/resumen_inscritos/exportarExcel', 'method' => 'GET']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de inscritos</span>
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
                {!! Form::label('tipoReporte', 'Tipo de reporte', ['class' => '',]); !!}
                <select name="tipoReporte" id="tipoReporte" class="browser-default validate select2" required style="width: 100%;" required>
                  <option value="I" selected>Inscritos</option>
                  <option value="P">Preinscritos y condicionados</option>
                </select>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', 'required')) !!}
                  {!! Form::label('perNumero', 'Número del período *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year + 1,'required')) !!}
                  {!! Form::label('perAnio', 'Año del período *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('ubiClave', 'Clave de ubicación', ['class' => '',]); !!}
                <select name="ubiClave" id="ubiClave" class="browser-default validate select2" required style="width: 100%;" required>
                  @foreach ($ubicacion as $item)
                    <option value="{{$item->ubiClave}}">{{$item->ubiClave}} - {{$item->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate')) !!}
                  {!! Form::label('depClave', 'Clave del departamento', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate')) !!}
                  {!! Form::label('escClave', 'Clave de la escuela', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                  {!! Form::label('progClave', 'Clave del programa', array('class' => '')); !!}
                </div>
              </div>
            </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left ">keyboard_arrow_down</i> GENERAR EXCEL', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
</div>
</div>
@endsection


@section('footer_scripts')


@endsection