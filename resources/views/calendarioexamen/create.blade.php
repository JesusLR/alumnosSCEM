@extends('layouts.dashboard')

@section('template_title')
    Calendario de  Examen
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('calendarioexamen')}}" class="breadcrumb">Lista de Calendarios de Exámenes</a>
    <a href="{{url('calendarioexamen/create')}}" class="breadcrumb">Agregar Calendario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'calendarioexamen.store', 'method' => 'POST']) !!}
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR CALENDARIO</span>

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
                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                @endphp

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @if($ubicacion->id == $ubicacion_id)
                                    <option value="{{$ubicacion->id}}" selected>{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>;
                                @else
                                    <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>;
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">Semestre</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('perFechaInicial', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" name="perFechaInicial" id="perFechaInicial" readonly>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('perFechaFinal', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" name="perFechaFinal" id="perFechaFinal" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">1er. Parcial</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioParcial1', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" name="calexInicioParcial1" id="calexInicioParcial1">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial1', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" name="calexFinParcial1" id="calexFinParcial1">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">2do. Parcial</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioParcial2', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" name="calexInicioParcial2" id="calexInicioParcial2">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial2', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" name="calexFinParcial2" id="calexFinParcial2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">3er. Parcial</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioParcial3', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" name="calexInicioParcial3" id="calexInicioParcial3">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial3', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" name="calexFinParcial3" id="calexFinParcial3">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">Ordinario</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioOrdinario', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" name="calexInicioOrdinario" id="calexInicioOrdinario">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinOrdinario', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" name="calexFinOrdinario" id="calexFinOrdinario">
                        </div>
                    </div>
                </div>
                
            </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', [ 'id'=>'btn-guardar','class' => 'btn-large waves-effect  darken-3']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}


@endsection

@section('footer_scripts')

<script type="text/javascript">
    $(document).ready(function() {
        var perFechaInicial = null;
        var perFechaFinal = null;

        var ubicacion_id = $('#ubicacion_id').val();
        getDepartamentos(ubicacion_id, 'departamento_id');

        $('#ubicacion_id').on('change', function() {
            var ubicacion_id = $(this).val();
            ubicacion_id ? getDepartamentos(ubicacion_id, 'departamento_id') : resetSelect('departamento_id');
        });

        $('#departamento_id').on('change', function() {
            var departamento_id = $(this).val();
            departamento_id ? getPeriodos(departamento_id, 'periodo_id') : resetSelect('periodo_id');
        });

        $('#periodo_id').on('change', function() {
            var periodo_id = $(this).val();
            periodo_id && periodo_fechasInicioFin(periodo_id);
        });

  

        $('form').on('click', '#btn-guardar', function() {
            $('form').submit();
        });


    });

    


</script>

@endsection