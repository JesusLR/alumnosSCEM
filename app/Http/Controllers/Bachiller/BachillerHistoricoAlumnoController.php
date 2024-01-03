<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Alumno;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_materias;
use App\Models\Bachiller\Bachiller_resumenacademico;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;


class BachillerHistoricoAlumnoController extends Controller
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
        /*
        $bachiller_historico = Bachiller_historico::select(
            'bachiller_historico.id',
            'bachiller_historico.alumno_id',
            'bachiller_historico.plan_id',
            'bachiller_historico.bachiller_materia_id',
            'bachiller_historico.periodo_id',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histFolio',
            'bachiller_historico.hisActa',
            'bachiller_historico.histLibro',
            'bachiller_historico.histNombreOficial',
            'planes.planClave',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.perAnio',
            'periodos.perNumero',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre'
        )
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            //->where('periodos.perAnio', '>=', 2020)
            ->whereIn('planes.id', [94, 103])
            ->orderBy('bachiller_historico.id', 'DESC')
            ->first();
        dd($bachiller_historico);
        */
        $claveAlumno = (Auth::user()->username);
        $alumno = Alumno::where("aluClave", "=",$claveAlumno)->first();
        $persona = $alumno->persona;
        return view('bachiller.historico_alumno.show-list', [
            "alumno" => $alumno,
            "persona" => $persona
        ]);
    }

    public function list()
    {
        $aluClave = Auth::user()->username;

        $bachiller_historico = Bachiller_historico::select(
            'bachiller_historico.id',
            'bachiller_historico.alumno_id',
            'bachiller_historico.plan_id',
            'bachiller_historico.bachiller_materia_id',
            'bachiller_historico.periodo_id',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histFolio',
            'bachiller_historico.hisActa',
            'bachiller_historico.histLibro',
            'bachiller_historico.histNombreOficial',
            'planes.planClave',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.perAnio',
            'periodos.perNumero',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre'
        )
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->where('alumnos.aluClave', '=', $aluClave)
            ->whereIn('planes.id', [94, 103])
            //->whereRaw("bachiller_materias.matClave not like ?", ["LEX%"])
            ->whereNull('bachiller_materias.matComplementaria')
            ->orderBy('bachiller_historico.id', 'DESC');



        return DataTables::of($bachiller_historico)
            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiNombre;
            })

            ->filterColumn('periodoAnio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodoAnio', function ($query) {
                return $query->perAnio;
            })

            ->filterColumn('periodoNumero', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodoNumero', function ($query) {
                return $query->perNumero;
            })

            ->filterColumn('plan', function ($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('plan', function ($query) {
                return $query->planClave;
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


            ->filterColumn('fecha_examen', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histFechaExamen) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('fecha_examen', function ($query) {

                if($query->histFechaExamen != "0000-00-00"){
                    return Utils::fecha_string($query->histFechaExamen, $query->histFechaExamen);
                }else{
                    return "";
                }

            })

            ->filterColumn('clave_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_pago', function ($query) {

                return $query->aluClave;
            })

            ->filterColumn('perApellido_pat', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('perApellido_pat', function ($query) {
                return $query->perApellido1;
            })


            ->filterColumn('perApellido_mat', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('perApellido_mat', function ($query) {
                return $query->perApellido2;
            })

            ->filterColumn('nombre_al', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_al', function ($query) {

                return $query->perNombre;
            })

            ->filterColumn('periodo_acred', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histPeriodoAcreditacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_acred', function ($query) {
                return $query->histPeriodoAcreditacion;
            })

            ->filterColumn('tipo_acred', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histTipoAcreditacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('tipo_acred', function ($query) {
                return $query->histTipoAcreditacion;
            })

            ->filterColumn('califi', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histCalificacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('califi', function ($query) {
                return $query->histCalificacion;
            })
            ->make(true);
    }


    public function show($id)
    {

        if(Auth::user()->campus_cme == 1){
            $departameto_id = 7;
        }

        if(Auth::user()->campus_cva == 1){
            $departameto_id = 17;
        }

        $periodos = DB::select("SELECT p.* FROM periodos as p
        INNER JOIN departamentos d ON d.id = p.departamento_id
        WHERE p.deleted_at IS NULL
        AND p.perAnio NOT IN (9018, 9017, 9016, 9015, 9014, 9013, 9012, 9011, 9010, 9009)
        AND d.id = $departameto_id
        ORDER BY p.perAnio DESC, p.perNumero DESC");

        $historico = Bachiller_historico::select(
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'planes.planClave',
            'planes.id as plan_id',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histNombreOficial',
            'bachiller_historico.id'
        )
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('bachiller_historico.id', $id)
            ->first();


        return view('bachiller.historico_alumno.show', compact('historico', 'periodos'));
    }



}
