@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Relación de Titulados y Pasantes</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/titulados_pasantes/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Relación de Titulados y Pasantes</span> 
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
              <div class="col s12 m12 l12">
              <p>(Para elegir período de egreso independiente de cuando se titularon)</p>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perNumeroEgreso', NULL, array('id' => 'perNumeroEgreso', 'class' => 'validate','min'=>'0','max'=>'3')) !!}
                  {!! Form::label('perNumeroEgreso', 'Número de periodo de egreso', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perAnioEgreso', NULL, array('id' => 'perAnioEgreso', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year + 1)) !!}
                  {!! Form::label('perAnioEgreso', 'Año de periodo de egreso', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matricula', array('class' => '')); !!}
                </div>
              </div>
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
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','required')) !!}
                  {!! Form::label('ubiClave', 'Clave de campus *', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','required')) !!}
                  {!! Form::label('depClave', 'Clave departamento *', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('planClave', 'Clave de plan', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate')) !!}
                  {!! Form::label('escClave', 'Clave de escuela', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
              </div>
                
            </div>
            <div class="row">
              <div class="col s12 m12 l12">
              <p>(Para elegir período de titulación independiente de cuando egresaron)</p>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perNumeroTitulacion', NULL, array('id' => 'perNumeroTitulacion', 'class' => 'validate','min'=>'0','max'=>'3')) !!}
                  {!! Form::label('perNumeroTitulacion', 'Número de periodo de titulación', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('perAnioTitulacion', NULL, array('id' => 'perAnioTitulacion', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year + 3)) !!}
                  {!! Form::label('perAnioTitulacion', 'Año de periodo de titulación', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('perSexo', 'Sexo', ['class' => '',]); !!}
                <select name="perSexo" id="perSexo" class="browser-default validate" style="width: 100%;">
                  <option value="">Ambos</option>
                  <option value="M">Masculino</option>
                  <option value="F">Femenino</option>
                </select>
              </div>
            </div>
          <div class="row">
            <div class="col s12 m6 l3">
              <br>
              {!! Form::label('egrOpcionTitulo', 'Concepto de Titulación', ['class' => '',]); !!}
              <select name="egrOpcionTitulo" id="egrOpcionTitulo" class="browser-default validate select2" style="width: 100%;">
                <option value="">Todos</option>
                @foreach ($conceptoTitulacion as $item)
              <option value="{{$item->id}}">{{$item->contNombre}}</option>
                @endforeach
              </select>
            </div>
            <div class="col s12 m6 l3">
              <br>
              {!! Form::label('pasantes', '¿Incluir pasantes?', ['class' => '',]); !!}
              <select name="pasantes" id="pasantes" class="browser-default validate select2" style="width: 100%;">
               <option value="si">Si</option>
               <option value="no">No</option>
              </select>
            </div>
            <div class="col s12 m6 l3">
              <div class="input-field">
                {!! Form::label('', 'Fecha Examen Profesional', array('class' => '')); !!}
                <br>
                {!! Form::date('egrFechaExamenProfesional', NULL, array('id' => 'egrFechaExamenProfesional', 'class' => 'validate')) !!}
              </div>
            </div>
            <div class="col s12 m6 l3">
              <div class="input-field">
                {!! Form::label('', 'Fecha Expedición Titulación', array('class' => '')); !!}
                <br>
                {!! Form::date('egrFechaExpedicionTitulo', NULL, array('id' => 'egrFechaExpedicionTitulo', 'class' => 'validate')) !!}
              </div>
            </div>
          </div>
      
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'id' => 'btn-reporte']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function() {
    var perNumeroEgreso = $('#perNumeroEgreso');
    var perAnioEgreso = $('#perAnioEgreso');
    var perNumeroTitulacion = $('#perNumeroTitulacion');
    var perAnioTitulacion = $('#perAnioTitulacion');
    var progClave = $('#progClave');

    $('#btn-reporte').on('click', function () {
      if((perNumeroEgreso.val() && perAnioEgreso.val()) || (perNumeroTitulacion.val() && perAnioTitulacion.val()) || progClave.val()) {
        $('form').submit();
      }else {
        show_validation_message();
      }
    });

  });



  function show_validation_message() {
    swal({
      type: 'warning',
      title: 'Parámetros requeridos',
      text: 'Necesita especificar al menos un periodo (Egreso o Titulación). \n \n '+
      'Si no especifica ningun periodo, debe especificar una Clave de programa'
    });
  }

</script>
@endsection