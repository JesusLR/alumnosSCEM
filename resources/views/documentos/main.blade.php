@extends('layouts.dashboard')

@section('template_title')
    Cuenta
@endsection

@section('head')

@endsection


@section('breadcrumbs')
    <div class="col s12">
        <p style="color: #000; margin-left: 10px;">

        </p>
    </div>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    Documentos
                </span>
        
                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" target="_blank" href="{{ route('documentos.url') }}">Liga al login para subir documentos</a></li>
                        </ul>
                    </div>
                </nav>

                
                {{-- cambiarPassword BAR--}}
                <div id="cambiarPassword">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <video class="responsive-video" controls>
                                <source src="{{ \URL::to('public/video/'.$url) }}">
                            </video>
                            <div>
                                <a target="_blank" class="btn btn-primary" href="{{ route('documentos.url') }}">
                                    <span>DOCUMENTOS</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer_scripts')

@endsection