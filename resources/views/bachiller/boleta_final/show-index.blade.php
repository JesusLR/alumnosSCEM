@extends('layouts.dashboard')



@section('template_title')
    Calificaciones
@endsection

@section('head')
    {!! HTML::style(asset('/public/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('calificacion_alumno_primaria')}}" class="breadcrumb">Calificaciones</a>
@endsection

@section('content')
@php
use App\Http\Helpers\Utils;
@endphp
<div id="table-datatables">
    <h4 class="header">BOLETA DE CALIFICACIONES DEL CURSO ACTUAL</h4>
    <div class="row">
        <div class="col s12 m8 l8">
            <div>Clave: {{ $aluClave }}</div>
            <div>Nombre: {{ $fullName }}</div>
            <p>Estimado(a) padre/madre de familia: En el siguiente botón puede visualizar y descargar la última boleta de calificaciones del alumno(a).</p>

            <a href="{{url('bachiller_boleta_final/imprimir/')}}" class="btn-large waves-effect darken-3" target="_blank" type="button">Visualizar Boleta
                <i class="material-icons left">picture_as_pdf</i>
            </a>
        </div>
    </div>

@endsection

@section('footer_scripts')
{!! HTML::script(asset('/public/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/public/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript"></script>
@endsection
