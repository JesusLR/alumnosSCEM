@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Programación de exámenes extraordinarios</a>
@endsection

@section('content')
<style>

</style>
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/programacion_examenes/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Programación de exámenes extraordinarios</span>
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
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('inscritos', 'Incluir alumnos inscritos', ['class' => '']); !!}
                <select name="inscritos" id="inscritos" class="browser-default validate select2" style="width: 100%;">
                  <option value="si">Sí</option>
                  <option value="no">No</option>
                  <option value="t">Ambos</option>
                </select>
              </div>
              <div class="col s12 m6 l4" style="margin-top:10px;">
                {!! Form::label('regular', 'Solicitudes de regularización', ['class' => '']); !!}
                <select name="regular" id="regular" class="browser-default validate select2" style="width: 100%;">
                  <option value="t">Todas</option>
                  <option value="p">Pagadas</option>
                  <option value="n">No pagadas</option>
                </select>
              </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', 'required')) !!}
                      {!! Form::label('perNumero', 'Número de periodo*', array('class' => '')); !!}
                    </div>
                  </div>
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'1997','max'=>$anioActual->year+1, 'required')) !!}
                      {!! Form::label('perAnio', 'Año de periodo*', array('class' => '')); !!}
                    </div>
                  </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate', 'required')) !!}
                  {!! Form::label('ubiClave', 'Clave de campus*', array('class' => '')); !!}
                </div>
              </div>
              
              
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('examenId', NULL, array('id' => 'examenId', 'class' => 'validate')) !!}
                    {!! Form::label('examenId', 'Clave del examen', array('class' => '')); !!}
                  </div>
                </div>
              <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate', 'required')) !!}
                    {!! Form::label('depClave', 'Clave departamento*', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                    {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('planClave', NULL, array('id' => 'planClave', 'class' => 'validate', "")) !!}
                  {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::number('matClave', NULL, array('id' => 'matClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('extGrupo', NULL, array('id' => 'extGrupo', 'class' => 'validate')) !!}
                  {!! Form::label('extGrupo', 'Clave del grupo', array('class' => '')); !!}
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate')) !!}
                  {!! Form::label('escClave', 'Clave de la escuela', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('extFecha', NULL, array('id' => 'extFecha', 'class' => 'validate', "")) !!}
                    {!! Form::label('extFecha', 'Fecha en formato AAAA-MM-DD. Ej: 1999-12-24 ', array('class' => '')); !!}
                  </div>
                </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('extHora', NULL, array('id' => 'extHora', 'class' => 'validate')) !!}
                  {!! Form::label('extHora', 'Hora en formato HH:mm:ss Ej: 19:00:00 ', array('class' => '')); !!}
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('aulaClave', NULL, array('id' => 'aulaClave', 'class' => 'validate')) !!}
                  {!! Form::label('aulaClave', 'Lugar del examen', array('class' => '')); !!}
                </div>
              </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::number('empleado_sinodal_id', NULL, array('id' => 'empleado_sinodal_id', 'class' => 'validate')) !!}
                      {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
                    </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                        {!! Form::text('extPago', NULL, array('id' => 'extHora', 'class' => 'validate')) !!}
                        {!! Form::label('extPago', 'Costo del examen', array('class' => '')); !!}
                      </div>
                    </div>
              
            </div>

        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
@endsection