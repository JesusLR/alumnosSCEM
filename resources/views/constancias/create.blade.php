@extends('layouts.dashboard')

@section('template_title')
    Constancias
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Constancias</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'constancias/solicitar', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content">

            <!-- <div class="row">
              <div class="col s12 m12 l12">
                <span class="card-title">CONSTANCIAS</span>
              </div>
            </div> -->

            <div class="row">
              <div class="col s12 m6 l4">
                  <span class="card-title">CONSTANCIAS</span>
                  {!! Form::label('tipo_constancia', 'Constancia *', array('class' => '')); !!}
                  <select id="tipo_constancia" class="browser-default validate select2" required name="tipo_constancia" style="width: 100%;">
                      <option value="Buena conducta">Buena conducta</option>
                      <option value="Calificaciones finales">Calificaciones finales</option>
                      <option value="Calificaciones completa">Calificaciones completa</option>
                      <option value="Calificaciones parciales">Calificaciones parciales</option>
                      <option value="Inscripción">Inscripción</option>
                      <option value="Solicitud de beca">Solicitud de beca</option>
                      <option value="8">Otro</option>
                  </select>
              </div>
              <!-- <div class="col s12 m6 l6" style="font-size: 18px">
              Estimado(a) alumno(a) a partir de 24 hrs. 
            de la solicitud, podrá pasar por su 
            constancia a la Dirección de Control 
            Escolar (Secretaría Administrativa)
            en el caso de que la constancia que 
            requiere no se encuentre en las opciones 
            o tiene alguna duda, mandar un correo 
            especificando el requerimiento a: 
            constancias@modelo.edu.mx <br>
            Dirección de Control Escolar <br>
            Tel.: 9999301900 ext. 1130-1134
              </div> -->
              <div class="col s12 m6 l6" style="font-size: 18px">
                <h3 class="center-align" style="margin-top:0;">AVISO</h3>
                <p style="margin-bottom:15px;">
                  A partir del 1 de septiembre 2023, Las constancias tendrán un costo de:  $ 50.00 (cincuenta pesos 00/100, m.n.), después de hacer la solicitud en el portal deberán de acudir a efectuar el pago a la Dirección de Control Escolar (Secretaría Administrativa) y pasar por ella en 24 horas posterior al pago.
                </p>
                <p style="margin-bottom:15px;">
                  En el caso de que la constancia que requiere no se encuentre en las opciones o tiene alguna duda, mandar un correo especificando el requerimiento a: constancias@modelo.edu.mx
                </p>
                <p style="margin-bottom:15px;">
                  Para el caso de no poder pasar a recibir personalmente su constancia, lo podrá hacer a través de cualquier persona, mediante carta poder, en la que consten ambas firmas, incluyendo copias fotostáticas de sus identificaciones (INE, licencia de conducir o pasaporte).
                </p>
                <p style="margin-bottom:15px;">
                  Dirección de Control Escolar
                </p>
                <p style="margin-bottom:15px;">
                  Tel.: 9999301900 ext. 1130-1134
                </p>
              </div>
              <div id="tipo_constancia_div" class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::textarea('comentarios', NULL,
                      ['id' => 'comentarios', 'class' => 'browser-default','rows' => 2, 'cols' => 40,'data-length' => "100"]) !!}
                  {!! Form::label('comentarios', 'Especifique la constancia que deseas solicitar', ['class' => '']); !!}
                </div>
              </div>
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">picture_as_pdf</i> SOLICITAR', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
    {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')
<script>
  $(document).ready(function(){
    let tipo = $('#tipo_constancia');
    tipo.val() == '8' ? $('#tipo_constancia_div').show() : $('#tipo_constancia_div').hide();
    
    tipo.on('change', function() {
      this.value == '8' ? $('#tipo_constancia_div').show() : $('#tipo_constancia_div').hide();
      this.value == '8' ? $('#comentarios').prop('required', true) : $('#comentarios').prop('required', false);
    });
  });
</script>
@endsection