@extends('layouts.dashboard')

@section('template_title')
    Programa edu. continua
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('progEduContinua')}}" class="breadcrumb">Lista de Programas</a>
    <label class="breadcrumb">Agregar Programa</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'progEduContinua.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR PROGRAMA</span>

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
                  <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                      @php
                        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                        $selected = '';
                        if ($ubicacion->id == $ubicacion_id) {
                          $selected = 'selected';
                        }
                      @endphp
                      <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                  <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                  <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                  <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                  </div>
                </div>
              </div>




              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ecClave', NULL, array('id' => 'ecClave', 'class' => 'validate','required','maxlength'=>'3')) !!}
                    {!! Form::label('ecClave', 'Clave programa *', []); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ecNombre', NULL, array('id' => 'ecNombre', 'class' => 'validate','required')) !!}
                    {!! Form::label('ecNombre', 'Nombre programa *', []); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('tipoprograma_id', 'Tipo programa *', []); !!}
                  <select id="tipoprograma_id" class="browser-default validate select2" required name="tipoprograma_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach($tiposPrograma as $tipoPrograma)
                      <option value="{{$tipoPrograma->id}}">{{$tipoPrograma->tpNombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('ecFechaRegistro', 'Fecha registro *', []); !!}
                  {!! Form::date('ecFechaRegistro', \Carbon\Carbon::now(), array('id' => 'ecFechaRegistro', 'class' => 'validate','required')) !!}
                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('ecCoordinador_empleado_id', 'Empleado coordinador', []); !!}
                  <select id="ecCoordinador_empleado_id" class="browser-default validate select2" name="ecCoordinador_empleado_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach($empleados as $empleado)
                      <option value="{{$empleado->id}}">
                        {{$empleado->persona->perNombre . " " . $empleado->persona->perApellido1 . " " . $empleado->persona->perApellido2}}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecInstructor1_empleado_id', 'Instructor uno', []); !!}
                  <select id="ecInstructor1_empleado_id" class="browser-default validate select2" name="ecInstructor1_empleado_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach($empleados as $empleado)
                      <option value="{{$empleado->id}}">
                        {{$empleado->persona->perNombre . " " . $empleado->persona->perApellido1 . " " . $empleado->persona->perApellido2}}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecInstructor2_empleado_id', 'Instructor dos', []); !!}
                  <select id="ecInstructor2_empleado_id" class="browser-default validate select2" name="ecInstructor2_empleado_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach($empleados as $empleado)
                      <option value="{{$empleado->id}}">
                        {{$empleado->persona->perNombre . " " . $empleado->persona->perApellido1 . " " . $empleado->persona->perApellido2}}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('ecEstado', 'Estado del programa *', []); !!}
                  <select id="ecEstado" class="browser-default validate select2" required name="ecEstado" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      <option value="A">ABIERTO</option>
                      <option value="C">CERRADO</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m12 l12">
                  <h5>Cuotas y fechas de vencimiento</h5>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImporteInscripcion', NULL, array('id' => 'ecImporteInscripcion', 'class' => 'validate')) !!}
                    {!! Form::label('ecImporteInscripcion', 'Inscripcion', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoInscripcion', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoInscripcion', \Carbon\Carbon::now(), array('id' => 'ecVencimientoInscripcion', 'class' => 'validate')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago1', NULL, array('id' => 'ecImportePago1', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago1', 'Importe pago 1', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago1', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago1', \Carbon\Carbon::now(), array('id' => 'ecVencimientoPago1', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago2', NULL, array('id' => 'ecImportePago2', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago2', 'Importe pago 2', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago2', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago2', \Carbon\Carbon::now(), array('id' => 'ecVencimientoPago2', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago3', NULL, array('id' => 'ecImportePago3', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago3', 'Importe pago 3', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago3', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago3', \Carbon\Carbon::now(), array('id' => 'ecVencimientoPago3', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago4', NULL, array('id' => 'ecImportePago4', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago4', 'Importe pago 4', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago4', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago4', \Carbon\Carbon::now(), array('id' => 'ecVencimientoPago4', 'class' => 'validate')) !!}
                </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('ecImportePago5', NULL, array('id' => 'ecImportePago5', 'class' => 'validate')) !!}
                    {!! Form::label('ecImportePago5', 'Importe pago 4', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecVencimientoPago5', 'Vencimiento', array('class' => '')); !!}
                  {!! Form::date('ecVencimientoPago5', \Carbon\Carbon::now(), array('id' => 'ecVencimientoPago5', 'class' => 'validate')) !!}
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

@include('scripts.estados')
@include('scripts.municipios')

<script type="text/javascript">
  $(document).ready(function() {

      function obtenerDepartamentos(ubicacionId) {
          console.log(ubicacionId);

          console.log("aqui")
          $("#departamento_id").empty();


          $("#escuela_id").empty();
          $("#periodo_id").empty();
          $("#programa_id").empty();
          $("#plan_id").empty();
          $("#cgt_id").empty();
          $("#materia_id").empty();
          $("#departamento_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

          $("#perFechaInicial").val('');
          $("#perFechaFinal").val('');

          $.get(base_url+`/api/departamentos/${ubicacionId}`, function(res,sta) {

            //seleccionar el post preservado
            var departamentoSeleccionadoOld = $("#departamento_id").data("departamento-idold")
            $("#departamento_id").empty()
            res.forEach(element => {
                var selected = "";
                if (element.id === departamentoSeleccionadoOld) {
                    console.log("entra")
                    console.log(element.id)
                    selected = "selected";
                }

                $("#departamento_id").append(`<option value=${element.id} ${selected}>${element.depClave}-${element.depNombre}</option>`);
            });
            $('#departamento_id').trigger('change'); // Notify only Select2 of changes


            var departamento = res.find(element => element.depClave === "ECO");
            var departamentoId = departamento.id

            //OBTENER PERIODOS
            $.get(base_url+`/api/periodos/${departamentoId}`,function(res2,sta){
                var perSeleccionado;


                var periodoSeleccionadoOld = $("#periodo_id").data("periodo-idold")

                console.log(periodoSeleccionadoOld)
                $("#periodo_id").empty()
                res2.forEach(element => {

                    var selected = "";
                    if (element.id === periodoSeleccionadoOld) {
                        console.log("entra")
                        console.log(element.id)
                        selected = "selected";
                    }

                    $("#periodo_id").append(`<option value=${element.id} ${selected}>${element.perNumero}-${element.perAnio}</option>`);
                });
                //OBTENER FECHA INICIAL Y FINAL DEL PERIODO SELECCIONADO
                $.get(base_url+`/api/periodo/${perSeleccionado}`,function(res3,sta){
                    $("#perFechaInicial").val(res3.perFechaInicial);
                    $("#perFechaFinal").val(res3.perFechaFinal);
                    Materialize.updateTextFields();
                });

                $('#periodo_id').trigger('change'); // Notify only Select2 of changes
            });//TERMINA PERIODO

          });



      }
      
      obtenerDepartamentos($("#ubicacion_id").val())
      $("#ubicacion_id").change( event => {
          obtenerDepartamentos(event.target.value)
      });
   });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        function obtenerEscuelas (departamentoId) {
            $("#escuela_id").empty();
            $("#programa_id").empty();
            $("#plan_id").empty();
            $("#cgt_id").empty();
            $("#materia_id").empty();
            $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            
            $("#perFechaInicial").val('');
            $("#perFechaFinal").val('');



            $.get(base_url+`/api/escuelas/${departamentoId}`,function(res,sta){

                //seleccionar el post preservado
                var escuelaSeleccionadoOld = $("#escuela_id").data("escuela-idold")
                $("#escuela_id").empty()

                res.forEach(element => {
                    var selected = "";
                    if (element.id === escuelaSeleccionadoOld) {
                        selected = "selected";
                    }

                    $("#escuela_id").append(`<option value=${element.id} ${selected}>${element.escClave}-${element.escNombre}</option>`);
                });

                $('#escuela_id').trigger('change'); // Notify only Select2 of changes

            });


        }


        $("#departamento_id").change( event => {
            obtenerEscuelas(event.target.value)
        });
     });
</script>
@include('scripts.programas')
@include('scripts.periodos')

@endsection