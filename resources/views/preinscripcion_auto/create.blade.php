@extends('layouts.dashboard')

@section('template_title')
	Preinscripción Automática
@endsection

@section('breadcrumbs')
	<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
	<a href="" class="breadcrumb">Preinscripción Automática</a>
@endsection

@section('content')
 <div class="row">
 	<div class="col s12">
 		{!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'preinscripcion_auto/preinscribir', 'method' => 'POST', 'target' => '_blank']) !!}
 		 	<div class="row">
              <div class="col s12 m6 l4">
                <p style="text-align:center;">Periodo</p>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número *', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year+1, "required")) !!}
                  {!! Form::label('perAnio', 'Año *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <br>
                <br>
                {!! Form::label('depClave', 'Seleccione la clave de departamento', ['class' => '']); !!}
                <select name="depClave" id="aluEstado" class="browser-default validate select2" style="width: 100%;">
                  @foreach($depClave as $key => $value)
                    <option value="{{$key}}" @if(old('depClave') == $key) {{ 'selected' }} @endif>{{$value}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('escClave','Clave de Escuela', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('progClave','Clave de programa', array('class' => '')); !!}
                </div>
              </div>
            </div>
 		 <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> Realizar Preinscripción', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
         </div>
 		{!! Form::close() !!}
 	</div>
 </div>

@endsection