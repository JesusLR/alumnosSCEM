<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="navbar-color   darken-4">
            @php
                use App\Models\User;
                use App\Http\Models\Curso;
                use Illuminate\Support\Facades\DB;
                $curso = Curso::whereHas('alumno', function($query) {
                  $query->where('aluClave', auth()->user()->username);
                })->latest('curFechaRegistro')->first();
                $ubicacion = $curso ? $curso->periodo->departamento->ubicacion : null;
            @endphp
            <div class="nav-wrapper">
                
                <a href="javascript:void(0);" style="color:white; float:left;" class="sidenav-trigger-show">
                    <i class="material-icons waves-effect waves-light hide-on-small-only-new" style="font-size:40px; margin: -4px 0 0 20px; position: fixed;">menu</i>
                </a>
                <div class="header-search-wrapper hide-on-med-and-down sideNav-lock">
                    <select id="menu-navegacion" class="browser-default validate select2" required name="menu-navegacion" style="width: 30%; position: relative!important; margin-top: -30px;">

                        @if($MODULO_PAGOS_ACTIVO)
                            <option value="{{ route('libretapago') }}" {{ url()->current() ==  route('libretapago') ? "selected": "" }}>Libreta de pago</option>
                        @endif

                        {{--
                        @if (Auth::user()->depClave == "SUP" || Auth::user()->depClave == "POS")
                            @if($MODULO_PAGOS_ACTIVO)
                              <option value="{{ url('libreta_de_pago') }}" {{ url()->current() ==  url('libreta_de_pago') ? "selected": "" }}>Libreta de pago</option>
                            @endif

                            @if($EXTRAORDINARIOS_ACTIVOS)
                                <option value="{{ url('inscribirse_extraordinario') }}" {{ url()->current() ==  url('inscribirse_extraordinario') ? "selected": "" }}>Solicitud de examenes</option>
                                <option value="{{ url('extraordinarios') }}" {{ url()->current() ==  url('extraordinarios') ? "selected": "" }}>Extraordinarios</option>
                                <option value="{{ url('calificaciones_extraordinarios') }}" {{ url()->current() ==  url('calificaciones_extraordinarios') ? "selected": "" }}>Calif. extraordinarios</option>
                            @endif

                                <option value="{{ url('alumno_pagos/' . Auth::user()->username) }}" {{ url()->current() ==  url('alumno_pagos/' . Auth::user()->username) ? "selected": "" }}>Pagos & Adeudos</option>
                                <option value="{{ url('notificar') }}" {{ url()->current() ==  url('notificar') ? "selected": "" }}>Notificar</option>

                            @if($MODULO_HORARIOS_ACTIVO)
                              <option value="{{ url('horario') }}" {{ url()->current() ==  url('horario') ? "selected": "" }}>Horario</option>
                            @endif

                              <option value="{{ url('asignaturas') }}" {{ url()->current() ==  url('asignaturas') ? "selected": "" }}>Asignaturas</option>
                              <option value="{{ url('calificaciones') }}" {{ url()->current() ==  url('calificaciones') ? "selected": "" }}>Calificaciones</option>
                              <option value="{{ url('ordinarios') }}" {{ url()->current() ==  url('ordinarios') ? "selected": "" }}>Ordinarios</option>
                              <option value="{{ url('adeudadas') }}" {{ url()->current() ==  url('adeudadas') ? "selected": "" }}>Asig.Adeudadas</option>

                            @php
                                $encuesta = DB::table('validaencuesta')->where('encAluClave', auth()->user()->username)->first();
                            @endphp



                            @endif
                            --}}

                        {{--
                             @if (Auth::user()->depClave == "MAT")
                                     @if($MODULO_PAGOS_ACTIVO)
                                         <option value="{{ url('libreta_de_pago') }}" {{ url()->current() ==  url('libreta_de_pago') ? "selected": "" }}>Libreta de pago</option>
                                     @endif

                                     @if ($curso->curEstado == "R")
                                         <option value="{{ url('preescolar/grupo') }}" {{ url()->current() ==  url('preescolar/grupo') ? "selected": "" }}>Calificaciones</option>
                                     @endif
                             @endif

                             @if (Auth::user()->depClave == "PRE")
                                 @if($MODULO_PAGOS_ACTIVO)
                                     <option value="{{ url('libreta_de_pago') }}" {{ url()->current() ==  url('libreta_de_pago') ? "selected": "" }}>Libreta de pago</option>
                                 @endif

                                 @if ($curso->curEstado == "R")
                                     <option value="{{ url('preescolar/grupo') }}" {{ url()->current() ==  url('preescolar/grupo') ? "selected": "" }}>Calificaciones</option>
                                 @endif
                             @endif

                             @if (Auth::user()->depClave == "PRI")
                                 @if($MODULO_PAGOS_ACTIVO)
                                     <option value="{{ url('libreta_de_pago') }}" {{ url()->current() ==  url('libreta_de_pago') ? "selected": "" }}>Libreta de pago</option>
                                 @endif

                                 @if ($curso->curEstado == "R")
                                     <option value="{{ url('calificacion_alumno_primaria') }}" {{ url()->current() ==  url('calificacion_alumno_primaria') ? "selected": "" }}>Calificaciones</option>
                                     <option value="{{ url('primaria_faltas_alumno') }}" {{ url()->current() ==  url('primaria_faltas_alumno') ? "selected": "" }}>Inasistencias</option>
                                 @endif
                             @endif

                             @if (Auth::user()->depClave == "SEC")
                                     @if($MODULO_PAGOS_ACTIVO)
                                         <option value="{{ url('libreta_de_pago') }}" {{ url()->current() ==  url('libreta_de_pago') ? "selected": "" }}>Libreta de pago</option>
                                     @endif
                                     @if ($curso->curEstado == "R")
                                         <option value="{{ url('calificacion_alumno') }}" {{ url()->current() ==  url('calificacion_alumno') ? "selected": "" }}>Calificaciones</option>
                                         <option value="{{ url('secundaria_faltas_alumno') }}" {{ url()->current() ==  url('secundaria_faltas_alumno') ? "selected": "" }}>Faltas</option>
                                     @endif
                             @endif


                             @if (Auth::user()->depClave == "BAC")
                                     @if($MODULO_PAGOS_ACTIVO)
                                         <option value="{{ url('libreta_de_pago') }}" {{ url()->current() ==  url('libreta_de_pago') ? "selected": "" }}>Libreta de pago</option>
                                     @endif
                                     @if ($curso->curEstado == "R")
                                             <option value="{{ url('bachiller_horario_alumno') }}"
                                                 {{ url()->current() ==  url('bachiller_horario_alumno') ? "selected": "" }}>Horario</option>
                                             <option value="{{ url('bachiller_calificacion_alumno') }}"
                                                 {{ url()->current() ==  url('bachiller_calificacion_alumno') ? "selected": "" }}>Calificaciones</option>
                                             @php
                                                 $aluClave = Auth::user()->username;
                                             @endphp
                                             <option value="{{ url('bachiller_solicitudes_recuperativos') }}"
                                                 {{ url()->current() ==  url('bachiller_solicitudes_recuperativos') ? "selected": "" }}>Recuperativos</option>
                                             <option value="{{ url('bachiller_notificar_pago') }}"
                                                 {{ url()->current() ==  url('bachiller_notificar_pago') ? "selected": "" }}>Notificar pago</option>
                                     @endif
                                 @endif
                        --}}


                        <option value="{{ url('logout') }}">Salir</option>

                    </select>

                    @if (Auth::user()->depClave == "SUP" || Auth::user()->depClave == "POS")
                        <span style="font-size: 25px; position: relative; top: 5px; text-align:center; left: 3em;">Universidad Modelo</span>
                    @else
                        <span style="font-size: 25px; position: relative; top: 5px; text-align:center; left: 3em;">Escuela Modelo</span>
                    @endif

                </div>
                <ul class="right hide-on-med-and-down" style="margin-right: 10px;">

                    @if (Auth::user()->depClave == "BAC" && $ubicacion->ubiClave == "CME")
                        @php
                            $periodo = DB::select("SELECT * FROM periodos WHERE id=$curso->periodo_id");

                            if($ubicacion->ubiClave == "CME"){
                                $nombreCarpeta = "CampusCME";
                            }
                            if($ubicacion->ubiClave == "CVA"){
                                $nombreCarpeta = "CampusCVA";
                            }
                            if($ubicacion->ubiClave == "CCH"){
                                $nombreCarpeta = "CampusCCH";
                            }
                            $perAnio = $periodo[0]->perAnio;
                            $perNumero = $periodo[0]->perNumero;
                        @endphp 
                    <li>{{ Auth::user()->nombre }} 

                        @if ($curso->curBachillerFoto != "")
                            @if (file_exists(base_path('storage/app/public/bachiller/cursos/fotos/' . $perAnio.'-'.$perNumero . '/' . $nombreCarpeta .'/'. $curso->curBachillerFoto))) 

                                <a class="right"><img class="materialboxed" style="border-radius:150px; margin-top: 5px;" 
                                    width="40" height="40" 
                                    src="{{url('/bachiller_curso_images/' . $curso->curBachillerFoto . '/' . $perAnio.'-'.$perNumero.'/'.$nombreCarpeta) }}"></a></li>
                            @endif
                        @endif
                       
                    @else
                    <li>{{ Auth::user()->nombre }}</li>
                    @endif
                    

                </ul>

            </div>
        </nav>
    </div>
</header>

<script>
    $(document).ready(function(){
        $('#main').addClass('mainPaddingSidebar');
        $('.sidenav-trigger-show').on('click',function(e){
            e.preventDefault();
            $('#left-sidebar-nav').show('slide');
            $('#main').removeClass('mainPaddingLeft');
            $('#main').addClass('mainPaddingSidebar');
        });
    });
</script>

