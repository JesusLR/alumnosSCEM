@extends('layouts.dashboard')

@section('template_title')
    Municipio
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('municipios')}}" class="breadcrumb">Lista de municipios</a>
    <label class="breadcrumb">Ver Municipio</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">MUNICIPIO #{{$municipio->municipio_id}}</span>

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
                <div class="row">
                  <div class="col s12 m6 l6" style="margin-top:10px;">
                    {!! Form::label('estado', 'Estado'); !!}
                    <select name="estado_id" id="estado_id" class="browser-default validate select2" disabled style="width: 100%;">
                      <option value="" disabled>Seleccionar Estado</option>
                      @foreach ($estado as $item)
                      <option value="{{$item->id}}" {{ $municipio->estado_id == $item->id ? 'selected="selected"' : '' }}>{{$item->edoNombre}}</option>
                      @endforeach
                    </select>
                  </div>
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('munNombre', $municipio->munNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('munNombre', 'Nombre del Municipio', array('class' => '')); !!}
                        </div>
                    </div>
                    
                </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection
