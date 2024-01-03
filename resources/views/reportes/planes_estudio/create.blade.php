@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación planes estudio</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/planes_estudio/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación planes estudio</span>
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
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate', 'required')) !!}
                  {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate', 'required')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('planClave', NULL, array('id' => 'planClave', 'class' => 'validate')) !!}
                  {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('acuNumero', NULL, array('id' => 'acuNumero', 'class' => 'validate', "")) !!}
                  {!! Form::label('acuNumero', 'Número acuerdo plan', array('class' => '')); !!}
                </div>
              </div>

              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::label('acuFecha', 'Fecha acuerdo plan', ['class' => '', 'style' => 'margin-top: -16px;']); !!}
                  <input id="acuFecha" name="acuFecha" class="validate" type="date" value="">
                </div>
              </div>

              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('numMaterias', NULL,  array('id' => 'numMaterias', 'class' => 'validate', 'min'=>'0')) !!}
                  {!! Form::label('numMaterias', 'Número de materias', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('planPeriodos', NULL,  array('id' => 'planPeriodos', 'class' => 'validate', 'min'=>'0')) !!}
                  {!! Form::label('planPeriodos', 'Número de períodos', array('class' => '')); !!}
                </div>
              </div>


                
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('acuEstadoPlan', 'Estado del plan', ['class' => '']); !!}
                <select name="acuEstadoPlan" id="acuEstadoPlan" class="browser-default validate select2" style="width: 100%;">
                  <option value="">Seleccionar</option>
                  @foreach ($estadosAcuerdoPlan as $key => $val)
                    <option value="{{$key}}">{{$val}}</option>
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