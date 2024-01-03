@extends('layouts.dashboard')

@section('template_title')
    Encuesta
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Encuesta</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12">
        <div class="card ">
          <div class="card-content ">
                @if($encuesta)
                  <div class="row">
                    <div class="col s12 m6 l12">
                      <p><b>Click en el botón para ir a la página de la encuesta. Al concluir la misma, ingresa en el campo el código proporcionado.</b></p>
                      <a href="{{ $encuesta->encUrl }}" class="btn-large waves-effect  darken-3" type="button" target="_blank">Encuesta
                          <i class="material-icons left">library_books</i>
                      </a>
                    </div>
                    <div class="col s12 m6 l4">
                      <form method="POST" action="{{url('encuesta/verificar_codigo')}}" target="_blank">
                        @method('POST')
                        @csrf
                        <div class="input-field">
                          <input type="number" name="codigo" id="codigo" class="validate" required>
                          <label for="codigo">Ingresa el código</label>
                        </div>
                        <button type="submit" class="btn-large waves-effect  darken-3">Verificar código</button>
                      </form>
                    </div>
                  </div>
                @else
                  <div class="row">
                    <div class="col s12 m6 l12">
                      <p><b>No se encuentra tu encuesta. Favor de vrificar con tu dirección</b></p>
                    </div>
                  </div>
                @endif

          </div>

        </div>
    </div>
  </div>

@endsection



