<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Bachiller\Bachiller_inscritos_evidencias;
use App\Http\Models\Departamento;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BachillerPuntosEvidenciasController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($periodo_id, $materia_id, $materia_acd_id = null)
    {
        if($materia_acd_id != ""){
            $es_complementaria = $materia_acd_id;
        }else{
            $es_complementaria = "no_es_complementaria";
        }
        return view('bachiller.puntos_evidencias.puntos-evidencias-show', [
            "materia_id" => $materia_id,
            "es_complementaria" => $es_complementaria,
            "periodo_id" => $periodo_id
         ]);
    }

    public function list($materia_id, $materia_acd_id = null)
    {
        $aluClave = Auth::user()->username;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(7);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(17);
        $perActualCVA = $departamentoCVA->perActual;

        if($materia_acd_id != "materia"){
            $bachiller_inscritos_evidencias = Bachiller_inscritos_evidencias::select(
                'bachiller_inscritos_evidencias.id',
                'bachiller_inscritos_evidencias.bachiller_inscrito_id',
                'bachiller_inscritos_evidencias.ievPuntos',
                'bachiller_inscritos_evidencias.ievFaltas',
                'bachiller_evidencias.eviNumero',
                'bachiller_evidencias.eviPuntos',
                'bachiller_evidencias.eviDescripcion',
                'bachiller_materias.matNombre',
                'bachiller_materias.matClave',
                'bachiller_grupos.gpoMatComplementaria',
                'bachiller_grupos.bachiller_materia_id',
                'bachiller_grupos.bachiller_materia_acd_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'bachiller_grupos.gpoGrado',
                'bachiller_grupos.gpoClave',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'planes.planClave',
                'programas.progClave',
                'programas.progNombre',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre'
            )
            ->join('bachiller_evidencias', 'bachiller_inscritos_evidencias.evidencia_id', '=', 'bachiller_evidencias.id')
            ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_evidencias.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->join('bachiller_inscritos', 'bachiller_inscritos_evidencias.bachiller_inscrito_id', '=', 'bachiller_inscritos.id')
            ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
            ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
            ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('alumnos.aluClave', $aluClave)
            ->whereIn('periodos.id', [$perActualCME, $perActualCVA])
            ->where('bachiller_grupos.bachiller_materia_id', $materia_id)
            ->where('bachiller_grupos.bachiller_materia_acd_id', $materia_acd_id)
            ->whereNotNull('bachiller_inscritos_evidencias.ievPuntos')
            ->whereNull('cursos.deleted_at')
            ->whereNull('bachiller_inscritos_evidencias.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('bachiller_grupos.deleted_at')
            ->whereNull('bachiller_inscritos.deleted_at')
            ->whereNull('bachiller_evidencias.deleted_at')
            ->orderBy('bachiller_materias.matNombre', 'ASC')
            ->orderBy('bachiller_grupos.gpoMatComplementaria', 'ASC')
            ->orderBy('bachiller_evidencias.eviNumero', 'ASC');
        }else{
            $bachiller_inscritos_evidencias = Bachiller_inscritos_evidencias::select(
                'bachiller_inscritos_evidencias.id',
                'bachiller_inscritos_evidencias.bachiller_inscrito_id',
                'bachiller_inscritos_evidencias.ievPuntos',
                'bachiller_inscritos_evidencias.ievFaltas',
                'bachiller_evidencias.eviNumero',
                'bachiller_evidencias.eviPuntos',
                'bachiller_evidencias.eviDescripcion',
                'bachiller_materias.matNombre',
                'bachiller_materias.matClave',
                'bachiller_grupos.gpoMatComplementaria',
                'bachiller_grupos.bachiller_materia_id',
                'bachiller_grupos.bachiller_materia_acd_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'bachiller_grupos.gpoGrado',
                'bachiller_grupos.gpoClave',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'planes.planClave',
                'programas.progClave',
                'programas.progNombre',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre'
            )
            ->join('bachiller_evidencias', 'bachiller_inscritos_evidencias.evidencia_id', '=', 'bachiller_evidencias.id')
            ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_evidencias.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->join('bachiller_inscritos', 'bachiller_inscritos_evidencias.bachiller_inscrito_id', '=', 'bachiller_inscritos.id')
            ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
            ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
            ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('alumnos.aluClave', $aluClave)
            ->whereIn('periodos.id', [$perActualCME, $perActualCVA])
            ->where('bachiller_grupos.bachiller_materia_id', $materia_id)
            ->whereNotNull('bachiller_inscritos_evidencias.ievPuntos')
            ->whereNull('cursos.deleted_at')
            ->whereNull('bachiller_inscritos_evidencias.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('bachiller_grupos.deleted_at')
            ->whereNull('bachiller_inscritos.deleted_at')
            ->whereNull('bachiller_evidencias.deleted_at')
            ->orderBy('bachiller_materias.matNombre', 'ASC')
            ->orderBy('bachiller_grupos.gpoMatComplementaria', 'ASC')
            ->orderBy('bachiller_evidencias.eviNumero', 'ASC');
        }


        return DataTables::of($bachiller_inscritos_evidencias)


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


            /*
            ->filterColumn('materia_complementaria', function ($query, $keyword) {
                $query->whereRaw("CONCAT(bachiller_grupos.gpoMatComplementaria) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('materia_complementaria', function ($query) {
                if($query->gpoMatComplementaria != ""){
                    return $query->gpoMatComplementaria;
                }else{
                    return "";
                }

            })
            */


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
            */

            ->filterColumn('puntos_maximos', function ($query, $keyword) {
                $query->whereRaw("CONCAT(bachiller_evidencias.eviPuntos) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('puntos_maximos', function ($query) {
                return $query->eviPuntos;
            })

            ->filterColumn('puntos_maximos', function ($query, $keyword) {
                $query->whereRaw("CONCAT(bachiller_evidencias.eviPuntos) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('puntos_maximos', function ($query) {
                return $query->eviPuntos;
            })

            ->filterColumn('numero_evidencia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(eviNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('numero_evidencia', function ($query) {
                return $query->eviNumero;
            })

            ->filterColumn('puntos_obtenedios', function ($query, $keyword) {
                $query->whereRaw("CONCAT(bachiller_inscritos_evidencias.ievPuntos) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('puntos_obtenedios', function ($query) {
                return $query->ievPuntos;
            })
            ->make(true);
    }

}
