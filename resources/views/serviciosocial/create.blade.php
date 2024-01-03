@extends('layouts.dashboard')

@section('template_title')
	Servicio Social
@endsection

@section('head')
@endsection

@section('breadcrumbs')
	<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
	<a href="{{url('serviciosocial')}}" class="breadcrumb">Lista de Servicio Social</a>
	<label class="breadcrumb">Agregar Serv. Social</label>
@endsection

@section('content')
<div class="row">
	<div class="col s12">
		{!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'serviciosocial.store', 'method' => 'POST']) !!}
		<div class="card">
			<div class="card-content">
				<span class="card-title">AGREGAR SERVICIO SOCIAL</span>
				{{-- NAVIGATION BAR--}}
	            <nav class="nav-extended">
	              <div class="nav-content">
	                <ul class="tabs tabs-transparent">
	                  <li class="tab"><a class="active" href="#general">General</a></li>
	                </ul>
	              </div>
	            </nav>
	        {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','required','min'=>'0')) !!}
                            {!! Form::label('aluClave', 'Clave del Alumno *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','required','maxlength'=>'3')) !!}
                            {!! Form::label('progClave', 'Clave de Programa *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssLugar', NULL, array('id' => 'ssLugar', 'class' => 'validate','required')) !!}
                            {!! Form::label('ssLugar', 'Lugar *', array('class' => '')); !!}
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                	<div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssDireccion', NULL, array('id' => 'ssDireccion', 'class' => 'validate')) !!}
                            {!! Form::label('ssDireccion', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssTelefono', NULL, array('id' => 'ssTelefono', 'class' => 'validate','maxlength' => '10')) !!}
                            {!! Form::label('ssTelefono', 'Telefono', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssJefeSuperior', NULL, array('id' => 'ssJefeSuperior', 'class' => 'validate')) !!}
                            {!! Form::label('ssJefeSuperior', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<p style="text-align:center;">Horarios</p>
                	<br>
                	<div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioLunes', NULL, array('id' => 'ssHorarioLunes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioLunes', 'Lunes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioMartes', NULL, array('id' => 'ssHorarioMartes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioMartes', 'Martes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioMiercoles', NULL, array('id' => 'ssHorarioMiercoles', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioMiercoles', 'Miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioJueves', NULL, array('id' => 'ssHorarioJueves', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioJueves', 'Jueves', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioViernes', NULL, array('id' => 'ssHorarioViernes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioViernes', 'Viernes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioSabado', NULL, array('id' => 'ssHorarioSabado', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioSabado', 'Sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioDomingo', NULL, array('id' => 'ssHorarioDomingo', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioDomingo', 'Domingo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                
                <div class="row">
                	<div class="col s12 m6 l4">
                		<br>
                        {!! Form::label('ssClasificacion', 'Clasificación *', array('class' => '')); !!}
                        <select id="ssClasificacion" class="browser-default validate select2" required name="ssClasificacion" style="width: 100%;">
                        	<option value="" selected disabled>Seleccione una opción</option>
                            @foreach($clasificacion as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class="input-field">
                            {!! Form::text('ssFechaInicio', NULL, array('id' => 'ssFechaInicio', 'class' => 'validate','required')) !!}
                            {!! Form::label('ssFechaInicio', 'Fecha de Inicio', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<p style="text-align:center;">Periodo de Inicio</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssNumeroPeriodoInicio', NULL, array('id' => 'ssNumeroPeriodoInicio', 'class' => 'validate','required','min'=>'0','max'=>'3')) !!}
                            {!! Form::label('ssNumeroPeriodoInicio', 'Número *', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssAnioPeriodoInicio', NULL, array('id' => 'ssAnioPeriodoInicio', 'class' => 'validate','required','min'=>'1997','max'=>$anioActual+1)) !!}
                            {!! Form::label('ssAnioPeriodoInicio', 'Año *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col s12 m6 l4">
                		<br>
                        <div class="input-field">
                            {!! Form::number('ssNumeroAsignacion', NULL, array('id' => 'ssNumeroAsignacion', 'class' => 'validate','min'=>'0','max'=>'99999999')) !!}
                            {!! Form::label('ssNumeroAsignacion', 'Número de asignación ', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class="input-field">
                            {!! Form::text('ssFechaLiberacion', NULL, array('id' => 'ssFechaLiberacion', 'class' => 'validate')) !!}
                            {!! Form::label('ssFechaLiberacion', 'Fecha de Liberación', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<p style="text-align:center;">Periodo de Liberación</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssNumeroPeriodoLiberacion', NULL, array('id' => 'ssNumeroPeriodoLiberacion', 'class' => 'validate','min'=>'0','max'=>'3')) !!}
                            {!! Form::label('ssNumeroPeriodoLiberacion', 'Número *', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssAnioPeriodoLiberacion', NULL, array('id' => 'ssAnioPeriodoLiberacion', 'class' => 'validate','min'=>'1997','max'=>$anioActual+1)) !!}
                            {!! Form::label('ssAnioPeriodoLiberacion', 'Año *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                		<br>
                        {!! Form::label('ssEstadoActual', 'ssEstadoActual *', array('class' => '')); !!}
                        <select id="ssEstadoActual" class="browser-default validate select2" required name="ssEstadoActual" style="width: 100%;">
                        	<option value="" selected disabled>Seleccione una opción</option>
                            @foreach($estadoActual as $key => $value)
                            	<option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class="input-field col s12 m6 14">
                            {!! Form::text('ssFechaReporte1', NULL, array('id' => 'ssFechaReporte1', 'class' => 'validate')) !!}
                            {!! Form::label('ssFechaReporte1', 'Reporte 1', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::text('ssFechaReporte2', NULL, array('id' => 'ssFechaReporte2', 'class' => 'validate')) !!}
                            {!! Form::label('ssFechaReporte2', 'Reporte 2', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class="input-field col s12 m6 14">
                            {!! Form::text('ssFechaReporte3', NULL, array('id' => 'ssFechaReporte3', 'class' => 'validate')) !!}
                            {!! Form::label('ssFechaReporte3', 'Reporte 3', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::text('ssFechaReporte4', NULL, array('id' => 'ssFechaReporte4', 'class' => 'validate')) !!}
                            {!! Form::label('ssFechaReporte4', 'Reporte 4', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
      		{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer_scripts')
@endsection