<aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible navbar-fixed">
    <div class="brand-sidebar">
        <center>
            <img src="{{ asset('/images/logo-blanco.png') }}" width="25%" height="25%">
            <a href="javascript:void(0);" style="color:white; float:left;" class="sidenav-trigger-hide hide-on-small-only-new">
                <i class="material-icons waves-effect waves-light" style="font-size:40px; margin: 8px 0 0 20px; position: fixed;">menu</i>
            </a>
        </center>
    </div>
    @php
        use App\Models\Alumno;
        use App\Models\Curso;

        /*
        $curso = Curso::whereHas('alumno', function($query) {
              $query->where('aluClave', auth()->user()->username);
            })->latest('curFechaRegistro')->first();
        */

         $results = DB::select("SELECT
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
          programas.progClave as 'carrera',
          cgt.cgtGradoSemestre as 'semestre',
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
        );");
        $cursos = collect($results)->first();
        $curso = Curso::with("alumno.persona", "periodo.departamento.ubicacion", "cgt.plan.programa")
                 ->where("id", $cursos->cursos_id)->first();
        $ubicacion = $curso ? $curso->periodo->departamento->ubicacion : null;
        $alumno = Alumno::with('persona')
        ->where('aluClave', auth()->user()->username)
        ->first();
        $alumnoId = $alumno->id;
        //dd($alumnoId);
    @endphp

    <ul id="slide-out" class="side-nav fixed leftside-navigation sidenav">
        <li class="no-padding">
            <ul class="collapsible" data-collapsible="accordion">

                @if (Auth::user()->depClave == "SUP" || Auth::user()->depClave == "POS")

                    @if($MODULO_PAGOS_ACTIVO)
                        <li class="bold">
                            <a href="{{ url('libreta_de_pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>LIBRETA DE PAGO</span>
                            </a>
                        </li>
                    @endif

                    <li class="bold">
                        <a href="{{ url('alumno_pagos/' . Auth::user()->username) }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>COLEGIATURAS / INSCR.</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('notificar') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>NOTIFICAR PAGOS</span>
                        </a>
                    </li>
                    @php

                        $aluClave = Auth::user()->username;

                        $results = DB::select("SELECT
                              cursos.id as curso_id,
                              cursos.curPlanPago,
                              cursos.curEstado,
                              ubicacion.ubiClave,
                              departamentos.depClave,
                              cgt.cgtGradoSemestre
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
                              AND aluClave = $aluClave
                              AND curEstado in ('R', 'A', 'C', 'P')
                              AND periodos.id IN (
                              SELECT
                                perActual
                              FROM
                                departamentos
                              WHERE
                                depClave IN ('SUP', 'POS', 'PRE', 'MAT', 'PRI', 'SEC', 'BAC')
                            );");


                        //ES REGULAR O CONDICIONADO
                        $esRegular = collect($results)->first();
                        //ES DEUDOR DE INSCRIPCIONES
                        //Solo ven horarios
                        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                        $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);
                        $condicion = ' AND ( conc_pago IN ("99", "00", "01") )';
                        $pagos = DB::select("call procDeudasAlumnoAccesoPortal("
                        ."1"
                        .","
                        .$aluClave
                        .","
                        ."'".$condicion."'"
                        .","
                        ."'I'"
                        .","
                        ."'".$temporary_table_name."')");
                        $soloVeHorarios = DB::table($temporary_table_name)->where("cve_fila", "=", "TL$")->first();
                        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );

                    @endphp

                    @if($MODULO_HORARIOS_ACTIVO)
                        {{-- @if ($esRegular->curEstado == "R" || (float)$soloVeHorarios->total_mes > 0) --}}
                        @if ($esRegular->curEstado == "R")

                            <li class="bold">
                                <a href="{{ url('horario') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>HORARIO</span>
                                </a>
                            </li>

                        @endif
                    @endif

                    @if ($esRegular->curEstado == "R")
                        <li class="bold">
                            <a href="{{ url('asignaturas') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>ASIGNATURAS</span>
                            </a>
                        </li>
                        <li class="bold">
                            <a href="{{ url('calificaciones') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>CALIFICACIONES</span>
                            </a>
                        </li>

                        <li class="bold">
                            <a href="{{ url('ordinarios') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>ORDINARIOS</span>
                            </a>
                        </li>
                        @if ( ($esRegular->depClave == "SUP") )
                            <li class="bold">
                                <a href="{{ url('adeudadas') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>ASIG.ADEUDADAS</span>
                                </a>
                            </li>
                        @endif
                    @endif

                    @if ( ($esRegular->curEstado == "R") && ($esRegular->ubiClave == "CME") )
                        {{-- Constancias --}}
                        <li class="bold">
                            <a href="{{ url('constancias') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>CONSTANCIAS</span>
                            </a>
                        </li>
                    @endif

                    @if ( ($esRegular->curEstado == "R") && ($esRegular->depClave == "SUP") )
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-cyan">
                                <i class="material-icons">dashboard</i>
                                <span class="nav-text">EXTRAORDINARIOS</span>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    @if($EXTRAORDINARIOS_ACTIVOS)
                                        @if($esRegular->ubiClave == "CME")
                                            <li>
                                                <a href="{{ url('inscribirse_extraordinario') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Solicitud</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('fichas_preinscritos_extraordinarios') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Fichas</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('notificar') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>Notificar Pago Extra</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif

                                    <li>
                                        <a href="{{ url('extraordinarios') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Exámenes Inscritos</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('calificaciones_extraordinarios') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>Calificaciones</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endif

                    @php
                        $encuesta = DB::table('validaencuesta')->where('encAluClave', auth()->user()->username)->first();
                    @endphp

                    {{-- --}}
                    @if($EVALUACION_DOCENTE && $encuesta && $encuesta->encValidado == 'N'
                            && auth()->user()->depClave == 'SUP'
                            && ($ubicacion && ($ubicacion->ubiClave == 'CME' || $ubicacion->ubiClave == 'CVA' )) )
                        <li class="bold">
                            <a href="{{ url('encuesta') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>ENCUESTA</span>
                            </a>
                        </li>
                    @endif


                    @if(       (auth()->user()->depClave == 'SUP')
                                && ($ubicacion && $ubicacion->ubiClave == 'CME')
                                && ($esRegular->curEstado == "R")
                     )
                        {{-- @if(Auth::user()->username == "12089416") --}}
                        <li class="bold">
                            <a href="{{ url('tutorias_encuestas/encuestas_disponibles/'.Auth::user()->username.'/'.$esRegular->curso_id) }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>FORMULARIOS</span>
                            </a>
                        </li>
                        {{-- @endif --}}

                    @endif

                @endif


                {{-- Menu MAT  --}}
                @if (Auth::user()->depClave == "MAT")
                    {{-- PREESCOLAR --}}
                    @if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                        <li class="bold">
                            <a href="{{ url('libreta_de_pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>LIBRETA DE PAGO</span>
                            </a>
                        </li>
                    @endif
                    <li class="bold">
                        <a href="{{ url('alumno_pagos/' . Auth::user()->username) }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>COLEGIATURAS / INSCR.</span>
                        </a>
                    </li>
                    {{-- --}}
                    @if($OPCIONES_ACADEMICAS_MAT)

                                @if ($curso->curEstado == "R")
                                    <li class="bold">
                                        <a href="{{ url('preescolar/grupo') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>CALIFICACIONES</span>
                                        </a>
                                    </li>
                                @endif
                    @endif

                @endif

                {{-- Menu PRE --}}
                @if (Auth::user()->depClave == "PRE")
                    {{-- PREESCOLAR --}}
                    @if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                        <li class="bold">
                            <a href="{{ url('libreta_de_pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>LIBRETA DE PAGO</span>
                            </a>
                        </li>
                    @endif
                    <li class="bold">
                        <a href="{{ url('alumno_pagos/' . Auth::user()->username) }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>COLEGIATURAS / INSCR.</span>
                        </a>
                    </li>
                    @if($OPCIONES_ACADEMICAS_PRE)
                            @if ($curso->curEstado == "R")
                                <li class="bold">
                                    <a href="{{ url('preescolar/grupo') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CALIFICACIONES</span>
                                    </a>
                                </li>
                            @endif
                    @endif
                @endif


                {{-- Menu PRI  --}}
                @if (Auth::user()->depClave == "PRI")
                    {{-- PRIMARIA --}}
                    @if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                        <li class="bold">
                            <a href="{{ url('libreta_de_pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>LIBRETA DE PAGO</span>
                            </a>
                        </li>
                    @endif
                    <li class="bold">
                        <a href="{{ url('alumno_pagos/' . Auth::user()->username) }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>COLEGIATURAS / INSCR.</span>
                        </a>
                    </li>
                    @if($OPCIONES_ACADEMICAS_PRI)
                            @if ($curso->curEstado == "R")
                                <li class="bold">
                                    <a href="{{ url('calificacion_alumno_primaria') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>CALIFICACIÓN</span>
                                    </a>
                                </li>

                                <li class="bold">
                                    <a href="{{ url('primaria_faltas_alumno') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>INASISTENCIA</span>
                                    </a>
                                </li>
                            @endif
                    @endif
                @endif


                {{-- Menu SEC  --}}
                @if (Auth::user()->depClave == "SEC")
                    @if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                        <li class="bold">
                            <a href="{{ url('libreta_de_pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>LIBRETA DE PAGO</span>
                            </a>
                        </li>
                    @endif
                    <li class="bold">
                        <a href="{{ url('alumno_pagos/' . Auth::user()->username) }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>COLEGIATURAS / INSCR.</span>
                        </a>
                    </li>
                    @if($OPCIONES_ACADEMICAS_SEC)
                                @if ($curso->curEstado == "R")
                                    <li class="bold">
                                        <a href="{{ url('calificacion_alumno') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>CALIFICACIONES</span>
                                        </a>
                                    </li>

                                    <li class="bold">
                                        <a href="{{ url('secundaria_faltas_alumno') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>FALTAS</span>
                                        </a>
                                    </li>
                                @endif
                    @endif

                @endif

                {{-- Menu BAC  --}}
                @if (Auth::user()->depClave == "BAC")
                    @if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                        <li class="bold">
                            <a href="{{ url('libreta_de_pago') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>LIBRETA DE PAGO</span>
                            </a>
                        </li>
                    @endif
                    <li class="bold">
                        <a href="{{ url('alumno_pagos/' . Auth::user()->username) }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>COLEGIATURAS / INSCR.</span>
                        </a>
                    </li>
                    @if ($ubicacion->ubiClave == 'CME' || $ubicacion->ubiClave == 'CVA')
                    <li class="bold">
                        <a target="_blank" href="{{route('bachiller.bachiller_reglamento.index')}}">
                        {{--  <a href="{{route('bachiller.bachiller_reglamento.index')}}">  --}}
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>REGLAMENTO</span>
                        </a>
                    </li>
                    @endif

                    @if ($ubicacion->ubiClave == 'CME')
                        @if ($VIEW_HORARIOS_CME)

                            <li class="bold">
                                <a href="{{ url('bachiller_horario_alumno') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>HORARIO</span>
                                </a>
                            </li>

                        @endif
                    @else
                        @if ($VIEW_HORARIOS_CVA)

                            <li class="bold">
                                <a href="{{ url('bachiller_horario_alumno') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>HORARIO</span>
                                </a>
                            </li>

                        @endif
                    @endif

                    @if($OPCIONES_ACADEMICAS_BAC)
                                @if ($curso->curEstado == "R"
                                    && ($ubicacion && $ubicacion->ubiClave != 'CCH') )


                                    @if ($ubicacion->ubiClave == 'CME')
                                        @if ($AVANCE_BAC_CME)
                                            <li class="bold">
                                                <a href="{{ url('bachiller_calificacion_alumno') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>AVANCES</span>
                                                </a>
                                            </li>
                                        @endif
                                    @else
                                        @if ($AVANCE_BAC_CVA)
                                            <li class="bold">
                                                <a href="{{ url('bachiller_calificacion_alumno') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>AVANCES</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif


                                    {{--  Mostrar si es true   --}}
                                    @if ($ubicacion->ubiClave == 'CME')
                                        @if ($BOLETA_BAC_MONTEJO)
                                            <li>
                                                <a href="{{ route('bachiller.bachiller_boleta_final.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>CALIFICACIONES</span>
                                                </a>
                                            </li>
                                        @endif
                                    @else
                                        @if ($BOLETA_BAC_CVA)
                                            <li>
                                                <a href="{{ route('bachiller.bachiller_boleta_final.reporte') }}">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                    <span>CALIFICACIONES</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif



                                    <li class="bold">
                                        <a href="{{ url('bachiller_adeudadas') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>MATERIAS ADEUDADAS</span>
                                        </a>
                                    </li>

                                    {{-- <li class="bold">
                                        <a href="{{ url('bachiller_historial_academico') }}">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                            <span>HISTORIAL ACADÉMICO</span>
                                        </a>
                                    </li> --}}


                                                            <li class="bold">
                                                                    <a class="collapsible-header waves-effect waves-cyan">
                                                                        <i class="material-icons">dashboard</i>
                                                                        <span class="nav-text">RECUPERATIVOS</span>
                                                                    </a>
                                                                    <div class="collapsible-body">
                                                                        @php
                                                                            $aluClave = Auth::user()->username;
                                                                        @endphp
                                                                        <ul>
                                                                            <li>
                                                                                <a href="{{ url('bachiller_solicitudes_recuperativos') }}">
                                                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                                                    <span>Recup.Calificaciones</span>
                                                                                </a>
                                                                            </li>


                                                                            @if ($ubicacion->ubiClave == 'CME')
                                                                                @if ($VIEW_RECUPERATIVOS_CME)

                                                                                    <li>
                                                                                        <a href="{{ url('bachiller_recuperativos') }}">
                                                                                            <i class="material-icons">keyboard_arrow_right</i>
                                                                                            <span>Solicitudes Recuperativo</span>
                                                                                        </a>
                                                                                    </li>

                                                                                @endif
                                                                            @else
                                                                                @if ($VIEW_RECUPERATIVOS_CVA)

                                                                                    <li>
                                                                                        <a href="{{ url('bachiller_recuperativos') }}">
                                                                                            <i class="material-icons">keyboard_arrow_right</i>
                                                                                            <span>Solicitudes Recuperativo</span>
                                                                                        </a>
                                                                                    </li>

                                                                                @endif
                                                                            @endif

                                                                            {{--
                                                                            <li>
                                                                                <a href="{{ url('bachiller_notificar_pago') }}">
                                                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                                                    <span>Notificar Pago</span>
                                                                                </a>
                                                                            </li>
                                                                            --}}


                                                </ul>
                                            </div>
                                        </li>


                                @endif
                    @endif
                @endif

                @if($BIBLIOTECA_ALUMNO_ACTIVA)
                    @if (Auth::user()->depClave == "SUP")
                    <li class="bold">
                        <a href="{{ url('biblioteca') }}">
                            <i class="material-icons">keyboard_arrow_right</i>
                            <span>BIBLIOTECA</span>
                        </a>
                    </li>
                    @endif
                @endif
                @if (Auth::user()->depClave == "SUP" || Auth::user()->depClave == "POS")
                  <li class="bold">
                      <a href="{{ route('micuenta.index') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>MI CUENTA</span>
                      </a>
                  </li>
                @endif
                @php
                    $curso = Curso::select(
                        'departamentos.depClave',
                        'ubicacion.ubiClave'
                    )
                    ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                    ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                    ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                    ->join('departamentos',function($join){
                        $join->on('escuelas.departamento_id', '=', 'departamentos.id')
                            ->on('cursos.periodo_id', '=', 'departamentos.perActual');
                    })
                    ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                    ->where('alumnos.aluClave', Auth::user()->username)
                    ->where('cursos.curEstado', '!=', 'B')
                    ->first();
                @endphp

                @if($curso->ubiClave == 'CME' || $curso->ubiClave == 'CVA')
                    @if ($curso->depClave == 'SUP' || $curso->depClave == 'POS')
                        <li class="bold">
                            <a href="{{ route('documentos.index') }}">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>DOCUMENTOS</span>
                            </a>
                        </li>
                    @endif
                @endif


                <li class="bold">
                    <a href="{{ url('logout') }}">
                        <i class="material-icons">keyboard_arrow_right</i>
                        <span>SALIR</span>
                    </a>
                </li>


            </ul>
        </li>
    </ul>
    <a href="#" data-activates="slide-out" style="margin-top: -12px; background-color: #01579E " class="sidebar-collapse btn-floating btn-medium waves-effect waves-light gradient-45deg--cyan gradient-shadow hide-on-large-only">
    <i class="material-icons">menu</i>
    </a>
</aside>

<script>
    $(document).ready(function(){
        $('.sidenav-trigger-hide').on('click',function(e){
            e.preventDefault();
            $('#left-sidebar-nav').hide('slide');
            $('#main').removeClass('mainPaddingSidebar');
            $('#main').addClass('mainPaddingLeft');
        });
    });
</script>
