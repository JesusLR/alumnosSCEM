@extends('layouts.dashboard')

@section('template_title')
    Cuota
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('pagos/registro_cuotas')}}" class="breadcrumb">Lista de cuotas</a>
    <label class="breadcrumb">Editar cuota</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'registroCuotas.update', 'method' => 'POST']) !!}
        <input type="hidden" value="{{$cuota->id}}" id="cuota_id" name="cuota_id">
        <input type="hidden" value="{{$cuota->dep_esc_prog_id}}" id="dep_esc_prog_id" name="dep_esc_prog_id">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR CUOTA</span>

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
                <div class="col s12 m6 l4">
                  {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                  <select id="ubicacion_id" class="browser-default validate select2" name="ubicacion_id" style="width: 100%;">
                      <option value="" selected>SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                          {{-- @php
                          $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                          $selected = '';
                          if($ubicacion->id == $ubicacion_id){
                            $selected = 'selected';
                          }
                          @endphp --}}
                          <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                      @endforeach
                  </select>
                </div>

                <div class="col s12 m6 l4">
                  {!! Form::label('escClave', 'Tipo Cuota', array('class' => '')); !!}
                    <select name="cuoTipo" id="cuoTipo" class="browser-default validate select2"  style="width: 100%;">
                      <option value="" selected>SELECCIONAR</option>
                      <option value="E" {{$cuota->cuoAnio == "E" ? "selected":""}}>ESCUELA</option>
                      <option value="D" {{$cuota->cuoAnio == "D" ? "selected":""}}>DEPARTAMENTO</option>
                      <option value="P" {{$cuota->cuoAnio == "P" ? "selected":""}}>PROGRAMA</option>
                    </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                  <select id="departamento_id" class="browser-default validate select2"  name="departamento_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                  <select id="escuela_id" class="browser-default validate select2"  name="escuela_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                  <select id="programa_id" class="browser-default validate select2"  name="programa_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  @if ($escuela)
                      <p style="font-size: 16px; font-weight: bold;">POR ESCUELA</p>
                      <p style="font-weight: bold;">{{$escuela->escNombre}}</p>
                  @endif

                  @if ($programa)
                      <p style="font-size: 16px; font-weight: bold;">POR PROGRAMA</p>
                      <p style="font-weight: bold;">{{$programa->progNombre}}</p>
                  @endif

                  @if ($departamento)
                      <p style="font-size: 16px; font-weight: bold;">POR DEPARTAMENTO</p>
                      <p style="font-weight: bold;">{{$departamento->depNombre}}</p>
                  @endif
                </div>

                <div class="col s12 m6 l4">
                  <p><span style="font-weight: bold;">QUIEN CREO:</span> {{$usuario->empleado->persona->perNombre}} {{$usuario->empleado->persona->perApellido1}} {{$usuario->empleado->persona->perApellido2}}</p>
                  <p><span style="font-weight: bold;">FECHA/HORA:</span> {{$cuota->created_at->format("d-m-Y")}} / {{$cuota->created_at->format("h:i A")}}</p>
                </div>


                <div class="col s12 m12 l12">
                  <hr>
                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoAnio', $cuota->cuoAnio, array('id' => 'cuoAnio', 'class' => 'validate')) !!}
                    {!! Form::label('cuoAnio', 'Año inicio curso *', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImportePadresFamilia', $cuota->cuoImportePadresFamilia, array('id' => 'cuoImportePadresFamilia', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImportePadresFamilia', 'Importe PadFam/Incorpo. UADY', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteOrdinarioUady', $cuota->cuoImporteOrdinarioUady, array('id' => 'cuoImporteOrdinarioUady', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteOrdinarioUady', 'Importe Exam. Ord. UADY', array('class' => '')); !!}
                  </div>
                </div>
              </div>


              
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad10', $cuota->cuoImporteMensualidad10, array('id' => 'cuoImporteMensualidad10', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad10', 'Importe Mensualidad 10 Meses', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad11', $cuota->cuoImporteMensualidad11, array('id' => 'cuoImporteMensualidad11', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad11', 'Importe Mensualidad 11 Meses', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad12', $cuota->cuoImporteMensualidad12, array('id' => 'cuoImporteMensualidad12', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad12', 'Importe Mensualidad 12 Meses', array('class' => '')); !!}
                  </div>
                </div>
              </div>


                            
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteVencimiento', $cuota->cuoImporteVencimiento, array('id' => 'cuoImporteVencimiento', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteVencimiento', 'Importe Cargo Mes Vencido', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteProntoPago', $cuota->cuoImporteProntoPago, array('id' => 'cuoImporteProntoPago', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteProntoPago', 'Importe Descto Pronto Pago', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoDiasProntoPago', $cuota->cuoDiasProntoPago, array('id' => 'cuoDiasProntoPago', 'class' => 'validate')) !!}
                    {!! Form::label('cuoDiasProntoPago', 'Num. de Dias Pronto Pago', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoNumeroCuenta', $cuota->cuoNumeroCuenta, array('id' => 'cuoNumeroCuenta', 'class' => 'validate')) !!}
                    {!! Form::label('cuoNumeroCuenta', 'Número de cuenta o convenio', array('class' => '')); !!}
                  </div>
                </div>

              </div>


              <div class="row">
                <div class="col s12 m12 l12">
                  <hr>
                  <h5>Inscripción</h5>
                  <p>Importes</p>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteInscripcion2', $cuota->cuoImporteInscripcion2, array('id' => 'cuoImporteInscripcion2', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteInscripcion2', 'Segundo Plazo', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  {!! Form::label('cuoFechaLimiteInscripcion2', 'Fecha Límite', array('class' => '')); !!}
                  {!! Form::date('cuoFechaLimiteInscripcion2', $cuota->cuoFechaLimiteInscripcion2, array('id' => 'cuoFechaLimiteInscripcion2', 'class' => 'validate')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteInscripcion3', $cuota->cuoImporteInscripcion3, array('id' => 'cuoImporteInscripcion3', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteInscripcion3', 'Tercer Plazo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('cuoFechaLimiteInscripcion3', 'Fecha Límite', array('class' => '')); !!}
                  {!! Form::date('cuoFechaLimiteInscripcion3', $cuota->cuoFechaLimiteInscripcion3, array('id' => 'cuoFechaLimiteInscripcion3', 'class' => 'validate')) !!}
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
@include('scripts.programas')

@endsection