@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Certificado completo</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/certificado_completo/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CERTIFICADO COMPLETO</span>

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
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                      {!! Form::label('ubiClave', 'Clave de campus', array('class' => '')); !!}
                    </div>
                  </div>
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0', "required")) !!}
                      {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                    </div>
                  </div>
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0', "required")) !!}
                      {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                    </div>
                  </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('fechaEmision', 'Fecha de emision', array('class' => '')); !!}
                    {!! Form::date('fechaEmision', \Carbon\Carbon::now(), array('id' => 'fechaEmision', 'class' => 'validate', 'required')) !!}
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
@endsection