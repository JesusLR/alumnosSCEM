@extends('layouts.dashboard')

@section('template_title')
    Municipios
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('municipios')}}" class="breadcrumb">Lista de municipios</a>
    <label class="breadcrumb">Editar Municipio</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['municipios.update', $municipio->municipio_id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR MUNICIPIO #{{$municipio->municipio_id}}</span>

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
                      <select name="estado_id" id="estado_id" class="browser-default validate select2" required style="width: 100%;">
                        <option value="" disabled>Seleccionar Estado</option>
                        @foreach ($estado as $item)
                        <option value="{{$item->id}}" {{ $municipio->estado_id == $item->id ? 'selected="selected"' : '' }}>{{$item->edoNombre}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('munNombre', $municipio->munNombre, array('id' => 'munNombre', 'class' => 'validate','required','maxlenght'=>'50')) !!}
                            {!! Form::label('munNombre', 'Nombre del Municipio*', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

@include('scripts.departamentos')
@include('scripts.escuelas')

@endsection