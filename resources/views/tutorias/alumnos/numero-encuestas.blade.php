@extends('layouts.dashboard')

@section('template_title')
Lista de encuetas
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_encuestas')}}" class="breadcrumb">Lista de alumno</a>
<a href="{{url('tutorias_encuestas/encuestas_disponibles/'.$alumno->AlumnoID)}}" class="breadcrumb">Lista de encuestas</a>
@endsection

@section('content')
    @php
        use App\Models\Alumno;
        use App\Models\Curso;

         $results = DB::select(DB::raw("SELECT
          aluClave AS 'clave_pago',
          alumnos.id AS 'alumnos_id',
          alumnos.aluEstado,
          personas.id AS 'persona_id',
          cursos.id as 'cursos_id',
          cursos.curPlanPago,
          cursos.curEstado,
          ubicacion.ubiClave,
          departamentos.depClave,
          departamentos.perAnte,
          departamentos.perActual,
          departamentos.perSig,
          escClave as 'escuela',
          programas.progClave,
          cgt.cgtGradoSemestre,
          cgt.cgtGrupo as 'grupo',
          cgt.id as 'cgt_id',
          periodos.perNumero,
          periodos.perAnio,
          periodos.perAnioPago,
          periodos.id as 'periodo_id'
        FROM
          cursos
          INNER JOIN periodos ON cursos.periodo_id = periodos.id
          AND periodos.deleted_at IS NULL
          INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
          AND alumnos.deleted_at IS NULL
          INNER JOIN personas ON alumnos.persona_id = personas.id
          AND personas.deleted_at IS NULL
          INNER JOIN cgt ON cursos.cgt_id = cgt.id
          AND cgt.deleted_at IS NULL
          INNER JOIN planes ON cgt.plan_id = planes.id
          AND planes.deleted_at IS NULL
          INNER JOIN programas ON planes.programa_id = programas.id
          AND programas.deleted_at IS NULL
          INNER JOIN escuelas ON programas.escuela_id = escuelas.id
          AND escuelas.deleted_at IS NULL
          INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
          AND cursos.periodo_id = departamentos.perActual
          AND departamentos.deleted_at IS NULL
          INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
          AND ubicacion.deleted_at IS NULL
        WHERE
          cursos.deleted_at IS NULL
          AND aluClave = ". auth()->user()->username.
          " AND curEstado in ('R', 'A', 'C', 'P')
          AND periodos.id IN (
          SELECT
            perActual
          FROM
            departamentos
          WHERE
            depClave IN ('SUP', 'POS', 'PRE', 'MAT', 'PRI', 'SEC', 'BAC')
        );"));
        $cursos = collect($results)->first();
        $curso = Curso::with("alumno.persona", "periodo.departamento.ubicacion", "cgt.plan.programa")
                 ->where("id", $cursos->cursos_id)->first();
        $ubicacion = $curso ? $curso->periodo->departamento->ubicacion : null;
    @endphp



<div class="row">
    <div class="col s12 ">

        <div class="card ">
            <div class="card-content ">
                <span class="card-title">ENCUESTAS DISPONIBLES</span>

                @for ($i = 0; $i < 10; $i++)

                @endfor
                <div class="row">
                    @foreach ($tutorias_formularios as $itemTutorias_formularios)
                    {{--
                    <div style="text-align: center; background-color: #01579B; border-radius: 10px; margin: 10px;" class="col s6 m6 l11"><br>
                    --}}
                        @if ($FORMULARIO_COVID && $itemTutorias_formularios->Tipo == 3)
                                {{-- encuesta COVID --}}
                            <div style="text-align: center; background-color: #01579B; border-radius: 10px; margin: 10px;" class="col s6 m6 l11"><br>
                                <a style="color: #fff" href="{{url('tutorias_encuestas/encuesta_covid/' . $itemTutorias_formularios->FormularioID . '/' .$alumno->AlumnoID)}}  ">
                                    <p>{{$itemTutorias_formularios->Nombre}}</p>
                                    {{--<p>{{ \Carbon\Carbon::parse($itemTutorias_formularios->FechaInicioVigencia)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($itemTutorias_formularios->FechaFinVigencia)->format('d/m/Y')}}</p>--}}
                                    <p>{{$itemTutorias_formularios->Descripcion}}</p>
                                </a>
                                <br>
                            </div>
                        @else
                                @if(FORMULARIOS_ALUMNOS)
                                    {{-- encuesta PRIMER SEMESTRE --}}
                                        @if(    (auth()->user()->depClave == 'SUP')
                                                && ($ubicacion && $ubicacion->ubiClave == 'CME')
                                                && ($curso->curEstado == "R")
                                                && ($curso->cgt->cgtGradoSemestre == 1)
                                                && ($itemTutorias_formularios->Estatus == 1)
                                          )
                                            <div style="text-align: center; background-color: #01579B; border-radius: 10px; margin: 10px;" class="col s6 m6 l11"><br>
                                                <a style="color: #fff" href="{{url('tutorias_encuestas/encuesta/' . $itemTutorias_formularios->FormularioID . '/' .$alumno->AlumnoID)}}  ">
                                                    <p>{{$itemTutorias_formularios->Nombre}}</p>
                                                    {{-- <p>{{ \Carbon\Carbon::parse($itemTutorias_formularios->FechaInicioVigencia)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($itemTutorias_formularios->FechaFinVigencia)->format('d/m/Y')}}</p>--}}
                                                    <p>{{$itemTutorias_formularios->Descripcion}}</p>
                                                </a>
                                                <br>
                                            </div>
                                        @endif

                                @endif

                        @endif
                    {{--
                            <br>
                        </div>
                    --}}
                    @endforeach
    </div>



    </div>

    </div>

    </div>
    </div>



    @endsection

    @section('footer_scripts')



    @endsection
