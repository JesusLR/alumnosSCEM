@extends('layouts.dashboard')

@section('template_title')
    Cuenta
@endsection

@section('head')

@endsection


@section('breadcrumbs')
    <div class="col s12">
        <p style="color: #000; margin-left: 10px;">

        </p>
    </div>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    @php
                        $aluClave = Auth::user()->username;
                        $alumno = DB::select("SELECT personas.* FROM alumnos
                        INNER JOIN personas on personas.id = alumnos.persona_id
                        WHERE alumnos.aluClave=$aluClave")
                    @endphp
                    USUARIO
                    {{ $alumno[0]->perNombre }}
                    {{ $alumno[0]->perApellido1 }}
                    {{ $alumno[0]->perApellido2 }}
                </span>
        
                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#cambiarPassword">Cambiar Contraseña</a></li>
                        </ul>
                    </div>
                </nav>

                
                {{-- cambiarPassword BAR--}}
                <div id="cambiarPassword">
                    <div class="row">
                        {{ Form::open(['method'=>'POST','route' => ['cambiarPassword.store']]) }}

                            <div class="col s12 m6 l4">
                                <div class="input-field">
                                    <input class="validate" type="password" id="antiguoPassword" name="antiguoPassword" maxlength="255" />
                                    {!! Form::label('antiguoPassword', 'Contraseña Actual', ['class' => '']); !!}
                                </div>


                                <div class="input-field">
                                    <input class="validate" type="password" id="nuevo_password" name="nuevo_password" maxlength="20" />
                                    {!! Form::label('nuevo_password', 'Nueva Contraseña', ['class' => '']); !!}
                                </div>


                                <div class="input-field">
                                    {{--  <input type="password" name="confirmPassword" id="confirmPassword" maxlength="20" class="validate">  --}}
                                    <input class="input-100" type="password" id="nuevo_confirmPassword" name="nuevo_confirmPassword" maxlength="20"  />
                                    {!! Form::label('nuevo_confirmPassword', 'Confirmar nueva Contraseña', ['class' => '']); !!}
                                </div>
                               
                                <small>
                                    <input type="checkbox" id="ver" class="ver" onChange="hideOrShowPassword()" />
                                    <label for="ver" class="text">Mostrar contraseña</label>
                                </small>

                                <br><br>
                                {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                            </div>

                        {!! Form::close() !!}

                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('footer_scripts')
<script>
    function hideOrShowPassword(){

      
        var antiguoPassword=document.getElementById("antiguoPassword");
        var nuevo_password=document.getElementById("nuevo_password");
        var nuevo_confirmPassword=document.getElementById("nuevo_confirmPassword");

        var check=document.getElementById("ver");
      
        if(check.checked==true) // Si la checkbox de mostrar contraseña está activada
        {
            antiguoPassword.type = "text";
            nuevo_password.type = "text";
            nuevo_confirmPassword.type = "text";
        }
        else // Si no está activada
        {
            antiguoPassword.type = "password";
            nuevo_password.type = "password";
            nuevo_confirmPassword.type = "password";
        }
      }
</script
@endsection