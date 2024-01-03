@extends('layouts.dashboard')

@section('template_title')
    Notificar
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url("notificar")}}" class="breadcrumb">Notificar</a>
@endsection

@section('content')

{{-- NO SE RECOMIENDA BORRAR ESTE FRAGMENTO COMENTADO. EL CAMBIO QUE SE HIZO DEBAJO DE ÉSTE PUEDE SER TEMPORAL --}}
{{--
<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">Notificar Pagos Realizados</span>
                <div class="row">
                    <div class="col s12 m8 l8">
                        <p>Favor de enviar una foto de su recibo a esta dirección de correo: <b>{{ "pago.transferencia@modelo.edu.mx"}}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
--}}

 <div class="row">
  <div class="col s12 ">
    {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'notificar.enviar', 'method' => 'POST']) !!}
      <div class="card ">
        <div class="card-content ">
            <span class="card-title"><b>Notificar Pagos Realizados</b></span>
            <div class="row">
                <div class="col s12">
                    <p style="color:#0927aa; font-size:20px;"><b>COLEGIATURAS:</b></p>
                    <p>Puede utilizar el siguiente formulario de la pantalla, ó también puede enviarnos el comprobante a esta dirección de correo: <br><b>{{ "pago.transferencia@modelo.edu.mx"}}</b>
                        <u><span style="background-color:#effb04;">(solo se recibirán comprobantes de pagos de colegiaturas en este correo)</span></u></p>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m8 l8">
                    <p style="color:#aa093f; font-size:20px;"><b>EXTRAORDINARIOS:</b></p>
                    <p>Utilice el siguiente formulario de la pantalla, ingresar sus datos y adjuntar su archivo de comprobante de pago.</p>
                </div>
            </div>
          <div class="row">

            <div class="col s12 m6 l4">
              {!! Form::label('reciboPago', 'Recibo de pago *', array('class' => '')); !!}
              <select id="reciboPago" class="browser-default validate select2" required name="reciboPago" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  @if($NOTIFICA_EXTRAORDINARIOS)
                    <option value="EXTRAORDINARIOS">EXTRAORDINARIOS</option>
                  @endif
                    <option value="COLEGIATURAS">COLEGIATURAS</option>
            </select>
          </div>
        </div>
        <div class="row">

          <div class="col s12 m6 l4">
            <div class="input-field">
              {!! Form::email('email', NULL, ['id' => 'email', 'class' => 'validate', 'maxlength' => '60', 'required']) !!}
              {!! Form::label('email', 'Mi correo electrónico *', ['class' => '', ]) !!}
            </div>
          </div>
          <div class="col s12 m6 l4">
            <div class="input-field">
              {!! Form::number('celular', NULL, array('id' => 'celular', 'class' => 'validate','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"', 'required')) !!}
              {!! Form::label('celular', 'Mi número celular *', array('class' => '')); !!}
            </div>
          </div>
        </div>
        <div class="row">

          <div class="col s12 m8 l8">
            <span>REFERENCIA de la ficha generada y pagada</span>
            <div class="input-field">
              {!! Form::textarea('conceptoPago', NULL, array('id' => 'conceptoPago', 'class' => 'validate','required','maxlength'=>'255')) !!}
              {!! Form::label('conceptoPago', 'Folio de Referencia de Ficha de Pago *', array('class' => '')); !!}
            </div>
          </div>

          <div class="col s12 m6 l8">
            <div class="file-field input-field">
              <div class="btn">
                <span>Adjuntar recibo de pago</span>
                <input type="file" name="image">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate"  type="text">
              </div>
            </div>
          </div>

        </div>
        <button type="submit" class="btn btn-success" onclick="mostrarAlerta();">
          <i class=" material-icons left validar-campos">save</i> Enviar notificación de pago
        </button>

        {{--  {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}  --}}
      </div>
    </div>
  {!! Form::close() !!}
</div>
</div>


{{-- NO SE RECOMIENDA BORRAR EL FRAGMENTO COMENTADO. EL CAMBIO QUE SE HIZO A CONTINUACIÓN PUEDE SER TEMPORAL --}}






@endsection



@section('footer_scripts')

<script type="text/javascript">
  $(document).ready(function() {



  })
</script>


<script>
  function mostrarAlerta(){

      $("#submit-button").hide();

      var html = "";
      html += "<div class='preloader-wrapper big active'>"+
          "<div class='spinner-layer spinner-blue-only'>"+
            "<div class='circle-clipper left'>"+
              "<div class='circle'></div>"+
            "</div><div class='gap-patch'>"+
              "<div class='circle'></div>"+
            "</div><div class='circle-clipper right'>"+
              "<div class='circle'></div>"+
            "</div>"+
          "</div>"+
        "</div>";

     

      swal({
          html:true,
          title: "Guardando...",
          text: html,
          showConfirmButton: false
          //confirmButtonText: "Ok",
      })

      

     
  }

</script>
@endsection
