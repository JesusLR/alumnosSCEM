@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Mejores promedios</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/mejores_promedios/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Mejores promedios</span>
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
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número de periodo*', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                  {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4" style="margin-top:10px;">
                  {!! Form::label('numeroAlumnos', 'Mejores promedios', ['class' => '']); !!}
                  <select name="numeroAlumnos" id="numeroAlumnos" class="browser-default validate select2" style="width: 100%;">
                    <option value="10">10 Alumnos</option>
                    <option value="15">15 Alumnos</option>
                    <option value="20">20 Alumnos</option>
                    {{-- <option value="parc_1">Parcial 1</option>
                    <option value="parc_2">Parcial 2</option>
                    <option value="parc_3">Parcial 3</option>
                    <option value="ordinario">Ordinario</option>
                    <option value="final">Final</option> --}}
                  </select>
                </div>
              {{-- <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('tipoIngre', 'Tipo Ingre (Segey)', ['class' => '']); !!}
                <select name="tipoIngre" id="tipoIngre" class="browser-default validate select2" style="width: 100%;">
                  <option value="">Ninguno</option>
                  <option value="PI">PI</option>
                  <option value="NI">NI</option>
                  <option value="RE">RE</option>
                  <option value="RI">RI</option>
                  <option value="RO">RO</option>
                </select>
              </div> --}}
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('numeroDecimales', 'Número de decimales en los promedios', ['class' => '']); !!}
                <select name="numeroDecimales" id="numeroDecimales" class="browser-default validate select2" style="width: 100%;">
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('ubiClave', 'Clave de campus*', array('class' => '')); !!}
                </div>
              </div>
              {{-- <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                </div>
              </div> --}}
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('progClave', 'Clave de programa*', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('planClave', 'Clave del plan*', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <div class="row">
              {{-- <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                </div>
              </div> --}}
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('cgtGradoSemestre', 'Grado o Semestre', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
                </div>
              </div>
              {{-- <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matricula alumno', array('class' => '')); !!}
                </div>
              </div> --}}
              
            </div>

            {{-- <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
                </div>
              </div>
            </div> --}}
            {{-- <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field col s12 m6 l6">
                    {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                    {!! Form::label('perNumero', 'Número de periodo*', array('class' => '')); !!}
                  </div>
                  <div class="input-field col s12 m6 l6">
                    {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                    {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year, "required")) !!}
                    {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
                  </div>
                </div>
              </div> --}}
           
            {{-- <div class="row">
              <div class="col s12 m6 l6">
                <p style="margin-bottom: -15px;">Poner clave de materia si quiere incluir una materia específica.</p>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                  {!! Form::label('matClave', 'Clave de materia', ['class' => '']); !!}

                </div>
              </div>
            </div> --}}
          
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
  @include('scripts.grupo-semestre')
@endsection