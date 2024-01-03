@extends('layouts.dashboard')

@section('template_title')
    Registro de Egresados
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Registro de Egresados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'registro_egresados/procesar', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">REGISTRO DE EGRESADOS</span>
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
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','maxlength'=>'3', "required")) !!}
                  {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'1','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0','max'=>$anioActual->year, "required")) !!}
                  {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                </div>
              </div>
              
            </div>



            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('escClave', 'Clave de Escuela', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                   {!! Form::text('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                   {!! Form::label('planClave', 'Clave de Plan', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              <p style="text-align: center;font-size:1.2em;">Alumno</p>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m4 14">
                <div class="input-field">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matrícula', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido1', 'Apellido Paterno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido2', 'Apellido Materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                  {!! Form::label('perNombre', 'Nombre', array('class' => '')); !!}
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">school</i> REGISTRAR', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection


@section('footer_scripts')

<script type="text/javascript">
  $(document).ready(function(){
    $('#aluClave').blur(function(){
      var aluClave = $(this).val();
      if(aluClave){
        $.ajax({
          processing : 'true',
          serverSide : 'true',
          url : 'registro_egresados/buscar/' + aluClave,
          method : 'POST',
          data : {aluClave : aluClave,"_token":"{{csrf_token()}}"},
          dataType : "json",
          success : function(data){
            console.log(data);
            $('#ubiClave').val(data.ubiClave);
            Materialize.updateTextFields();
            $('#perNumero').val(data['perNumero']);
            Materialize.updateTextFields();
            $('#perAnio').val(data['perAnio']);
            Materialize.updateTextFields();
            $('#depClave').val(data['depClave']);
            Materialize.updateTextFields();
            $('#escClave').val(data['escClave']);
            Materialize.updateTextFields();
            $('#progClave').val(data['progClave']);
            Materialize.updateTextFields();
            $('#planClave').val(data['planClave']);
            Materialize.updateTextFields();
            $('#aluMatricula').val(data['aluMatricula']);
            Materialize.updateTextFields();
            $('#perApellido1').val(data['perApellido1']);
            Materialize.updateTextFields();
            $('#perApellido2').val(data['perApellido2']);
            Materialize.updateTextFields();
            $('#perNombre').val(data['perNombre']);
            Materialize.updateTextFields();
          }
        });
      }
    });
  });
</script>

@endsection