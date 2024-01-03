@extends('layouts.dashboard')

@section('template_title')
    Prefecteo
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Aulas Ocupadas por Escuelas</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'aulas/ocupadas/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CONSTANCIA DE SOLICITUD DE BECA</span>

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
                    <div class="col s12 m4 14" style="margin-top:10px;">
                        <p style="text-align:center;">Rango de horas para prefecteo</p>
                      <div class="input-field col s12 m6 14">
                        <select name="horas1" id="horas1" class="browser-default validate select2" style="width: 100%;" required>
                          <option value="">Seleccionar hora</option>
                          @foreach ($horas as $key => $item)
                          <option value="{{$key}}">{{$item}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="input-field col s12 m6 14">
                          {!! Form::label('horas2', 'Hora Final', ['class' => '']); !!}
                        <select name="horas2" id="horas2" class="browser-default validate select2" style="width: 100%;" required>
                          <option value="">Seleccionar hora</option>
                        </select>
                      </div>
                    </div>
                    <div class="col s12 m4 14">
                      <br>
                      <div class="input-field">
                        <select name="depClave" id="depClave" class="browser-default validate select2" style="width: 100%;" required>
                          <option value="">Seleccionar Departamento</option>
                          @foreach ($departamentos as $key => $depto)
                          <option value="{{$key}}">{{$depto}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col s12 m4 14">
                      <div class="input-field">
                        <p style="text-align:center;">Fecha de revisión</p>
                        {!! Form::date('fecharev', $fechaActual, array('id' => 'fecharev', 'class' => 'validate', 'required')) !!}
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col s12 m6 l4">
                        <p style="text-align:center;">Periodo</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', 'required')) !!}
                            {!! Form::label('perNumero', 'Número', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0','max'=>$fechaActual->year, 'required')) !!}
                            {!! Form::label('perAnio', 'Año', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                      <br>
                        <div class="input-field">
                            {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','required')) !!}
                            {!! Form::label('ubiClave', 'Clave de ubicación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate')) !!}
                            {!! Form::label('escClave', 'Clave de Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                            {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
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

  <div class="preloader">
      <div id=""></div>
  </div>

@endsection


@section('footer_scripts')


<script type="text/javascript">
    $(document).ready(function() {

      $('#horas1').on('change',function(){
        var hora1 = parseInt($(this).val());
        var horas = {!! json_encode($horas) !!};
        console.log(horas)

        if(hora1){
          var horas2 = [];
          $.each(horas,function(key,value){
            if(key >= hora1){
              horas2[key] = value;
            }
          });

          console.log(horas2);

          $('#horas2').empty();
          horas2.forEach(function(key,value){
            $('#horas2').append('<option value="'+ value +'">'+ key +'</option>');
          });
        }else{
          $('#horas2').empty();
        }

      });
    });
</script>
@endsection