@extends('layouts.dashboard')

@section('template_title')
  Inscrito edu. continua
@endsection

@section('head')

@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="{{url('inscritosEduContinua')}}" class="breadcrumb">Lista de Inscritos</a>
  <label class="breadcrumb">Agregar Inscrito</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['class' => 'form-inscrito', 'onKeypress' => 'return disableEnterKey(event)','route' => 'inscritosEduContinua.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR INSCRITO</span>

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
                  {!! Form::label('alumno_id', 'Alumno *', array('class' => '')); !!}
                  <input type="text" placeholder="Buscar por: Clave Nombre(s)" id="nombreAlumno" value="{{old('nombreAlumno')}}" type="text" name="nombreAlumno" style="width: 100%;" />
                  <button class="btn-large waves-effect darken-3 btn-buscar-alumno">
                    <i class="material-icons left">search</i>
                    Buscar
                  </button>
                </div>
                <div class="col s12 m6 l4">
                  <label for="">Resultado Busqueda:</label>
                  <div class="resultado-busqueda">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('educacioncontinua_id', 'Educacion continua *', []); !!}
                  <select id="educacioncontinua_id" class="browser-default validate select2" required name="educacioncontinua_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach ($educacionContinua as $eduCont)
                      <option value="{{$eduCont->id}}">{{$eduCont->ecClave . " " . $eduCont->ecNombre }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('iecGrupo', NULL, array('id' => 'iecGrupo', 'class' => 'validate','required', 'maxlength'=>'3')) !!}
                    {!! Form::label('iecGrupo', 'Grupo *', []); !!}
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('iecFechaRegistro', 'Fecha registro *', []); !!}
                  {!! Form::date('iecFechaRegistro', \Carbon\Carbon::now(), array('id' => 'iecFechaRegistro', 'class' => 'validate','required')) !!}
                </div>



              </div>


              
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('iecImporteInscripcion', NULL, array('id' => 'iecImporteInscripcion', 'class' => 'validate')) !!}
                    {!! Form::label('iecImporteInscripcion', 'Importe inscripcion', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('iecFechaProcesoRegistro', 'Fecha proceso registro', array('class' => '')); !!}
                  {!! Form::date('iecFechaProcesoRegistro', \Carbon\Carbon::now(), array('id' => 'iecFechaProcesoRegistro', 'class' => 'validate')) !!}
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

    var alumnoIdOld = "{{old("alumno_id")}}";


    if (alumnoIdOld) {
      buscarAlumno()
    }
    function buscarAlumno()
    {
      var nombreAlumno = $("#nombreAlumno").val()

      $.get(base_url + `/api/getAlumnosByFilter/${nombreAlumno}`,function(res,sta){

        console.log("res")
        console.log(res)

        if (Object.keys(res).length > 0) {
          $(".form-inscrito").find(".resultado-busqueda").empty();
          $(".form-inscrito").find(".resultado-busqueda").append('<input id="alumno_busqueda" name="alumno_busqueda" value="" type="text" disabled>')
          $(".form-inscrito").find(".resultado-busqueda").append('<input id="alumno_id" name="alumno_id" value="" type="hidden"  />')

          $("#alumno_busqueda").val(res.aluClave + "-" + res.perApellido1 + " " + res.perApellido2 + " " + res.perNombre)
          $("#alumno_id").attr("value", res.alumno_id)
        }
        
      });
    }


    
    $(".btn-buscar-alumno").on("click", function (e) {
      e.preventDefault()
      buscarAlumno()
    })

  });
</script>





@include('scripts.programas')
@include('scripts.periodos')

@endsection