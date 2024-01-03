@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de Egresados</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/res_egresados/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de Egresados</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>


            <hr>
            <div class="row">
              <div class="col s12 m6 l4">
                <br>
                {!! Form::label('tipoReporte', 'Tipo de Reporte', array('class' => '')); !!}
                <select id="tipoReporte" name="tipoReporte" class="browser-default validate select2" style="width:100%" required>
                  <option value="P">Por periodo</option>
                  <option value="C">Por carrera</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                <p style="text-align:center;">Periodo de Egreso</p>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número *', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                  {!! Form::label('perAnio', 'Año *', array('class' => '')); !!}
                </div>
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
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('depClave', 'Clave de departamento ', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('progClave','Clave de programa', array('class' => '')); !!}
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
<script type="text/javascript">
  $(document).ready(function() {

    $('#tipoReporte').on('change', function() {
      if($(this).val() == 'C') {
        $('#perNumero').val('').prop('required', false).prop('disabled', true);
        $('#perAnio').val('').prop('required', false).prop('disabled', true);
        Materialize.updateTextFields();
      } else {
        $('#perNumero').val('').removeAttr('disabled').prop('required', true);
        $('#perAnio').val('').removeAttr('disabled').prop('required', true);
      }
    });

  });
</script>
@endsection