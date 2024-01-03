<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Curso;
use App\Http\Models\Departamento;
use App\Http\Models\Primaria\Primaria_asistencia;
use App\Http\Models\Primaria\Primaria_inscrito;
use App\Http\Models\primaria\primaria_inscritos;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use Carbon\Carbon;

class PrimariaGruposFaltasController extends Controller
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

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(14);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(26);
        $perActualCVA = $departamentoCVA->perActual;


        $curso = Curso::select('cursos.id', 'cursos.periodo_id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->where('alumnos.aluClave', '=', $aluClave)
        ->whereIn('cursos.periodo_id', [$perActualCME, $perActualCVA])
        ->first();

        return view('primaria.grupo_faltas_alumno.show-index', [
            'curso' => $curso
        ]);
    }

    public function list()
    {

        //primaria PERIODO ACTUAL (MERIDA Y VALLADOLID)
        $matricula = Auth::user()->username;

        

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(14);
        $perActualCME = $departamentoCME->perActual;      
        
        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(26);
        $perActualCVA = $departamentoCVA->perActual;

        $curso = Curso::select('cursos.id', 'cursos.periodo_id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->where('alumnos.aluClave', '=', $matricula)
        ->whereIn('cursos.periodo_id', [$perActualCME, $perActualCVA])
        ->first();

        $inscritos = Primaria_asistencia::select(
            'primaria_asistencia.id', 
            'primaria_asistencia.asistencia_inscrito_id',
            'primaria_asistencia.fecha_asistencia',
            'primaria_grupos.gpoGrado',
            'primaria_grupos.gpoClave',
            'primaria_materias.matClave',
            'primaria_materias.matNombre',
            'primaria_materias_asignaturas.matClaveAsignatura',
            'primaria_materias_asignaturas.matNombreAsignatura',
            'primaria_empleados.empApellido1',
            'primaria_empleados.empApellido2',
            'primaria_empleados.empNombre',
            'periodos.perAnioPago'
        )
            ->join('primaria_inscritos', 'primaria_asistencia.asistencia_inscrito_id', '=', 'primaria_inscritos.id')
            ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
            ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
            ->leftJoin('primaria_materias_asignaturas', 'primaria_grupos.primaria_materia_asignatura_id', '=', 'primaria_materias_asignaturas.id')
            ->leftJoin('users_docentes', 'primaria_asistencia.usuario_at', '=', 'users_docentes.id')
            ->leftJoin('primaria_empleados', 'users_docentes.empleado_id', '=', 'primaria_empleados.id')
            ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
            ->whereNull('primaria_inscritos.deleted_at')
            ->whereNull('primaria_asistencia.deleted_at')
            ->where('primaria_asistencia.estado', 'F')
            ->where('primaria_inscritos.curso_id', $curso->id)
            ->orderBy('primaria_asistencia.fecha_asistencia', 'ASC');
           

        return DataTables::of($inscritos)

            ->filterColumn('anio_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('anio_pago', function ($query) {
                return $query->perAnioPago;
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


            ->filterColumn('clave_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_materia', function ($query) {
                return $query->matClave;
            })

            ->filterColumn('nombre_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_materia', function ($query) {
                return $query->matNombre;
            })

            ->filterColumn('clave_asignatura', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matClaveAsignatura) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_asignatura', function ($query) {
                return $query->matClaveAsignatura;
            })

            ->filterColumn('nombre_asignatura', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matNombreAsignatura) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_asignatura', function ($query) {
                return $query->matNombreAsignatura;
            })

            ->filterColumn('nombreCompletoDocente', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empNombre, ' ', empApellido1, ' ', empApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombreCompletoDocente', function ($query) {
                return $query->empNombre . " " . $query->empApellido1 . " " . $query->empApellido2;
            })

            ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("CONCAT(fecha_asistencia) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('fecha', function ($query) {
               
                

                $fecha = \Carbon\Carbon::parse($query->fecha_asistencia)->format('d-m-Y');
                return $fecha;
            })


            ->addColumn('action', function ($query) {


                return '<a href="primaria_asignar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="primaria_asignar_grupo/' . $query->inscrito_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
                </a>
                <form id="delete_' . $query->inscrito_id . '" action="primaria_asignar_grupo/' . $query->inscrito_id . '" method="POST" style="display: inline;">
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
