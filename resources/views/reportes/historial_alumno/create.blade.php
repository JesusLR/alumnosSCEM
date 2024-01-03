@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Historial academico de alumnos</a>
@endsection

@section('content')
@php
use App\Models\User;
@endphp
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'reporte/historial_alumno/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Historial academico de alumnos</span>
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
              @if(!empty($message))
              <div class="row">
                <div class="col s12 m12" align="center">
                    <div class="chip red darken-1">
                        <span class="white-text">{{ $message }}</span>
                        <i class=" close material-icons right white-text">close</i>
                    </div>
                </div>
              </div>
              @endif


              <div class="col s12 m6 l6">
                {!! Form::label('ubicacion_id', 'Campus', ['class' => '',]); !!}
                <select name="ubicacion_id" id="ubicacion_id" class="browser-default validate select2" required style="width: 100%;" required>
                  @foreach ($ubicaciones as $item)
                    @php
                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                    $selected = '';
                    if($item->id == $ubicacion_id){
                        $selected = 'selected';
                    }
                    @endphp
                    <option value="{{$item->id}}" {{$selected}}>{{$item->ubiClave}} - {{$item->ubiNombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col s12 m6 l6">
                {!! Form::label('firmante', 'Firmante', ['class' => '']); !!}
                <select name="firmante" id="firmante" class="browser-default validate select2" required style="width: 100%;" required>
                    <option value="">Seleccionar Firmante</option>
                </select>
              </div>

              
    
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('tipoDato', 'Buscar por:', ['class' => '',]); !!}
                <select name="tipoDato" id="tipoDato" class="browser-default validate select2" style="width: 100%;" required>
                  <option value="1" selected>Clave del alumno</option>
                  <option value="2">Matrícula del alumno</option>
                </select>
              </div>
              <div class="col s12 m6 l4" id="aluClaveDiv">
                <div class="input-field">
                  {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave del alumno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4" id="aluMatriculaDiv">
                <div class="input-field">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluMatricula', 'Matrícula del alumno', array('class' => '')); !!}
                </div>
              </div>
           
              <div class="col s12 m6 l4">
                <br>
                <a id="buscarProgramas" class="btn-floating waves-effect tooltipped blue darken-3" data-tooltip="Buscar programas" float="left"><i class="material-icons left">search</i></a>
                {{-- {!! Form::label('progClave', 'Programa', ['class' => '',]); !!} --}}
                <select name="progClave" id="progClave" class="browser-default validate select2" style="width:85%;" required>
                  <option value="">Seleccionar Programa</option>
                  {{-- @foreach ($programas as $item)
                      <option value="{{$item->progClave}}">{{$item->progClave}}</option>
                  @endforeach --}}
                </select>
              </div>
          </div>

          </div>
        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit','id'=>'botonSubmit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')

<script type="text/javascript">
  $(document).ready(function(){

    $('#aluClaveDiv').hide();
    $('#aluMatriculaDiv').hide();

    $('#progClave').prop('disabled',true);
    $('#botonSubmit').prop('disabled',true);

    function obtenerFirmantes(ubicacion_id){
      $.get(base_url+`/obtenerFirmantes/${ubicacion_id}`,function(data){
        $('#firmante').empty();
        $.each(data,function(key,value){
          $('#firmante').append('<option value="'+value.id+'">'+value.firNombre+'</option>');
        });
      });
    }
    $('#ubicacion_id').change(function(){
      var ubicacion_id = $(this).val();
      obtenerFirmantes(ubicacion_id);
    });

    obtenerFirmantes($('#ubicacion_id').val());

    function seleccionarTipo(alumnoTipo){
      if(alumnoTipo == 1){
        $('#aluClaveDiv').show();
        $('#aluMatricula').val('');
        $('#aluMatriculaDiv').hide();
      }
      if(alumnoTipo == 2){
        $('#aluMatriculaDiv').show();
        $('#aluClave').val('');
        $('#aluClaveDiv').hide();
      }
    }

    $('#tipoDato').change(function(){
      var alumnoTipo = $(this).val();
      seleccionarTipo(alumnoTipo);
    });

    seleccionarTipo($('#tipoDato').val());

    $('#aluClave').change(function(){
      $('#progClave').empty();
      $('#progClave').append('<option value="">Seleccionar Programa</option>');
      $('#progClave').prop('disabled',true);
      $('#botonSubmit').prop('disabled',true);
    });

    $('#aluMatricula').change(function(){
      $('#progClave').empty();
      $('#progClave').append('<option value="">Seleccionar Programa</option>');
      $('#progClave').prop('disabled',true);
      $('#botonSubmit').prop('disabled',true);
    });


    $('#buscarProgramas').click(function(){
      var aluClave = $('#aluClave').val();
      var aluMatricula = $('#aluMatricula').val();

      if(aluClave){
        $.get(base_url+`/historial_alumno/obtenerProgramasClave/${aluClave}`,function(data){
          if($.isEmptyObject(data)){
            $('#progClave').empty();
            $('#progClave').append('<option value="">Seleccionar Programa</option>');
            $('#progClave').prop('disabled',true);
            $('#botonSubmit').prop('disabled',true);
            swal('No se encontró al alumno con la clave proporcionada');
          }else{
          $('#progClave').prop('disabled',false);
          $('#botonSubmit').prop('disabled',false);
          $('#progClave').empty();
          console.log(data);
          $.each(data,function(key,value){
            $('#progClave').append('<option value="'+value.progClave+'">'+value.progClave+' '+value.progNombre+'</option>');
          });
          };
        });
      }else if(aluMatricula){
        $.get(base_url+`/historial_alumno/obtenerProgramasMatricula/${aluMatricula}`,function(data){
          if($.isEmptyObject(data)){
            $('#progClave').empty();
            $('#progClave').append('<option value="">Seleccionar Programa</option>');
            $('#progClave').prop('disabled',true);
            $('#botonSubmit').prop('disabled',true);
            swal('No se encontró al alumno con la matrícula proporcionada');
          }else{
          $('#progClave').prop('disabled',false);
          $('#botonSubmit').prop('disabled',false);
          $('#progClave').empty();
          console.log(data);
          $.each(data,function(key,value){
            $('#progClave').append('<option value="'+value.progClave+'">'+value.progClave+' '+value.progNombre+'</option>');
          });
          };
        });
      }else{
        $('#progClave').empty();
        $('#progClave').append('<option value="">Seleccionar Programa</option>');
        $('#progClave').prop('disabled',true);
        $('#botonSubmit').prop('disabled',true);
        swal('Por favor ingrese la clave o matrícula del alumno.')
      }
    });
  });


</script>

@endsection