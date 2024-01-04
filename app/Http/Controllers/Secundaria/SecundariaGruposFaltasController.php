<?php

namespace App\Http\Controllers\Secundaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Secundaria\Secundaria_inscritos;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class SecundariaGruposFaltasController extends Controller
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

        $curso = Curso::select('cursos.id', 'cursos.periodo_id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->where('alumnos.aluClave', '=', $aluClave)
        ->whereIn('cursos.periodo_id', [$perActualCME, $perActualCVA])
        ->first();

        return view('secundaria.grupo_faltas_alumno.show-index', [
            'curso' => $curso
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
            'secundaria_inscritos.inscFaltasInjSep',
            'secundaria_inscritos.inscFaltasInjOct',
            'secundaria_inscritos.inscFaltasInjNov',
            'secundaria_inscritos.inscFaltasInjEne',
            'secundaria_inscritos.inscFaltasInjFeb',
            'secundaria_inscritos.inscFaltasInjMar',
            'secundaria_inscritos.inscFaltasInjAbr',
            'secundaria_inscritos.inscFaltasInjMay',
            'secundaria_inscritos.inscFaltasInjJun',
            'secundaria_inscritos.inscTrimestre1',
            'secundaria_inscritos.inscTrimestre2',
            'secundaria_inscritos.inscTrimestre3',
            'secundaria_inscritos.inscPromedioPorMeses'

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
            ->where('secundaria_materias.matNombre', '!=', 'EDUCACION FISICA VESP')
            ->latest('secundaria_inscritos.created_at');




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

            ->filterColumn('inscFaltasInjSep', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjSep) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjSep', function ($query) {
                if($query->inscFaltasInjSep == "" || $query->inscFaltasInjSep == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjSep;
                }
                
            })

            ->filterColumn('inscFaltasInjOct', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjOct) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjOct', function ($query) {
                if($query->inscFaltasInjOct == "" || $query->inscFaltasInjOct == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjOct;
                }
                
            })

            ->filterColumn('inscFaltasInjNov', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjNov) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjNov', function ($query) {
                if($query->inscFaltasInjNov == "" || $query->inscFaltasInjNov == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjNov;
                }
                
            })

            ->filterColumn('inscFaltasInjEne', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjEne) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjEne', function ($query) {
                if($query->inscFaltasInjEne == "" || $query->inscFaltasInjEne == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjEne;
                }
                
            })


            ->filterColumn('inscFaltasInjFeb', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjFeb) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjFeb', function ($query) {
                if($query->inscFaltasInjFeb == "" || $query->inscFaltasInjFeb == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjFeb;
                }
                
            })

            ->filterColumn('inscFaltasInjMar', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjMar) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjMar', function ($query) {
                if($query->inscFaltasInjMar == "" || $query->inscFaltasInjMar == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjMar;
                }
                
            })

            ->filterColumn('inscFaltasInjAbr', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjAbr) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjAbr', function ($query) {
                if($query->inscFaltasInjAbr == "" || $query->inscFaltasInjAbr == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjAbr;
                }
                
            })

            ->filterColumn('inscFaltasInjMay', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjMay) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjMay', function ($query) {
                if($query->inscFaltasInjMay == "" || $query->inscFaltasInjMay == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjMay;
                }
                
            })

            ->filterColumn('inscFaltasInjJun', function ($query, $keyword) {
                $query->whereRaw("CONCAT(inscFaltasInjJun) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('inscFaltasInjJun', function ($query) {
                if($query->inscFaltasInjJun == "" || $query->inscFaltasInjJun == 0){
                    return "";
                }else{
                    return $query->inscFaltasInjJun;
                }
                
            })

            ->addColumn('action', function ($query) {


                return '<a href="secundaria_asignar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="secundaria_asignar_grupo/' . $query->inscrito_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
                </a>
                <form id="delete_' . $query->inscrito_id . '" action="secundaria_asignar_grupo/' . $query->inscrito_id . '" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            })
            ->make(true);
    }

}
