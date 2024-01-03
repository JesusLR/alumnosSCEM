@extends('layouts.dashboard')

@section('template_title')
    Preparatorias
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preparatorias')}}" class="breadcrumb">Lista de preparatorias</a>
    <label class="breadcrumb">Ver Preparatoria</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">PREPARATORIA #{{$preparatoria->preparatoria_id}}</span>

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
                    {!! Form::label('municipio', 'Municipio'); !!}
                    <select name="municipio_id" id="municipio_id" class="browser-default validate select2" required style="width: 100%;">
                      <option value="" disabled>Seleccionar Municipio</option>
                      @foreach ($municipio as $item)
                      <option value="{{$item->id}}" {{ $preparatoria->municipio_id == $item->id ? 'selected="selected"' : '' }}>{{$item->munNombre}}</option>
                      @endforeach
                    </select>
                  </div>
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('prepNombre', $preparatoria->prepNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('prepNombre', 'Nombre de la Preparatoria', array('class' => '')); !!}
                        </div>
                    </div>
                    
                </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection
