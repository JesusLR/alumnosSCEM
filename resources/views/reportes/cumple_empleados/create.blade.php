@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Cumpleaños de empleados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/cumple_empleados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Cumpleaños de empleados</span>
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
              <!--
              <div class="col s12 m6 l4">
                {!! Form::label('ordernarPor', 'Seleccionar Orden', ['class' => '']); !!}
                <select name="ordernarPor" id="ordernarPor" class="browser-default validate select2" style="width: 100%;">
                  <option value="nombre">NOMBRE</option>
                  <option value="grado">GRADO</option>
                </select>
              </div>
            -->
              </div>
              <!--
              <div class="col s12 m6 l4">
                {!! Form::label('tipoEspacio', 'Seleccionar espaciado', ['class' => '']); !!}
                <select name="tipoEspacio" id="tipoEspacio" class="browser-default validate select2" style="width: 100%;">
                  <option value="sencillo">SENCILLO</option>
                  <option value="doble">DOBLE</option>
                </select>
              </div>
          -->
            </div>


            <hr>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('empEstado', 'Seleccione empleados a incluir en el reporte', ['class' => '']); !!}
                <select name="empEstado" id="empEstado" class="browser-default validate select2" style="width: 100%;">
                  @foreach($empEstado as $key => $value)
                    <option value="{{$key}}" @if(old('empEstado') == $key) {{ 'selected' }} @endif>{{$value}}</option>
                  @endforeach
                </select>
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
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('depClave', 'Clave de departamento', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('escClave','Clave de Escuela', array('class' => '')); !!}
                </div> 
              </div>
            </div>
            <div class="row">
               <div class="col s12 m6 l4">
                {!! Form::label('mesCumple', 'Seleccione el mes de Cumpleaños', ['class' => '']); !!}
                <select name="mesCumple" id="empEstado" class="browser-default validate select2" style="width: 100%;">
                  @foreach($mesCumple as $key => $value)
                    <option value="{{$key}}" @if(old('mesCumple') == $key) {{ 'selected' }} @endif>{{$value}}</option>
                  @endforeach
                </select>
              </div>
               <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('NoEmpleado', NULL, array('id' => 'NoEmpleado', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('NoEmpleado','No. Empleado', array('class' => '')); !!}
                </div> 
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido1', 'Apellido Paterno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido2', 'Apellido Materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perNombre', 'Nombre', array('class' => '')); !!}
                </div>
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