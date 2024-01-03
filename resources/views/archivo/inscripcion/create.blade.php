@extends('layouts.dashboard')

@section('template_title')
    Archivos SEP
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('archivo/inscripcion')}}" class="breadcrumb">Generar archivo inscripción</a>
@endsection

@section('content')


<div class="row">
	<div class="col s12 ">
		{!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'archivo/inscripcion/descargar', 'method' => 'POST']) !!}
			<div class="card ">
				<div class="card-content">
					<span class="card-title">GENERAR ARCHIVO INSCRIPCIONES</span>

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
								{!! Form::label('ubicacion_id', 'Ubicación', array('class' => '')); !!}
								<select id="ubicacion_id" class="browser-default validate select2" name="ubicacion_id" style="width: 100%;">
									<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
									@foreach($ubicaciones as $ubicacion)
										<option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
									@endforeach
								</select>
							</div>
							<div class="col s12 m6 l4">
								{!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
								<select id="departamento_id" class="browser-default validate select2" name="departamento_id" style="width: 100%;">
									<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
								</select>
							</div>
							<div class="col s12 m6 l4">
								{!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
								<select id="periodo_id" class="browser-default validate select2" name="periodo_id" style="width: 100%;">
									<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col s12 m6 l4">
								{!! Form::label('ubicacion_id', 'Tipo ingreso', array('class' => '')); !!}
								<select id="ubicacion_id" class="browser-default validate select2" name="tipo_ingreso" style="width: 100%;">
										<option value="PI" selected>PREINSCRIPCION</option>
										<option value="RI">REINSCRIPCION</option>
								</select>
							</div>
						</div>
					</div>



				</div>
				<div class="card-action">
					{!! Form::button('<i class="material-icons left">note_add</i> GENERAR ARCHIVOS', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection


@section('footer_scripts')


@include('scripts.departamentos')
@include('scripts.escuelas')
@include('scripts.programas')
<script type="text/javascript">

	$(document).ready(function() {
		// OBTENER PLANES
		$("#programa_id").change( event => {
			$("#plan_id").empty();
	
			$("#cgt_id").empty();
			$("#materia_id").empty();
			$("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
			$("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
			$("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
				
			$.get(base_url+`/api/planes/${event.target.value}`,function(res,sta){
				//seleccionar el post preservado
				var planSeleccionadoOld = $("#plan_id").data("plan-idold")
				$("#plan_id").empty()
				$("#plan_id").append(`<option value="" selected>SELECCIONE UNA OPCIÓN</option>`);
				
				res.forEach(element => {
					var selected = "";
					if (element.id === planSeleccionadoOld) {
							console.log("entra")
							console.log(element.id)
							selected = "selected";
					}


					$("#plan_id").append(`<option value=${element.id} ${selected}>${element.planClave}</option>`);
				});

				$('#plan_id').trigger('change'); // Notify only Select2 of changes
			});
		});
	});
</script>
@include('scripts.periodos')
@include('scripts.semestres')


@endsection