<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Auth;
use URL;
use Debugbar;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Periodo;
use App\Models\Ubicacion;
use App\Http\Helpers\Utils;
use App\clases\alumnos\MetodosAlumnos;
use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_calendarioexamen;
use App\Models\Bachiller\Bachiller_cch_calificaciones;
use App\Models\Bachiller\Bachiller_cch_inscritos;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_extraordinarios;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Bachiller\Bachiller_inscritosextraordinarios;
use App\Models\Bachiller\Bachiller_resumenacademico;
use App\Models\ConceptoPago;
use Validator;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Luecano\NumeroALetras\NumeroALetras;
use Yajra\DataTables\Facades\DataTables;
//use DB;


class BachillerExtraordinarioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dateDMY($date){
        $a = null;
        if($date){
            $a = Carbon::parse($date)->format('d/m/Y');
        }
        return $a;
    } //FIN function dateDMY.

    public function updateNumInscritosExtra($extra){
        /*
        * Busca a los inscritos en el extraordinario. los cuenta y actualiza
        * el campo de "extAlumnosInscritos".
        */
        $extraUpdated = false;
        $inscritos = $extra->bachiller_inscritos()->where('iexEstado','<>','C')->count();
        DB::beginTransaction();
        try {
            $extra->extAlumnosInscritos = $inscritos;
            if($extra->save()){
                $extraUpdated = true;
            }

        } catch (QueryException $e) {
            DB::rollback();
        }
        DB::commit();
        return $extraUpdated;
    }//updateNumInscritosExtra.

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bachiller.extraordinario.show-list');
    }

    /**
     * Show list.
     *
     */
    public function list()
    {
        $extraordinarios = Bachiller_extraordinarios::select(
            'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extAlumnosInscritos',
            'bachiller_extraordinarios.extPago','bachiller_extraordinarios.extFecha','bachiller_extraordinarios.extHora',
            'periodos.perNumero','periodos.perAnio','bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_empleados.empNombre as perNombre','bachiller_empleados.empApellido1 as perApellido1','bachiller_empleados.empApellido2 as perApellido2','planes.planClave',
            'programas.progClave','ubicacion.ubiClave', 'empleadoAux.empApellido1', 'empleadoAux.empApellido2', 'empleadoAux.empNombre')
            ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
            ->join('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
            ->leftJoin('bachiller_empleados as empleadoAux', 'bachiller_extraordinarios.bachiller_empleado_sinodal_id', '=', 'empleadoAux.id');

            // ->leftjoin('optativas','bachiller_extraordinarios.optativa_id','optativas.id');

        return Datatables::of($extraordinarios)
            ->filterColumn('nombreCompleto',function($query, $keyword) {
                return $query->whereHas('empleado.persona', function($query) use($keyword) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
            })

            ->filterColumn('fecha_extra',function($query, $keyword) {
                $query->whereRaw("CONCAT(extFecha) like ?", ["%{$keyword}%"]);

            })
            ->addColumn('fecha_extra',function($query) {
                $dia = \Carbon\Carbon::parse($query->extFecha)->format('d');
                $year = \Carbon\Carbon::parse($query->extFecha)->format('Y');
                $mes = \Carbon\Carbon::parse($query->extFecha)->format('m');
                $mesCorto = Utils::num_meses_corto_string($mes);
                return $dia.'-'.$mesCorto.'-'.$year;
            })
            ->addColumn('action',function($query) {
                return '<a href="bachiller_recuperativos/' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="/bachiller_calificacion/agregarextra/'
                . $query->extraordinario_id
                . '" class="button button--icon js-button js-ripple-effect" title="Calificaciones">
                    <i class="material-icons">assignment_turned_in</i>
                </a>
                <form class="form-acta-examen'.$query->extraordinario_id.'" target="_blank" action="bachiller_recuperativos/actaexamen/'.$query->extraordinario_id.'" method="POST" style="display: inline;">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <a href="#" data-id="'.$query->extraordinario_id.'" class="button button--icon js-button js-ripple-effect confirm-acta-examen" title="Acta de examen extraordinario">
                        <i class="material-icons">assignment</i>
                    </a>
                </form>
                <a href="bachiller_recuperativos/' . $query->extraordinario_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>

                <a href="bachiller_recuperativos/' . $query->extraordinario_id . '/edit_docente" class="button button--icon js-button js-ripple-effect" title="Editar docente">
                    <i class="material-icons">people</i>
                </a>
                <form id="delete_' . $query->extraordinario_id . '" action="bachiller_recuperativos/' . $query->extraordinario_id . '" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            })
        ->make(true);
    }


    public function getAlumnosByFolioExtraordinario(Request $request, $extraordinario_id)
    {

        $extraordinario = Bachiller_extraordinarios::with(
            'bachiller_empleado', 'bachiller_empleadoSinodal', 'periodo',
            'bachiller_materia.plan.programa.escuela.departamento.ubicacion')
        ->findOrFail($extraordinario_id);

        $inscritos = Bachiller_resumenacademico::with('alumno.persona')
            ->where('plan_id',$extraordinario->bachiller_materia->plan->id)
            ->get();


        return response()->json($inscritos);
    }


    /**
     * Show extraordinario.
     *
     */
    public function getExtraordinario(Request $request, $extraordinario_id)
    {
        if ($request->ajax()) {
            $extraordinario = Bachiller_extraordinarios::with(
                'bachiller_empleado', 'bachiller_empleadoSinodal', 'periodo',
                'bachiller_materia.plan.programa.escuela.departamento.ubicacion')
            ->find($extraordinario_id);

            return response()->json($extraordinario);
        }
    }



    /**
     * Show list_solicitudes.
     *
     */
    public function list_solicitudes()
    {

        $claveAlumno = (Auth::user()->username);

        $inscritosextraordinarios = Bachiller_inscritosextraordinarios::select(
            'bachiller_inscritosextraordinarios.id as inscritoExtraordinario_id','bachiller_inscritosextraordinarios.iexFecha',
            'bachiller_inscritosextraordinarios.iexCalificacion','bachiller_inscritosextraordinarios.iexEstado',
            'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extFecha as extFecha','bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','planes.planClave',
            'alumnos.aluClave', 'periodos.perNumero','periodos.perAnio','programas.progClave','ubicacion.ubiClave')
            ->join('bachiller_extraordinarios', 'bachiller_inscritosextraordinarios.extraordinario_id', '=', 'bachiller_extraordinarios.id')
            ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
            ->join('alumnos', 'bachiller_inscritosextraordinarios.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            // ->leftjoin('optativas','extraordinarios.optativa_id','optativas.id');
            ->where('alumnos.aluClave', '=', $claveAlumno)
            ->where('bachiller_inscritosextraordinarios.iexEstado', '<>', 'C')
            ->whereNull('bachiller_inscritosextraordinarios.deleted_at');

        return Datatables::of($inscritosextraordinarios)
            ->filterColumn('nombre_alumno',function($query,$keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_alumno',function($query) {
                return $query->perNombre;
            })

            ->filterColumn('apellido1',function($query,$keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido1',function($query) {
                return $query->perApellido1;
            })

            ->filterColumn('apellido2',function($query,$keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido2',function($query) {
                return $query->perApellido2;
            })

            ->filterColumn('estadodepago',function($query,$keyword) {
                $query->whereRaw("CONCAT(iexEstado) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('estadodepago',function($query) {
                if($query->iexEstado == "P"){
                    return "PAGADO";
                }
                if($query->iexEstado == "N"){
                    return "PAGO PENDIENTE";
                }
                if($query->iexEstado == "C"){
                    return "CANCELADO";
                }
            })
            ->addColumn('action',function($query) {


                return '';
            })


        ->make(true);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudes()
    {
        return view('bachiller.extraordinario.show-solicitudes-list');
    }


    public function fecha_general_index()
    {
        $conceptosPago = ConceptoPago::whereNotIn('conpClave', ['90', '91', '92', '93', '94', '95', '96', '97', '98'])
            ->orderBy('conpClave')->get();

        $conceptosReferencia=  DB::select("SELECT * FROM conceptosreferenciaubicacion WHERE depClave is not null");

        return view('bachiller.extraordinario.ficha_general.create', [
            "conceptosPago" => $conceptosPago,
            "conceptosReferencia" => $conceptosReferencia,
        ]);
    }

    public function getDebeRecuperativos(Request $request,$aluClave, $perAnioPago, $perNumero)
    {
        if ($request->ajax()) {
            $inscritosextraordinarios = Bachiller_inscritosextraordinarios::select(
                'bachiller_inscritosextraordinarios.id','bachiller_inscritosextraordinarios.iexFecha',
                'bachiller_inscritosextraordinarios.iexCalificacion','bachiller_inscritosextraordinarios.iexEstado',
                'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extFecha as extFecha',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre as matNombre',
                'personas.perNombre','personas.perApellido1','personas.perApellido2','planes.planClave',
                'alumnos.aluClave', 'periodos.perNumero','periodos.perAnio','programas.progClave','ubicacion.ubiClave', 'bachiller_extraordinarios.extPago')
                ->join('bachiller_extraordinarios', 'bachiller_inscritosextraordinarios.extraordinario_id', '=', 'bachiller_extraordinarios.id')
                ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
                ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
                ->join('alumnos', 'bachiller_inscritosextraordinarios.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->where('alumnos.aluClave', '=', $aluClave)
                ->where('periodos.perAnio', '=', $perAnioPago)
                ->where('periodos.perNumero', '=', $perNumero)
                ->where('bachiller_inscritosextraordinarios.iexEstado', '!=', "C")
                ->whereNull('bachiller_inscritosextraordinarios.deleted_at')
                ->get();


            return response()->json($inscritosextraordinarios);
        }
    }







    //SOLICITUDES EXTRAORDINARIO



        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudCreate()
    {
        return view('bachiller.extraordinario.create-solicitud');
    }


}
