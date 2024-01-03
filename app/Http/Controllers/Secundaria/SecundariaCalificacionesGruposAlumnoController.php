<?php

namespace App\Http\Controllers\Secundaria;

use Auth;

use App\Http\Models\Departamento;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Models\Curso;
use App\Http\Models\Secundaria\Secundaria_calendario_calificaciones_docentes;
use App\Http\Models\Secundaria\Secundaria_inscritos;
use Carbon\Carbon;

class SecundariaCalificacionesGruposAlumnoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aluClave = Auth::user()->username;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(15);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(19);
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
        $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select(
            'secundaria_calendario_calificaciones_docentes.*'
        )
            ->where('periodo_id', $curso->periodo_id)
            ->where('plan_id', $curso->plan_id)
            ->whereNull('deleted_at')
            ->whereDate('secundaria_calendario_calificaciones_docentes.calInicioCaptura', '<=',
                $fechaActual->format('Y-m-d'))
            ->whereDate('secundaria_calendario_calificaciones_docentes.calFinRevision', '>=',
                $fechaActual->format('Y-m-d'))
        ->first();


        // retornamos un valor segun la validación de la fecha
        if ($secundaria_calendario_calificaciones_docentes !== null)
        {
            if($fechaActual->format('Y-m-d') >
                $secundaria_calendario_calificaciones_docentes->calFinRevision){
                $validandoFecha = "true";
            }
            else
            {
                $validandoFecha = "false";
            }
        }
        else{
            $validandoFecha = "true";
        }

        $view_show_index = 'secundaria.grupos_alumno.show-index';
        if ($validandoFecha == "true" && $curso->curEstado == "R")
        {
            $view_show_index = 'secundaria.grupos_alumno.show-index';
        }
        else
        {
            $view_show_index = 'secundaria.grupos_alumno.show-message-index';
        }


        return view($view_show_index, [
            'curso' => $curso,
            'validandoFecha' => $validandoFecha
        ]);
    }

    public function list()
    {

        //SECUNDARIA PERIODO ACTUAL (MERIDA Y VALLADOLID)
        $matricula = Auth::user()->username;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(15);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(19);
        $perActualCVA = $departamentoCVA->perActual;


        $inscritos = Secundaria_inscritos::select(
            'secundaria_inscritos.id as inscrito_id',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'secundaria_inscritos.curso_id',
            'secundaria_inscritos.grupo_id',
            'secundaria_grupos.gpoClave',
            'secundaria_grupos.gpoGrado',
            'secundaria_grupos.gpoTurno',
            'secundaria_materias.matNombre',
            'secundaria_grupos.gpoMatComplementaria',
            'planes.planClave',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.progNombre',
            'escuelas.escNombre',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'secundaria_empleados.empApellido1',
            'secundaria_empleados.empApellido2',
            'secundaria_empleados.empNombre',
            'secundaria_inscritos.inscCalificacionSep',
            'secundaria_inscritos.inscCalificacionOct',
            'secundaria_inscritos.inscCalificacionNov',
            'secundaria_inscritos.inscCalificacionEne',
            'secundaria_inscritos.inscCalificacionFeb',
            'secundaria_inscritos.inscCalificacionMar',
            'secundaria_inscritos.inscCalificacionAbr',
            'secundaria_inscritos.inscCalificacionMay',
            'secundaria_inscritos.inscCalificacionJun',
            'secundaria_inscritos.inscTrimestre1',
            'secundaria_inscritos.inscTrimestre2',
            'secundaria_inscritos.inscTrimestre3',
            'secundaria_inscritos.inscPromedioPorMeses',
            'secundaria_grupos.periodo_id',
            'secundaria_grupos.plan_id'
        )
            ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
            ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
            ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
            ->whereIn('periodos.id', [$perActualCME, $perActualCVA])
            ->where('alumnos.aluClave', $matricula)
            //->where('secundaria_materias.matNombre', '!=', 'EDUCACION FISICA VESP')
            ->latest('secundaria_inscritos.created_at');

            // $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::where('periodo_id', $inscritos[0]->periodo_id)->where('plan_id', $inscritos[0]->periodo_id)->first();



        return DataTables::of($inscritos)



            ->filterColumn('nombreCompletoDocente', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empNombre, ' ', empApellido1, ' ', empApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombreCompletoDocente', function ($query) {
                return $query->empNombre . " " . $query->empApellido1 . " " . $query->empApellido2;
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

            ->filterColumn('materiaACD', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoMatComplementaria) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('materiaACD', function ($query) {
                return $query->gpoMatComplementaria;
            })

            ->filterColumn('materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('materia', function ($query) {
                return $query->matNombre;
            })

            ->filterColumn('calificacion_sep', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscCalificacionSep) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('calificacion_sep', function ($query) {

                $fechaActual = Carbon::now('America/Merida');

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'SEPTIEMBRE')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "SEPTIEMBRE" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionSep;
                    }else{
                        return "";
                    }
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

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'OCTUBRE')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "OCTUBRE" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionOct;
                    }else{
                        return "";
                    }
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

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'NOVIEMBRE')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "NOVIEMBRE" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionNov;
                    }else{
                        return "";
                    }
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

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'ENERO')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "ENERO" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionEne;
                    }else{
                        return "";
                    }
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

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'FEBRERO')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "FEBRERO" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionFeb;
                    }else{
                        return "";
                    }
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

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'MARZO')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "MARZO" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionMar;
                    }else{
                        return "";
                    }
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

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'ABRIL')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "ABRIL" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionAbr;
                    }else{
                        return "";
                    }
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

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'MAYO')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "MAYO" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionMay;
                    }else{
                        return "";
                    }
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

                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select('secundaria_calendario_calificaciones_docentes.*',
                'secundaria_mes_evaluaciones.mes')
                ->leftJoin('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $query->periodo_id)
                ->where('plan_id', $query->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', 'JUNIO')
                ->first();

                if($secundaria_calendario_calificaciones_docentes != ""){
                    if($secundaria_calendario_calificaciones_docentes->mes == "JUNIO" && $fechaActual->format('Y-m-d') > $secundaria_calendario_calificaciones_docentes->calFinRevision){
                        return $query->inscCalificacionJun;
                    }else{
                        return "";
                    }
                }else{
                    return "";
                }


            })

            ->make(true);
    }





}
