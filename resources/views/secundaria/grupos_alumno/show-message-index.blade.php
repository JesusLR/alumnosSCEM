@extends('layouts.dashboard')



@section('template_title')
    Grupo calificaciones
@endsection

@section('head')
    {!! HTML::style(asset('/public/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('calificacion_alumno')}}" class="breadcrumb">Grupo calificaciones</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Grupo calificaciones</h4>

        <div class="row">
            <div class="col s12 m8 l8">
                <p style="color:#aa093f; font-size:20px;"><b>INFORMACIÓN IMPORTANTE:</b></p>
                <p>Estimado(a) padre/madre de familia: Por el momento, la boleta de calificaciones no se encuentra disponible para su descarga ya que nos encontramos en el periodo de evaluación del mes en turno. <br>La publicación de resultados está acorde al calendario de la dirección correspondiente. Para cualquier aclaración, favor de comunicarse al departamento de control escolar del nivel educativo de la institución.</p>
            </div>
        </div>

</div>


@endsection

@section('footer_scripts')


@endsection
