<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Primaria\Primaria_calendario_calificaciones_docentes;
use App\Models\Primaria\Primaria_inscrito;
use Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class PrimariaCalificacionesGruposAlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aluClave = Auth::user()->username;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(14);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(26);
        $perActualCVA = $departamentoCVA->perActual;

        $curso = Curso::select('cursos.id', 'cursos.periodo_id', 'cgt.plan_id', 'cursos.curEstado')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->where('alumnos.aluClave', '=', $aluClave)
            ->whereIn('cursos.periodo_id', [$perActualCME, $perActualCVA])
            ->first();


        // Validando mes actual
        $fechaActual = Carbon::now('America/Merida');

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $MES = $fechaActual->format('m');
        $mesActual = "SEPTIEMBRE";
        $mesAnterior = "SEPTIEMBRE";
        if($MES == "09"){
            $mesActual = "SEPTIEMBRE";
        }
        if($MES == "10"){
            $mesActual = "OCTUBRE";
            $mesAnterior = "SEPTIEMBRE";
        }
        if($MES == "11"){
            $mesActual = "NOVIEMBRE";
            $mesAnterior = "OCTUBRE";
        }
        if($MES == "12"){
            $mesActual = "DICIEMBRE";
            $mesAnterior = "NOVIEMBRE";
        }
        if($MES == "01"){
            $mesActual = "ENERO";
            $mesAnterior = "NOVIEMBRE";
        }
        if($MES == "02"){
            $mesActual = "FEBRERO";
            $mesAnterior = "ENERO";
        }
        if($MES == "03"){
            $mesActual = "MARZO";
            $mesAnterior = "FEBRERO";
        }
        if($MES == "04"){
            $mesActual = "ABRIL";
            $mesAnterior = "MARZO";
        }
        if($MES == "05"){
            $mesActual = "MAYO";
            $mesAnterior = "ABRIL";
        }
        if($MES == "06"){
            $mesActual = "JUNIO";
            $mesAnterior = "MAYO";
        }

        // Aqui consultamos el mes correspondiente
        $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select(
            'primaria_calendario_calificaciones_docentes.*'
        )
        ->where('periodo_id', $curso->periodo_id)
        ->where('plan_id', $curso->plan_id)
        ->whereNull('deleted_at')
        ->whereDate('primaria_calendario_calificaciones_docentes.calInicioCaptura', '<=',
            $fechaActual->format('Y-m-d'))
        ->whereDate('primaria_calendario_calificaciones_docentes.calFinRevision', '>=',
        $fechaActual->format('Y-m-d'))
        ->first();

        /*
        dd($curso->plan_id,
            $curso->periodo_id,
            $mesActual,
            $mesAnterior,
            $primaria_calendario_calificaciones_docentes == null,
            $primaria_calendario_calificaciones_docentes->calFinRevision,
            $fechaActual->format('Y-m-d'));
        */


        if ($primaria_calendario_calificaciones_docentes !== null)
        {
            $ultimoDiaDeRevision = $primaria_calendario_calificaciones_docentes->calFinRevision;
            if($fechaActual->format('Y-m-d') >
                $primaria_calendario_calificaciones_docentes->calFinRevision){
                $validandoFecha = "true";
            }
            else
            {
                $validandoFecha = "false";
            }
        }
        else{
            $validandoFecha = "true";
            $ultimoDiaDeRevision = "";
        }


        /*
         * PARA IMPRIMIR SOLO UN MES DE LA BOLETA ,HABRIA QUE CREAR UN NUEVO SP QUE ACEPTE EL NUMERO DE MES QUE DESEAS CALCULAR
         * */
        /*
        // retornamos un valor segun la validación de la fecha DEL MES ACTUAL
        if($fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
            $validandoFecha = "true";
        }else{
            if ($mesActual != $mesAnterior )
            {
                // Aqui consultamos el mes anterior
                $primaria_calendario_calificaciones_docentes_anterior = Primaria_calendario_calificaciones_docentes::select(
                    'primaria_calendario_calificaciones_docentes.*',
                    'primaria_mes_evaluaciones.mes'
                )
                ->leftJoin('primaria_mes_evaluaciones',
                    'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $curso->periodo_id)
                ->where('plan_id', $curso->plan_id)
                ->where('primaria_mes_evaluaciones.mes', $mesAnterior)
                ->first();
                // retornamos un valor segun la validación de la fecha DEL MES ANTERIOR
                if($fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes_anterior->calFinRevision){
                    $validandoFecha = "verdadero";
                }
                else
                {
                    $validandoFecha = "false";
                }

            }
            else
            {
                $validandoFecha = "false";
            }

        }
        */

        /*
        dd($curso->plan_id, $curso->periodo_id, $mesActual, $mesAnterior,
            $primaria_calendario_calificaciones_docentes->calFinRevision,
            $fechaActual->format('Y-m-d'),
            $validandoFecha,
            $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision);
        */


        return view('primaria.grupos_alumno.show-index', [
            'curso' => $curso,
            'validandoFecha' => $validandoFecha,
            'mesActual' => $mesActual,
            'ultimoDiaDeRevision' => $ultimoDiaDeRevision
        ]);
    }

    public function list()
    {
        //primaria PERIODO ACTUAL (MERIDA)
        $matricula = Auth::user()->username;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(14);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(26);
        $perActualCVA = $departamentoCVA->perActual;

        $inscritos = Primaria_inscrito::select(
            'primaria_inscritos.id as inscrito_id',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'primaria_inscritos.curso_id',
            'primaria_inscritos.primaria_grupo_id',
            'primaria_grupos.gpoClave',
            'primaria_grupos.gpoGrado',
            'primaria_grupos.gpoTurno',
            'primaria_grupos.gpoMatComplementaria',
            'primaria_materias.matNombre',
            'planes.planClave',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.progNombre',
            'escuelas.escNombre',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'primaria_materias_asignaturas.matClaveAsignatura',
            'primaria_materias_asignaturas.matNombreAsignatura',
            'primaria_inscritos.inscCalificacionSep',
            'primaria_inscritos.inscCalificacionOct',
            'primaria_inscritos.inscCalificacionNov',
            'primaria_inscritos.inscCalificacionEne',
            'primaria_inscritos.inscCalificacionFeb',
            'primaria_inscritos.inscCalificacionMar',
            'primaria_inscritos.inscCalificacionAbr',
            'primaria_inscritos.inscCalificacionMay',
            'primaria_inscritos.inscCalificacionJun',
            'primaria_inscritos.inscPromedioMes',
            'primaria_grupos.periodo_id',
            'primaria_grupos.plan_id'
        )
        ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
        ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
        ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('planes', 'primaria_materias.plan_id', '=', 'planes.id')
        ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('primaria_materias_asignaturas', 'primaria_grupos.primaria_materia_asignatura_id', '=', 'primaria_materias_asignaturas.id')
        ->whereIn('periodos.id', [$perActualCME, $perActualCVA])
        ->where('alumnos.aluClave', $matricula)
        ->where('cursos.curEstado', "R")
        ->latest('primaria_inscritos.created_at');

        //dd($inscritos);



        return DataTables::of($inscritos)
            ->filterColumn('nombreCompleto',function($query,$keyword) {
                return $query->whereHas('curso.alumno.persona', function($query) use($keyword) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
            })


            ->filterColumn('calificacion_sep', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionSep) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_sep', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select(
                    'primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones',
                    'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'SEPTIEMBRE')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "SEPTIEMBRE"
                    && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionSep;
                }else{
                    return "";
                }

            })


            ->filterColumn('calificacion_oct', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionOct) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_oct', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'OCTUBRE')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "OCTUBRE"
                    && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionOct;
                }else{
                    return "";
                }

            })


            ->filterColumn('calificacion_nov', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionNov) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_nov', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'NOVIEMBRE')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "NOVIEMBRE" && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionNov;
                }else{
                    return "";
                }

            })

            ->filterColumn('calificacion_ene', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionEne) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_ene', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'ENERO')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "ENERO" && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionEne;
                }else{
                    return "";
                }

            })


            ->filterColumn('calificacion_feb', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionFeb) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_feb', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'FEBRERO')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "FEBRERO" && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionFeb;
                }else{
                    return "";
                }

            })


            ->filterColumn('calificacion_mar', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionMar) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_mar', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'MARZO')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "MARZO" && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionMar;
                }else{
                    return "";
                }

            })

            ->filterColumn('calificacion_abr', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionAbr) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_abr', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'ABRIL')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "ABRIL" && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionAbr;
                }else{
                    return "";
                }

            })

            ->filterColumn('calificacion_may', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionMay) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_may', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'MAYO')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "MAYO" && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionMay;
                }else{
                    return "";
                }

            })

            ->filterColumn('calificacion_jun', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionJun) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_jun', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->leftJoin('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('primaria_mes_evaluaciones.mes', 'JUNIO')
                ->first();

                if($primaria_calendario_calificaciones_docentes->mes == "JUNIO" && $fechaActual->format('Y-m-d') > $primaria_calendario_calificaciones_docentes->calFinRevision){
                    return $query->inscCalificacionJun;
                }else{
                    return "";
                }

            })


        ->make(true);
    }
}
