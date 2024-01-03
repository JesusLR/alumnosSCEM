@extends('layouts.dashboard')

@section('template_title')
    Cambiar contraseña de docentes
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('cambiar_contrasena')}}" class="breadcrumb">Lista Docentes</a>
    <a href="{{url('cambiar_contrasena/'.$docente->id.'/edit')}}" class="breadcrumb">Editar Contraseña</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['cambiar_contrasena.update', $docente->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR Docente clave #{{$docente->empleado->id}}</span>

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
                @php
                    $persona = $docente->empleado->persona;
                @endphp
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('perNombre', 'Nombre', array('class'=>'')) !!}
                        <input type="text" name="perNombre" id="perNombre" value="{{$persona->perNombre}}" maxlength="100" class="validate" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('perApellido1', 'Apellido paterno', array('class'=>'')) !!}
                        <input type="text" name="perApellido1" id="perApellido1" value="{{$persona->perApellido1}}" maxlength="200" class="validate" readonly>
                    </div>
                    @if($persona->perApellido2)
                        <div class="col s12 m6 l4">
                            {!! Form::label('perApellido2', 'Apellido materno', array('class'=>'')) !!}
                            <input type="text" name="perApellido2" id="perApellido2" value="{{$persona->perApellido2}}" maxlength="200" class="validate" readonly>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="perCorreo1">Correo</label>
                        <input type="text" name="perCorreo1" id="perCorreo1" value="{{$persona->perCorreo1}}" class="validate" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="validate noUpperCase"> 
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="confirmPassword">Confirmar contraseña</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" class="validate noUpperCase">
                    </div>
                </div>
                
            </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>


@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        console.log('Hola Mundo');
    });
</script>
@endsection