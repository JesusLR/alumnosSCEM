<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_calendarioexamen;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Curso;
use App\Models\Departamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BachillerCalificacionesYucatan extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('AvanceBac');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if($AVANCE_BAC_CME){
        //     return "hola";
        // }
        $aluClave = Auth::user()->username;
        
        $departamentoCME = Departamento::with('ubicacion')->findOrFail(7);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(17);
        $perActualCVA = $departamentoCVA->perActual;

        $deQueCampuesEs = Curso::select('ubicacion.ubiClave')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('alumnos.aluClave', $aluClave)
        ->whereIn('periodos.id', [$perActualCME, $perActualCVA])
        ->whereNull('cursos.deleted_at')
        ->whereNull('periodos.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->whereNull('ubicacion.deleted_at')
        ->first();

        if($deQueCampuesEs->ubiClave == "CME"){
            $fechaExamen = Bachiller_calendarioexamen::where('periodo_id', $perActualCME)->first();
        }
        if($deQueCampuesEs->ubiClave == "CVA"){
            $fechaExamen = Bachiller_calendarioexamen::where('periodo_id', $perActualCVA)->first();
        }


        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        // validamos si existe registro 
        if($fechaExamen == ""){
            $parametroMostrar = false;
        }else{
            if($fechaActual->format('Y-m-d') >= $fechaExamen->calexInicioOrdinario){
                $parametroMostrar = true;
            }else{
                $parametroMostrar = false;
            }
        }

        


        return view('bachiller.calificaciones_grupo.calificaciones-show', [
            "parametroMostrar" => $parametroMostrar
        ]);
    }

    public function list()
    {
        $matricula = Auth::user()->username;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(7);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(17);
        $perActualCVA = $departamentoCVA->perActual;

        $procInscritosPuntos = DB::select("call procBachillerEvidenciasAcumulado(".$perActualCME.
            ",".$perActualCVA.
            ",".$matricula.")");

        $bachiller_inscritos = Bachiller_inscritos::select(
            'bachiller_inscritos.id',
            'bachiller_inscritos.curso_id',
            'bachiller_inscritos.bachiller_grupo_id',
            'bachiller_inscritos.insCalificacionParcial1',
            'bachiller_inscritos.insFaltasParcial1',
            'bachiller_inscritos.insCalificacionParcial2',
            'bachiller_inscritos.insFaltasParcial2',
            'bachiller_inscritos.insCalificacionParcial3',
            'bachiller_inscritos.insFaltasParcial3',
            'bachiller_inscritos.insCalificacionFinal',
            'bachiller_inscritos.insPromedioParcial',
            'bachiller_inscritos.insPuntosObtenidosCorte1',
            'bachiller_inscritos.insPuntosObtenidosCorte2',
            'bachiller_inscritos.insPuntosObtenidosCorte3',
            'bachiller_inscritos.insPuntosMaximosCorte1',
            'bachiller_inscritos.insPuntosMaximosCorte2',
            'bachiller_inscritos.insPuntosMaximosCorte3',
            'bachiller_inscritos.insPuntosObtenidosAcumulados',
            'bachiller_inscritos.insPuntosMaximosAcumulados',
            DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte1," de ",bachiller_inscritos.insPuntosMaximosCorte1) AS primerCorte'),
            DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte2," de ",bachiller_inscritos.insPuntosMaximosCorte2) AS segundoCorte'),
	        DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte3," de ",bachiller_inscritos.insPuntosMaximosCorte3) AS tercerCorte'),
	        DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosAcumulados," de ",bachiller_inscritos.insPuntosMaximosAcumulados) AS acumuladoCorte'),
            DB::raw('CONCAT(ROUND((bachiller_inscritos.insPuntosObtenidosAcumulados * 100)/bachiller_inscritos.insPuntosMaximosAcumulados, 1),"%") AS acumuladoAprovechamiento'),
            'bachiller_inscritos.insPuntosObtenidosOrdinario',
            'bachiller_inscritos.insPuntosMaximosOrdinario',
            DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosOrdinario," de ",bachiller_inscritos.insPuntosMaximosOrdinario) AS ordinarioCorte'),
            'bachiller_inscritos.insPuntosObtenidosFinal',
            'alumnos.id AS alumno_id',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'bachiller_grupos.gpoClave',
            'bachiller_grupos.gpoGrado',
            'bachiller_grupos.gpoMatComplementaria',
            'bachiller_grupos.bachiller_materia_acd_id',
            'bachiller_grupos.bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'periodos.id as periodo_id',
            'periodos.perAnio',
            'periodos.perNumero',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empNombre'
        )
        ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
        ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->leftJoin('bachiller_materias_acd', 'bachiller_grupos.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
        ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
        ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
        ->where('alumnos.aluClave', $matricula)
        ->whereIn('periodos.id', [$perActualCME, $perActualCVA]);



        return DataTables::of($bachiller_inscritos)


            ->filterColumn('periodo_anio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_anio', function ($query) {
                return $query->perAnio;
            })

            ->filterColumn('grado', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoGrado) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('grado', function ($query) {
                return $query->gpoGrado;
            })

            ->filterColumn('grupo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('grupo', function ($query) {
                return $query->gpoClave;
            })

            ->filterColumn('grupoACD', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoMatComplementaria) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('grupoACD', function ($query) {
                return $query->gpoMatComplementaria;
            })

            ->filterColumn('materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matClave, ' ', matNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('materia', function ($query) {
                return $query->matClave.'-'.$query->matNombre;
            })
            /*
                        ->filterColumn('docente', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(empNombre, ' ', empApellido1, ' ', empApellido2) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('docente', function ($query) {
                            return $query->empNombre . " " . $query->empApellido1 . " " . $query->empApellido2;
                        })


                        ->filterColumn('parcial1', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(insCalificacionParcial1) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('parcial1', function ($query) {
                            return $query->insCalificacionParcial1;
                        })

                        ->filterColumn('parcial2', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(insCalificacionParcial2) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('parcial2', function ($query) {
                            return $query->insCalificacionParcial2;
                        })

                        ->filterColumn('parcial3', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(insCalificacionParcial3) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('parcial3', function ($query) {
                            return $query->insCalificacionParcial3;
                        })


                        ->filterColumn('faltas_parcial1', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(insFaltasParcial1) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('faltas_parcial1', function ($query) {
                            return $query->insFaltasParcial1;
                        })


                        ->filterColumn('faltas_parcial2', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(insFaltasParcial2) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('faltas_parcial2', function ($query) {
                            return $query->insFaltasParcial2;
                        })

                        ->filterColumn('faltas_parcial3', function ($query, $keyword) {
                            $query->whereRaw("CONCAT(insFaltasParcial3) like ?", ["%{$keyword}%"]);
                        })
                        ->addColumn('faltas_parcial3', function ($query) {
                            return $query->insFaltasParcial3;
                        })

           */

            ->addColumn('action', function ($query) {

                $btnVerPuntosEvi = "";

                if($query->bachiller_materia_acd_id != ""){
                    $btnVerPuntosEvi = '<a  href="' . route('bachiller.bachiller_puntos_evidencia_materia_complementaria', ['periodo_id' => $query->periodo_id, 'materia_id' => $query->bachiller_materia_id, 'materia_acd_id' => $query->bachiller_materia_acd_id]) . '" class="button button--icon js-button js-ripple-effect" title="Ver puntos evidencias">
                        <i class="material-icons">visibility</i>
                    </a>';
                }else{
                    $btnVerPuntosEvi = '<a href="' . route('bachiller.bachiller_puntos_evidencia_materia', ['periodo_id' => $query->periodo_id, 'materia_id' => $query->bachiller_materia_id]) . '" class="button button--icon js-button js-ripple-effect" title="Ver puntos evidencias">
                        <i class="material-icons">visibility</i>
                    </a>';
                }

                return $btnVerPuntosEvi;
            })
            ->make(true);
    }


}