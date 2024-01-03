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
use App\Models\Departamento;
use App\Http\Helpers\Utils;
use App\clases\alumnos\MetodosAlumnos;
use App\clases\pagosExtrasBahiller\MetodosPagoExtras;
use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_calendarioexamen;
use App\Models\Bachiller\Bachiller_cch_calificaciones;
use App\Models\Bachiller\Bachiller_cch_inscritos;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_extraordinarios;
use App\Models\Bachiller\Bachiller_fechas_regularizacion;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Bachiller\Bachiller_inscritosextraordinarios;
use App\Models\Bachiller\Bachiller_materias;
use App\Models\Bachiller\Bachiller_resumenacademico;
use App\Models\ConceptoPago;
use Validator;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Luecano\NumeroALetras\NumeroALetras;
use Yajra\DataTables\Facades\DataTables;
//use DB;


class BachillerRecuperativosController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('extrasBac');

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
        return view('bachiller.recuperativos.show-list');
    }

    /**
     * Show list.
     *
     */
    public function list()
    {
        $claveAlumno = (Auth::user()->username);

        $results = DB::select(DB::raw("SELECT
        aluClave AS 'clave_pago',
        alumnos.id AS 'alumnos_id',
        alumnos.aluEstado,
        personas.id AS 'persona_id',
        cursos.id as 'cursos_id',
        cursos.curPlanPago,
        cursos.curEstado,
        ubicacion.ubiClave as 'ubicacion',
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
        AND aluClave = $claveAlumno
        AND curEstado in ('R', 'A', 'C', 'P')
        AND periodos.id IN (
        SELECT
            perActual
        FROM
            departamentos
        WHERE
            depClave IN ('BAC')
        );"));
        $result = collect($results)->first();


        $procBachillerExtraordinariosReprobadasAlumno = DB::select("call procBachillerExtraordinariosReprobadasAlumno(".$claveAlumno.",".$result->periodo_id.")");

        return DataTables::of($procBachillerExtraordinariosReprobadasAlumno)
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
            })
            ->addColumn('horario',function($query) {
                $minInicio = $query->minutoInicio == 0 ? '00' : $query->minutoInicio;
                $minFin = $query->minutoFin == 0 ? '00' : $query->minutoFin;
                return $query->horaInicio . ":$minInicio hrs - " . $query->horaFin . ":$minFin hrs";
            })
            ->addColumn('fecha_extra',function($query) {
                $dia = \Carbon\Carbon::parse($query->extFecha)->format('d');
                $year = \Carbon\Carbon::parse($query->extFecha)->format('Y');
                $mes = \Carbon\Carbon::parse($query->extFecha)->format('m');
                $mesCorto = Utils::num_meses_corto_string($mes);
                return $dia.'-'.$mesCorto.'-'.$year;
            })
            ->addColumn('action',function($query) use ($result) {

                $ubiClave = $query->ubiClave;

                if($ubiClave == "CME"){
                    $departamento = Departamento::find(7);
                    $periodo = Periodo::find($departamento->perActual);
                    $perNumero = $periodo->perNumero;
                    $perAnio = $periodo->perAnio;
                }

                if($ubiClave == "CVA"){
                    $departamento = Departamento::find(17);
                    $periodo = Periodo::find($departamento->perActual);
                    $perNumero = $periodo->perNumero;
                    $perAnio = $periodo->perAnio;
                }

                // valida si el alumno ya esta inscrito
                $alumno = Alumno::where('aluClave', Auth::user()->username)->first();
                $alumno_id = $alumno->id;
                $alumnoYaInscrito = Bachiller_inscritosextraordinarios::where('alumno_id', $alumno_id)
                ->where('extraordinario_id', '=', $query->extraordinario_id)
                ->where('iexEstado', '!=', 'C')
                ->get();

                // if($perNumero == $query->perNumero){

                // }

                if($perNumero == $query->perNumero || $perAnio == $query->perAnio){
                    if($query->extTipo =="RECURSAMIENTO"){

                        if($alumnoYaInscrito->isNotEmpty()) {
                            $btnGenraReciboPdf = '<a href="api/bachiller_recuperativos/generar/' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect" title="Generar">
                                <i class="material-icons">description</i>
                            </a>';
                        } else {
    
                            if($query->extAlumnosInscritos < $query->frMaximoRecursamiento){
                                $btnGenraReciboPdf = '<form id="generar_solicitud_' . $query->extraordinario_id . '" action="api/bachiller_recuperativos/solicitar/' . $query->extraordinario_id.'/'.$result->periodo_id.'/'.$query->bachiller_materia_id.'" method="POST" target="_blank" style="display: inline;">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="matCreditos" value="' . $query->matCreditos . '">
                                    <a href="#" data-id="' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect btn-generar-solicitud" title="Generar solicitud extraordinario">
                                        <i class="material-icons">offline_pin</i>
                                    </a>
                                </form>';
                            }else{
                                $btnGenraReciboPdf = '<div title="No hay cupo disponible"><i style="color: red" class="material-icons">close</i></div>';
                            }
    
                            
                        }
    
                        
    
                    }else{
    
                        if($alumnoYaInscrito->isNotEmpty()) {
                            $btnGenraReciboPdf = '<a href="api/bachiller_recuperativos/generar/' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect" title="Generar">
                                <i class="material-icons">description</i>
                            </a>';
                        } else {
    
                            if($query->extAlumnosInscritos < $query->frMaximoAcomp){
                                $btnGenraReciboPdf = '<form id="generar_solicitud_' . $query->extraordinario_id . '" action="api/bachiller_recuperativos/solicitar/' . $query->extraordinario_id.'/'.$result->periodo_id.'/'.$query->bachiller_materia_id.'" method="POST" target="_blank" style="display: inline;">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="matCreditos" value="' . $query->matCreditos . '">
                                <a href="#" data-id="' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect btn-generar-solicitud" title="Generar solicitud extraordinario">
                                    <i class="material-icons">offline_pin</i>
                                </a>
                                </form>';
                            }else{
                                $btnGenraReciboPdf = '<div title="No hay cupo disponible"><i style="color: red" class="material-icons">close</i></div>';
                            }
                            
                        }
                        
                        
                    }
                    
                    
    
                    // return '<a href="bachiller_recuperativos/' . $query->extraordinario_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    //     <i class="material-icons">visibility</i>
                    //  </a>'.$btnGenraReciboPdf;
    
                    return $btnGenraReciboPdf;
                }

                
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

    public function validarAlumnoPresentaExtra(Request $request)
    {
        $alumno = Alumno::findOrFail($request->alumno);
        $puedePresentarExtra = true;
        $msg = null;
        $extraordinario = Bachiller_extraordinarios::with('bachiller_materia')
            ->where("id", "=", $request->folioExt)
        ->first();

        $periodo = Periodo::findOrFail($extraordinario->periodo_id);

        $materia = $extraordinario->bachiller_materia;
        // $plan = $materia->plan;

        $boolRevisarPagos = true;

        $materias_reprobadas = MetodosAlumnos::bachiller_materias_reprobadas($alumno->aluClave);

        //dd($materia->id, $alumno->aluClave);

        if(!$materias_reprobadas->contains('bachiller_materia_id', $materia->id)) {
            $puedePresentarExtra = false;
            $msg = "El alumno no tiene reprobada la materia";
        }

        if ($boolRevisarPagos)
        {
            //validando que no sea DEUDOR, si no hay que mandarlo con Francisco Lopez.
            if(MetodosAlumnos::esDeudorBachillerCOVID($alumno->aluClave, $periodo->perAnioPago)) {
                $puedePresentarExtra = false;
                $msg = $msg . "\n- El alumno tiene una deuda de pago con la Escuela. Favor de remitirlo con el Lic. Francisco Lopez.";
            }
        }


        $extras_alumno = Bachiller_inscritosextraordinarios::where('alumno_id', $alumno->id)->get();

        //El alumno está inscrito a un extra con la misma fecha.
        $fechaOcupada = $extras_alumno->where('iexFecha', '=', $extraordinario->extFecha);

        //El alumno ya está inscrito a un extra con esta materia
        $ya_esta_inscrito_a_materia = $extras_alumno->where('extraordinario_id', $extraordinario->id)->first();
        if($fechaOcupada->isNotEmpty() || $ya_esta_inscrito_a_materia) {
            $puedePresentarExtra = false;
            $msg = $msg . "\n- El alumno ya tiene un examen para esta misma fecha o ya está inscrito a este extraordinario.";
        }



        return response()->json([
            "puedePresentarExtra" => $puedePresentarExtra,
            "msg" => $msg,
            //"materia_id" => $materia->id,
            //"materias" => $materias_reprobadas
        ]);
    }

    /**
     * Show list_solicitudes.
     *
     */
    public function list_solicitudes()
    {
        $inscritosextraordinarios = Bachiller_inscritosextraordinarios::select(
            'bachiller_inscritosextraordinarios.id as inscritoExtraordinario_id','bachiller_inscritosextraordinarios.iexFecha',
            'bachiller_inscritosextraordinarios.iexCalificacion','bachiller_inscritosextraordinarios.iexEstado', 'bachiller_inscritosextraordinarios.iexTipoPago',
            'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extFecha as extFecha','bachiller_materias.matClave',
            'bachiller_materias.matNombre', 'bachiller_materias.matSemestre',
            'personas.perNombre','personas.perApellido1','personas.perApellido2','planes.planClave',
            'alumnos.aluClave', 'periodos.perNumero','periodos.perAnio','periodos.perAnioPago','programas.progClave','ubicacion.ubiClave')
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
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id');
            // ->leftjoin('optativas','extraordinarios.optativa_id','optativas.id');
            //->where('iexEstado', '<>', 'P');

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

            ->filterColumn('iexEstado_',function($query,$keyword) {
                $query->whereRaw("CONCAT(iexEstado) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('iexEstado_',function($query) {

                // actualizar iexEstado a P
                // $ejecutar_SP = DB::select("call procBachillerActualizaEstadoRecuperativo(".$query->perAnioPago.",
                // ".$query->aluClave.", ".$query->matSemestre.", ".$query->perNumero.", ".$query->extraordinario_id.")");

                $inscritos_a_recuperativo = DB::select("SELECT bie.id, bie.alumno_id, bie.iexEstado, alu.aluClave FROM bachiller_inscritosextraordinarios AS bie
                INNER JOIN alumnos AS alu ON alu.id = bie.alumno_id
                WHERE bie.extraordinario_id =$query->extraordinario_id
                AND alu.aluClave=$query->aluClave");

                foreach ($inscritos_a_recuperativo as $value){
                    if($query->aluClave == $value->aluClave){
                        if($value->iexEstado == "P"){
                            return "PAGADO";
                        }

                        if($value->iexEstado == "C"){
                            return "CANCELADO";
                        }

                        if($value->iexEstado == "N"){
                            return "PAGO PENDIENTE";
                        }
                    }
                }


            })

            ->filterColumn('tipo_pago',function($query,$keyword) {
                $query->whereRaw("CONCAT(iexTipoPago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('tipo_pago',function($query) {
                return $query->iexTipoPago;
            })
            ->addColumn('action',function($query) {


                $btnCancelar = "";
                $btnEditar = "";
                $btnRecibo = "";

                if(Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave == $query->ubiClave || Auth::user()->departamento_sistemas == 1){
                    $btnCancelar = '<a href="' . route('cancelar.bachiller_solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Cancelar">
                        <i class="material-icons">cancel</i>
                    </a>';
                    $btnRecibo = '<a href="' . route('recibo.bachiller_solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" target="_blank" title="ver recibo">
                        <i class="material-icons">subject</i>
                    </a>';
                    $btnEditar = '<a href="' . route('edit.bachiller_solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
                }

                $btnPagar = '<a href="#" class="button button--icon js-button js-ripple-effect" title="Pagar">
                    <i class="material-icons">attach_money</i>
                </a>';

                return '<a href="' . route('show.bachiller_solicitud', ['id' => $query->inscritoExtraordinario_id]) . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                .$btnCancelar
                .$btnEditar
                .$btnRecibo;
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

    public function updateEstadoPago()
    {
        $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;

        $ejecutar_sp = DB::select("call procBachillerExtraordinariosPagos('".$ubicacion."')");


        alert('Escuela Modelo', 'Se ha actualizado el estado de pago de los alumnos inscritos a recuperativos con éxito', 'success')->showConfirmButton();

        return back();
    }

    public function fecha_general_index()
    {
        //$conceptosPago = ConceptoPago::whereNotIn('conpClave', ['90', '91', '92', '93', '94', '95', '96', '97', '98'])->orderBy('conpClave')->get();
        $conceptosPago = ConceptoPago::whereIn('conpClave', ['36'])
            ->orderBy('conpClave')->get();
        $conceptosReferencia=  DB::select("SELECT * FROM conceptosreferenciaubicacion WHERE depClave is not null");

        return view('bachiller.extraordinario.ficha_general.create', [
            "conceptosPago" => $conceptosPago,
            "conceptosReferencia" => $conceptosReferencia,
        ]);
    }


    public function getCursoAlumno(Request $request,$aluClave, $cuoAnio)
    {
        if ($request->ajax()) {
            $curso = Curso::with('alumno.persona','cgt.plan.programa','cgt.periodo.departamento.ubicacion')
                ->whereHas('cgt.periodo', function($query) use ($cuoAnio) {
                    $query->where('perAnio', $cuoAnio)->orderBy('perNumero', 'desc');
                })
                ->whereHas('alumno', function($query) use ($aluClave) {
                    $query->where('aluClave', $aluClave);
                })->get()->sortBy("cgt.periodo.perAnio")->last();


            return response()->json($curso);
        }
    }

    public function getDebeRecuperativos(Request $request,$aluClave, $perAnio, $perNumero)
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
                ->where('periodos.perAnio', '=', $perAnio)
                ->where('periodos.perNumero', '=', $perNumero)
                ->where('bachiller_inscritosextraordinarios.iexEstado', '!=', "C")
                ->whereNull('bachiller_inscritosextraordinarios.deleted_at')
                ->get();


            return response()->json($inscritosextraordinarios);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::all();
        $empleados = Bachiller_empleados::activos()->get();
        $hoy = Carbon::now('America/Merida')->format('Y-m-d');
        return view('bachiller.extraordinario.create', compact('ubicaciones', 'empleados', 'hoy'));
    }

    public function getFechasRegularizacion(Request $request, $periodo_id, $plan_id, $extTipo)
    {
        if ($request->ajax()) {
            $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::where('periodo_id', '=', $periodo_id)
            ->where('plan_id', '=', $plan_id)
            ->get();

            return response()->json([
                'bachiller_fechas_regularizacion' => $bachiller_fechas_regularizacion,
                'extTipo' => $extTipo
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $calendario = Bachiller_fechas_regularizacion::where("id", $request->bachiller_fecha_regularizacion_id)->first();

        if (!$calendario) {
            alert('Ups!', 'No se encontró calendario de exámenes para este periodo. Favor de verificar esta información.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $fechaInicio = $calendario->frFechaInicioCursos ?: false;
        $fechaFin = $calendario->frFechaFinCursos ?: false;
        if (!$fechaInicio || !$fechaFin) {

            alert('Ups!', 'No se encontraron fechas para periodo recuperativo en el calendario de este periodo. No se pueden hacer registros sin contar con estos datos. Favor de verificar.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $validator = Validator::make(
            $request->all(),
            [
                'materia_id'  => 'required',
                'periodo_id'  => 'required',
                'empleado_id' => 'required',
                'extFecha'    => 'required|after_or_equal:' . $fechaInicio . '|before_or_equal:' . $fechaFin,
                'bachiller_fecha_regularizacion_id' => 'required',
                'extTipo' => 'required'
            ],
            [
                'materia_id.required'  => "La materia es requerida",
                'periodo_id.required'  => "El periodo es requerido",
                'empleado_id.required' => "El empleado es requerido",
                'extFecha.required'    => "La fecha de Extraordinario es requerida",
                'extFecha.after_or_equal' => "La fecha del extraordinario debe ser después o igual a las fecha de inicio de extraordinarios programada en el calendario de fechas de regularización de este periodo.",
                'extFecha.before_or_equal' => "La fecha de extraordinario no puede ser mayor a la establecida como fecha de Fin de extraordinarios. Revise el calendario de fechas de regularización de este periodo.",
                'bachiller_fecha_regularizacion_id.required' => "Fecha regularización es obligatorio",
                'extTipo.required' => "Tipo es obligatorio",

            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $programa_id = $request->programa_id;
            if (Utils::validaPermiso('extraordinario', $programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                return redirect()->back();
            }

            if($request->extHoraInicioLunes != ""){
                $extHoraInicioLunes = \Carbon\Carbon::parse($request->extHoraInicioLunes)->format('H');
                $extMinutoInicioLunes = \Carbon\Carbon::parse($request->extHoraInicioLunes)->format('i');
            }else{
                $extHoraInicioLunes = null;
                $extMinutoInicioLunes = null;

            }

            if($request->extHoraInicioMartes != ""){
                $extHoraInicioMartes = \Carbon\Carbon::parse($request->extHoraInicioMartes)->format('H');
                $extMinutoInicioMartes = \Carbon\Carbon::parse($request->extHoraInicioMartes)->format('i');

            }else{
                $extHoraInicioMartes = null;
                $extMinutoInicioMartes = null;

            }

            if($request->extHoraInicioMiercoles != ""){
                $extHoraInicioMiercoles = \Carbon\Carbon::parse($request->extHoraInicioMiercoles)->format('H');
                $extMinutoInicioMiercoles = \Carbon\Carbon::parse($request->extHoraInicioMiercoles)->format('i');
            }else{
                $extHoraInicioMiercoles = null;
                $extMinutoInicioMiercoles = null;
            }

            if($request->extHoraInicioJueves != ""){
                $extHoraInicioJueves = \Carbon\Carbon::parse($request->extHoraInicioJueves)->format('H');
                $extMinutoInicioJueves = \Carbon\Carbon::parse($request->extHoraInicioJueves)->format('i');
            }else{
                $extHoraInicioJueves = null;
                $extMinutoInicioJueves = null;
            }
            if($request->extHoraInicioViernes != ""){
                $extHoraInicioViernes = \Carbon\Carbon::parse($request->extHoraInicioViernes)->format('H');
                $extMinutoInicioViernes = \Carbon\Carbon::parse($request->extHoraInicioViernes)->format('i');
            }else{
                $extHoraInicioViernes = null;
                $extMinutoInicioViernes = null;
            }
            if($request->extHoraInicioSabado != ""){
                $extHoraInicioSabado = \Carbon\Carbon::parse($request->extHoraInicioSabado)->format('H');
                $extMinutoInicioSabado = \Carbon\Carbon::parse($request->extHoraInicioSabado)->format('i');
            }else{
                $extHoraInicioSabado = null;
                $extMinutoInicioSabado = null;
            }


            // Hora fin dias
            if($request->extHoraFinLunes != ""){
                $extHoraFinLunes = \Carbon\Carbon::parse($request->extHoraFinLunes)->format('H');
                $extMinutoFinLunes = \Carbon\Carbon::parse($request->extHoraFinLunes)->format('i');
            }else{
                $extHoraFinLunes = null;
                $extMinutoFinLunes = null;
            }

            if($request->extHoraFinMartes != ""){
                $extHoraFinMartes = \Carbon\Carbon::parse($request->extHoraFinMartes)->format('H');
                $extMinutoFinMartes = \Carbon\Carbon::parse($request->extHoraFinMartes)->format('i');
            }else{
                $extHoraFinMartes = null;
                $extMinutoFinMartes = null;
            }

            if($request->extHoraFinMiercoles != ""){
                $extHoraFinMiercoles = \Carbon\Carbon::parse($request->extHoraFinMiercoles)->format('H');
                $extMinutoFinMiercoles = \Carbon\Carbon::parse($request->extHoraFinMiercoles)->format('i');
            }else{
                $extHoraFinMiercoles = null;
                $extMinutoFinMiercoles = null;
            }

            if($request->extHoraFinJueves != ""){
                $extHoraFinJueves = \Carbon\Carbon::parse($request->extHoraFinJueves)->format('H');
                $extMinutoFinJueves = \Carbon\Carbon::parse($request->extHoraFinJueves)->format('i');
            }else{
                $extHoraFinJueves = null;
                $extMinutoFinJueves = null;
            }
            if($request->extHoraFinViernes != ""){
                $extHoraFinViernes = \Carbon\Carbon::parse($request->extHoraFinViernes)->format('H');
                $extMinutoFinViernes = \Carbon\Carbon::parse($request->extHoraFinViernes)->format('i');
            }else{
                $extHoraFinViernes = null;
                $extMinutoFinViernes = null;
            }

            if($request->extHoraFinSabado != ""){
                $extHoraFinSabado = \Carbon\Carbon::parse($request->extHoraFinSabado)->format('H');
                $extMinutoFinSabado = \Carbon\Carbon::parse($request->extHoraFinSabado)->format('i');
            }else{
                $extHoraFinSabado = null;
                $extMinutoFinSabado = null;
            }

            if($request->extHoraInicioSesion01 != ""){
                $extHoraInicioSesion01 = \Carbon\Carbon::parse($request->extHoraInicioSesion01)->format('H');
                $extMinutoInicioSesion01 = \Carbon\Carbon::parse($request->extHoraInicioSesion01)->format('i');
            }else{
                $extHoraInicioSesion01 = null;
                $extMinutoInicioSesion01 = null;
            }

            if($request->extHoraInicioSesion02 != ""){
                $extHoraInicioSesion02 = \Carbon\Carbon::parse($request->extHoraInicioSesion02)->format('H');
                $extMinutoInicioSesion02 = \Carbon\Carbon::parse($request->extHoraInicioSesion02)->format('i');
            }else{
                $extHoraInicioSesion02 = null;
                $extMinutoInicioSesion02 = null;
            }

            if($request->extHoraInicioSesion03 != ""){
                $extHoraInicioSesion03 = \Carbon\Carbon::parse($request->extHoraInicioSesion03)->format('H');
                $extMinutoInicioSesion03 = \Carbon\Carbon::parse($request->extHoraInicioSesion03)->format('i');
            }else{
                $extHoraInicioSesion03 = null;
                $extMinutoInicioSesion03 = null;
            }

            if($request->extHoraInicioSesion04 != ""){
                $extHoraInicioSesion04 = \Carbon\Carbon::parse($request->extHoraInicioSesion04)->format('H');
                $extMinutoInicioSesion04 = \Carbon\Carbon::parse($request->extHoraInicioSesion04)->format('i');
            }else{
                $extHoraInicioSesion04 = null;
                $extMinutoInicioSesion04 = null;
            }
            if($request->extHoraInicioSesion05 != ""){
                $extHoraInicioSesion05 = \Carbon\Carbon::parse($request->extHoraInicioSesion05)->format('H');
                $extMinutoInicioSesion05 = \Carbon\Carbon::parse($request->extHoraInicioSesion05)->format('i');
            }else{
                $extHoraInicioSesion05 = null;
                $extMinutoInicioSesion05 = null;
            }

            if($request->extHoraInicioSesion06 != ""){
                $extHoraInicioSesion06 = \Carbon\Carbon::parse($request->extHoraInicioSesion06)->format('H');
                $extMinutoInicioSesion06 = \Carbon\Carbon::parse($request->extHoraInicioSesion06)->format('i');
            }else{
                $extHoraInicioSesion06 = null;
                $extMinutoInicioSesion06 = null;
            }

            if($request->extHoraInicioSesion07 != ""){
                $extHoraInicioSesion07 = \Carbon\Carbon::parse($request->extHoraInicioSesion07)->format('H');
                $extMinutoInicioSesion07 = \Carbon\Carbon::parse($request->extHoraInicioSesion07)->format('i');
            }else{
                $extHoraInicioSesion07 = null;
                $extMinutoInicioSesion07 = null;
            }
            if($request->extHoraInicioSesion08 != ""){
                $extHoraInicioSesion08 = \Carbon\Carbon::parse($request->extHoraInicioSesion08)->format('H');
                $extMinutoInicioSesion08 = \Carbon\Carbon::parse($request->extHoraInicioSesion08)->format('i');
            }else{
                $extHoraInicioSesion08 = null;
                $extMinutoInicioSesion08 = null;
            }
            if($request->extHoraInicioSesion09 != ""){
                $extHoraInicioSesion09 = \Carbon\Carbon::parse($request->extHoraInicioSesion09)->format('H');
                $extMinutoInicioSesion09 = \Carbon\Carbon::parse($request->extHoraInicioSesion09)->format('i');
            }else{
                $extHoraInicioSesion09 = null;
                $extMinutoInicioSesion09 = null;
            }
            if($request->extHoraInicioSesion10 != ""){
                $extHoraInicioSesion10 = \Carbon\Carbon::parse($request->extHoraInicioSesion10)->format('H');
                $extMinutoInicioSesion10 = \Carbon\Carbon::parse($request->extHoraInicioSesion10)->format('i');
            }else{
                $extHoraInicioSesion10 = null;
                $extMinutoInicioSesion10 = null;
            }
            if($request->extHoraInicioSesion11 != ""){
                $extHoraInicioSesion11 = \Carbon\Carbon::parse($request->extHoraInicioSesion11)->format('H');
                $extMinutoInicioSesion11 = \Carbon\Carbon::parse($request->extHoraInicioSesion11)->format('i');
            }else{
                $extHoraInicioSesion11 = null;
                $extMinutoInicioSesion11 = null;
            }
            if($request->extHoraInicioSesion12 != ""){
                $extHoraInicioSesion12 = \Carbon\Carbon::parse($request->extHoraInicioSesion12)->format('H');
                $extMinutoInicioSesion12 = \Carbon\Carbon::parse($request->extHoraInicioSesion12)->format('i');
            }else{
                $extHoraInicioSesion12 = null;
                $extMinutoInicioSesion12 = null;
            }
            if($request->extHoraInicioSesion13 != ""){
                $extHoraInicioSesion13 = \Carbon\Carbon::parse($request->extHoraInicioSesion13)->format('H');
                $extMinutoInicioSesion13 = \Carbon\Carbon::parse($request->extHoraInicioSesion13)->format('i');
            }else{
                $extHoraInicioSesion13 = null;
                $extMinutoInicioSesion13 = null;
            }
            if($request->extHoraInicioSesion14 != ""){
                $extHoraInicioSesion14 = \Carbon\Carbon::parse($request->extHoraInicioSesion14)->format('H');
                $extMinutoInicioSesion14 = \Carbon\Carbon::parse($request->extHoraInicioSesion14)->format('i');
            }else{
                $extHoraInicioSesion14 = null;
                $extMinutoInicioSesion14 = null;
            }
            if($request->extHoraInicioSesion01 != ""){
                $extHoraInicioSesion15 = \Carbon\Carbon::parse($request->extHoraInicioSesion15)->format('H');
                $extMinutoInicioSesion15 = \Carbon\Carbon::parse($request->extHoraInicioSesion15)->format('i');
            }else{
                $extHoraInicioSesion15 = null;
                $extMinutoInicioSesion15 = null;
            }
            if($request->extHoraInicioSesion01 != ""){
                $extHoraInicioSesion16 = \Carbon\Carbon::parse($request->extHoraInicioSesion16)->format('H');
                $extMinutoInicioSesion16 = \Carbon\Carbon::parse($request->extHoraInicioSesion16)->format('i');
            }else{
                $extHoraInicioSesion16 = null;
                $extMinutoInicioSesion16 = null;
            }
            if($request->extHoraInicioSesion17 != ""){
                $extHoraInicioSesion17 = \Carbon\Carbon::parse($request->extHoraInicioSesion17)->format('H');
                $extMinutoInicioSesion17 = \Carbon\Carbon::parse($request->extHoraInicioSesion17)->format('i');
            }else{
                $extHoraInicioSesion17 = null;
                $extMinutoInicioSesion17 = null;
            }
            if($request->extHoraInicioSesion18 != ""){
                $extHoraInicioSesion18 = \Carbon\Carbon::parse($request->extHoraInicioSesion18)->format('H');
                $extMinutoInicioSesion18 = \Carbon\Carbon::parse($request->extHoraInicioSesion18)->format('i');
            }else{
                $extHoraInicioSesion18 = null;
                $extMinutoInicioSesion18 = null;
            }

            // fin sesion
            if($request->extHoraFinSesion01 != ""){
                $extHoraFinSesion01 = \Carbon\Carbon::parse($request->extHoraFinSesion01)->format('H');
                $extMinutoFinSesion01 = \Carbon\Carbon::parse($request->extHoraFinSesion01)->format('i');
            }else{
                $extHoraFinSesion01 = null;
                $extMinutoFinSesion01 = null;
            }

            if($request->extHoraFinSesion02 != ""){
                $extHoraFinSesion02 = \Carbon\Carbon::parse($request->extHoraFinSesion02)->format('H');
                $extMinutoFinSesion02 = \Carbon\Carbon::parse($request->extHoraFinSesion02)->format('i');
            }else{
                $extHoraFinSesion02 = null;
                $extMinutoFinSesion02 = null;
            }
            if($request->extHoraFinSesion03 != ""){
                $extHoraFinSesion03 = \Carbon\Carbon::parse($request->extHoraFinSesion03)->format('H');
                $extMinutoFinSesion03 = \Carbon\Carbon::parse($request->extHoraFinSesion03)->format('i');
            }else{
                $extHoraFinSesion03 = null;
                $extMinutoFinSesion03 = null;
            }
            if($request->extHoraFinSesion04 != ""){
                $extHoraFinSesion04 = \Carbon\Carbon::parse($request->extHoraFinSesion04)->format('H');
                $extMinutoFinSesion04 = \Carbon\Carbon::parse($request->extHoraFinSesion04)->format('i');
            }else{
                $extHoraFinSesion04 = null;
                $extMinutoFinSesion04 = null;
            }
            if($request->extHoraFinSesion05 != ""){
                $extHoraFinSesion05 = \Carbon\Carbon::parse($request->extHoraFinSesion05)->format('H');
                $extMinutoFinSesion05 = \Carbon\Carbon::parse($request->extHoraFinSesion05)->format('i');
            }else{
                $extHoraFinSesion05 = null;
                $extMinutoFinSesion05 = null;
            }
            if($request->extHoraFinSesion06 != ""){
                $extHoraFinSesion06 = \Carbon\Carbon::parse($request->extHoraFinSesion06)->format('H');
                $extMinutoFinSesion06 = \Carbon\Carbon::parse($request->extHoraFinSesion06)->format('i');
            }else{
                $extHoraFinSesion06 = null;
                $extMinutoFinSesion06 = null;
            }
            if($request->extHoraFinSesion07 != ""){
                $extHoraFinSesion07 = \Carbon\Carbon::parse($request->extHoraFinSesion07)->format('H');
                $extMinutoFinSesion07 = \Carbon\Carbon::parse($request->extHoraFinSesion07)->format('i');
            }else{
                $extHoraFinSesion07 = null;
                $extMinutoFinSesion07 = null;
            }
            if($request->extHoraFinSesion08 != ""){
                $extHoraFinSesion08 = \Carbon\Carbon::parse($request->extHoraFinSesion08)->format('H');
                $extMinutoFinSesion08 = \Carbon\Carbon::parse($request->extHoraFinSesion08)->format('i');
            }else{
                $extHoraFinSesion08 = null;
                $extMinutoFinSesion08 = null;
            }
            if($request->extHoraFinSesion09 != ""){
                $extHoraFinSesion09 = \Carbon\Carbon::parse($request->extHoraFinSesion09)->format('H');
                $extMinutoFinSesion09 = \Carbon\Carbon::parse($request->extHoraFinSesion09)->format('i');
            }else{
                $extHoraFinSesion09 = null;
                $extMinutoFinSesion09 = null;
            }
            if($request->extHoraFinSesion10 != ""){
                $extHoraFinSesion10 = \Carbon\Carbon::parse($request->extHoraFinSesion10)->format('H');
                $extMinutoFinSesion10 = \Carbon\Carbon::parse($request->extHoraFinSesion10)->format('i');
            }else{
                $extHoraFinSesion10 = null;
                $extMinutoFinSesion10 = null;
            }
            if($request->extHoraFinSesion11 != ""){
                $extHoraFinSesion11 = \Carbon\Carbon::parse($request->extHoraFinSesion11)->format('H');
                $extMinutoFinSesion11 = \Carbon\Carbon::parse($request->extHoraFinSesion11)->format('i');
            }else{
                $extHoraFinSesion11 = null;
                $extMinutoFinSesion11 = null;
            }
            if($request->extHoraFinSesion12 != ""){
                $extHoraFinSesion12 = \Carbon\Carbon::parse($request->extHoraFinSesion12)->format('H');
                $extMinutoFinSesion12 = \Carbon\Carbon::parse($request->extHoraFinSesion12)->format('i');
            }else{
                $extHoraFinSesion12 = null;
                $extMinutoFinSesion12 = null;
            }
            if($request->extHoraFinSesion13 != ""){
                $extHoraFinSesion13 = \Carbon\Carbon::parse($request->extHoraFinSesion13)->format('H');
                $extMinutoFinSesion13 = \Carbon\Carbon::parse($request->extHoraFinSesion13)->format('i');
            }else{
                $extHoraFinSesion13 = null;
                $extMinutoFinSesion13 = null;
            }
            if($request->extHoraFinSesion14 != ""){
                $extHoraFinSesion14 = \Carbon\Carbon::parse($request->extHoraFinSesion14)->format('H');
                $extMinutoFinSesion14 = \Carbon\Carbon::parse($request->extHoraFinSesion14)->format('i');
            }else{
                $extHoraFinSesion14 = null;
                $extMinutoFinSesion14 = null;
            }
            if($request->extHoraFinSesion15 != ""){
                $extHoraFinSesion15 = \Carbon\Carbon::parse($request->extHoraFinSesion15)->format('H');
                $extMinutoFinSesion15 = \Carbon\Carbon::parse($request->extHoraFinSesion15)->format('i');
            }else{
                $extHoraFinSesion15 = null;
                $extMinutoFinSesion15 = null;
            }
            if($request->extHoraFinSesion16 != ""){
                $extHoraFinSesion16 = \Carbon\Carbon::parse($request->extHoraFinSesion16)->format('H');
                $extMinutoFinSesion16 = \Carbon\Carbon::parse($request->extHoraFinSesion16)->format('i');
            }else{
                $extHoraFinSesion16 = null;
                $extMinutoFinSesion16 = null;
            }
            if($request->extHoraFinSesion17 != ""){
                $extHoraFinSesion17 = \Carbon\Carbon::parse($request->extHoraFinSesion17)->format('H');
                $extMinutoFinSesion17 = \Carbon\Carbon::parse($request->extHoraFinSesion17)->format('i');
            }else{
                $extHoraFinSesion17 = null;
                $extMinutoFinSesion17 = null;
            }
            if($request->extHoraFinSesion18 != ""){
                $extHoraFinSesion18 = \Carbon\Carbon::parse($request->extHoraFinSesion18)->format('H');
                $extMinutoFinSesion18 = \Carbon\Carbon::parse($request->extHoraFinSesion18)->format('i');
            }else{
                $extHoraFinSesion18 = null;
                $extMinutoFinSesion18 = null;
            }

            Bachiller_extraordinarios::create([
                'periodo_id'            => $request->periodo_id,
                'bachiller_materia_id'  => $request->materia_id,
                'bachiller_fecha_regularizacion_id' => $request->bachiller_fecha_regularizacion_id,
                'extTipo'               => $request->extTipo,
                'extFecha'              => $request->extFecha,
                'extHora'               => $request->extHora,
                'extLugar'              => NULL,
                'bachiller_empleado_id'           => $request->empleado_id,
                'bachiller_empleado_sinodal_id'   => $request->empleado_sinodal_id,
                'extNumeroFolio'        => $request->extNumeroFolio,
                'extNumeroActa'         => $request->extNumeroActa,
                'extNumeroLibro'        => $request->extNumeroLibro,
                'extPago'               => Utils::validaEmpty($request->extPago),
                'extAlumnosInscritos'   => $request->extAlumnosInscritos,
                'extGrupo'              => $request->extGrupo,
                'extHoraInicioLunes'    => $extHoraInicioLunes,
                'extHoraFinLunes'       => $extHoraFinLunes,
                'extAulaLunes'          => $request->extAulaLunes,
                'extHoraInicioMartes'    => $extHoraInicioMartes,
                'extHoraFinMartes'       => $extHoraFinMartes,
                'extAulaMartes'          => $request->extAulaMartes,
                'extHoraInicioMiercoles'    => $extHoraInicioMiercoles,
                'extHoraFinMiercoles'       => $extHoraFinMiercoles,
                'extAulaMiercoles'          => $request->extAulaMiercoles,
                'extHoraInicioJueves'    => $extHoraInicioJueves,
                'extHoraFinJueves'       => $extHoraFinJueves,
                'extAulaJueves'          => $request->extAulaJueves,
                'extHoraInicioViernes'    => $extHoraInicioViernes,
                'extHoraFinViernes'       => $extHoraFinViernes,
                'extAulaViernes'          => $request->extAulaViernes,
                'extHoraInicioSabado'    => $extHoraInicioSabado,
                'extHoraFinSabado'       => $extHoraFinSabado,
                'extAulaSabado'          => $request->extAulaSabado,
                'extFechaSesion01'       => $request->extFechaSesion01,
                'extFechaSesion02'       => $request->extFechaSesion02,
                'extFechaSesion03'       => $request->extFechaSesion03,
                'extFechaSesion04'       => $request->extFechaSesion04,
                'extFechaSesion05'       => $request->extFechaSesion05,
                'extFechaSesion06'       => $request->extFechaSesion06,
                'extFechaSesion07'       => $request->extFechaSesion07,
                'extFechaSesion08'       => $request->extFechaSesion08,
                'extFechaSesion09'       => $request->extFechaSesion09,
                'extFechaSesion10'       => $request->extFechaSesion10,
                'extFechaSesion11'       => $request->extFechaSesion11,
                'extFechaSesion12'       => $request->extFechaSesion12,
                'extFechaSesion13'       => $request->extFechaSesion13,
                'extFechaSesion14'       => $request->extFechaSesion14,
                'extFechaSesion15'       => $request->extFechaSesion15,
                'extFechaSesion16'       => $request->extFechaSesion16,
                'extFechaSesion17'       => $request->extFechaSesion17,
                'extFechaSesion18'       => $request->extFechaSesion18,
                'extHoraInicioSesion01'  => $extHoraInicioSesion01,
                'extHoraInicioSesion02'  => $extHoraInicioSesion02,
                'extHoraInicioSesion03'  => $extHoraInicioSesion03,
                'extHoraInicioSesion04'  => $extHoraInicioSesion04,
                'extHoraInicioSesion05'  => $extHoraInicioSesion05,
                'extHoraInicioSesion06'  => $extHoraInicioSesion06,
                'extHoraInicioSesion07'  => $extHoraInicioSesion07,
                'extHoraInicioSesion08'  => $extHoraInicioSesion08,
                'extHoraInicioSesion09'  => $extHoraInicioSesion09,
                'extHoraInicioSesion10'  => $extHoraInicioSesion10,
                'extHoraInicioSesion11'  => $extHoraInicioSesion11,
                'extHoraInicioSesion12'  => $extHoraInicioSesion12,
                'extHoraInicioSesion13'  => $extHoraInicioSesion13,
                'extHoraInicioSesion14'  => $extHoraInicioSesion14,
                'extHoraInicioSesion15'  => $extHoraInicioSesion15,
                'extHoraInicioSesion16'  => $extHoraInicioSesion16,
                'extHoraInicioSesion17'  => $extHoraInicioSesion17,
                'extHoraInicioSesion18'  => $extHoraInicioSesion18,
                'extHoraFinSesion01'  => $extHoraFinSesion01,
                'extHoraFinSesion02'  => $extHoraFinSesion02,
                'extHoraFinSesion03'  => $extHoraFinSesion03,
                'extHoraFinSesion04'  => $extHoraFinSesion04,
                'extHoraFinSesion05'  => $extHoraFinSesion05,
                'extHoraFinSesion06'  => $extHoraFinSesion06,
                'extHoraFinSesion07'  => $extHoraFinSesion07,
                'extHoraFinSesion08'  => $extHoraFinSesion08,
                'extHoraFinSesion09'  => $extHoraFinSesion09,
                'extHoraFinSesion10'  => $extHoraFinSesion10,
                'extHoraFinSesion11'  => $extHoraFinSesion11,
                'extHoraFinSesion12'  => $extHoraFinSesion12,
                'extHoraFinSesion13'  => $extHoraFinSesion13,
                'extHoraFinSesion14'  => $extHoraFinSesion14,
                'extHoraFinSesion15'  => $extHoraFinSesion15,
                'extHoraFinSesion16'  => $extHoraFinSesion16,
                'extHoraFinSesion17'  => $extHoraFinSesion17,
                'extHoraFinSesion18'  => $extHoraFinSesion18,


                'extMinutoInicioLunes' => $extMinutoInicioLunes,
                'extMinutoFinLunes' => $extMinutoFinLunes,
                'extMinutoInicioMartes' => $extMinutoInicioMartes,
                'extMinutoFinMartes' => $extMinutoFinMartes,
                'extMinutoInicioMiercoles' => $extMinutoInicioMiercoles,
                'extMinutoFinMiercoles' => $extMinutoFinMiercoles,
                'extMinutoInicioJueves' => $extMinutoInicioJueves,
                'extMinutoFinJueves' => $extMinutoFinJueves,
                'extMinutoInicioViernes' => $extMinutoInicioViernes,
                'extMinutoFinViernes' => $extMinutoFinViernes,
                'extMinutoInicioSabado' => $extMinutoInicioSabado,
                'extMinutoFinSabado' => $extMinutoFinSabado,
                'extMinutoInicioSesion01' => $extMinutoInicioSesion01,
                'extMinutoInicioSesion02' => $extMinutoInicioSesion02,
                'extMinutoInicioSesion03' => $extMinutoInicioSesion03,
                'extMinutoInicioSesion04' => $extMinutoInicioSesion04,
                'extMinutoInicioSesion05' => $extMinutoInicioSesion05,
                'extMinutoInicioSesion06' => $extMinutoInicioSesion06,
                'extMinutoInicioSesion07' => $extMinutoInicioSesion07,
                'extMinutoInicioSesion08' => $extMinutoInicioSesion08,
                'extMinutoInicioSesion09' => $extMinutoInicioSesion09,
                'extMinutoInicioSesion10' => $extMinutoInicioSesion10,
                'extMinutoInicioSesion11' => $extMinutoInicioSesion11,
                'extMinutoInicioSesion12' => $extMinutoInicioSesion12,
                'extMinutoInicioSesion13' => $extMinutoInicioSesion13,
                'extMinutoInicioSesion14' => $extMinutoInicioSesion14,
                'extMinutoInicioSesion15' => $extMinutoInicioSesion15,
                'extMinutoInicioSesion16' => $extMinutoInicioSesion16,
                'extMinutoInicioSesion17' => $extMinutoInicioSesion17,
                'extMinutoInicioSesion18' => $extMinutoInicioSesion18,
                'extMinutoFinSesion01' => $extMinutoFinSesion01,
                'extMinutoFinSesion02' => $extMinutoFinSesion02,
                'extMinutoFinSesion03' => $extMinutoFinSesion03,
                'extMinutoFinSesion04' => $extMinutoFinSesion04,
                'extMinutoFinSesion05' => $extMinutoFinSesion05,
                'extMinutoFinSesion06' => $extMinutoFinSesion06,
                'extMinutoFinSesion07' => $extMinutoFinSesion07,
                'extMinutoFinSesion08' => $extMinutoFinSesion08,
                'extMinutoFinSesion09' => $extMinutoFinSesion09,
                'extMinutoFinSesion10' => $extMinutoFinSesion10,
                'extMinutoFinSesion11' => $extMinutoFinSesion11,
                'extMinutoFinSesion12' => $extMinutoFinSesion12,
                'extMinutoFinSesion13' => $extMinutoFinSesion13,
                'extMinutoFinSesion14' => $extMinutoFinSesion14,
                'extMinutoFinSesion15' => $extMinutoFinSesion15,
                'extMinutoFinSesion16' => $extMinutoFinSesion16,
                'extMinutoFinSesion17' => $extMinutoFinSesion17,
                'extMinutoFinSesion18' => $extMinutoFinSesion18

            ]);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('bachiller_recuperativos/create')->withInput();
        }
        alert('Escuela Modelo', 'Se creo el recuperativo con éxito', 'success')->showConfirmButton();
        return redirect('bachiller_recuperativos');
    }

        /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $calendario = Bachiller_calendarioexamen::where("periodo_id", $request->periodo_id)
        $calendario = Bachiller_fechas_regularizacion::where("id", $request->bachiller_fecha_regularizacion_id)->first();


        $fechaInicio = $calendario->frFechaInicioCursos ?: false;
        $fechaFin = $calendario->frFechaFinCursos ?: false;
        if (!$fechaInicio || !$fechaFin) {
            alert('Ups!', 'No se encontraron fechas para periodo recuperativo en el calendario de este periodo. No se pueden hacer registros sin contar con estos datos. Favor de verificar.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $validator = Validator::make(
            $request->all(),
            [
                'materia_id' => 'required',
                'periodo_id' => 'required',
                'empleado_id' => 'required',
                'extFecha'    => 'required|after_or_equal:' . $fechaInicio . '|before_or_equal:' . $fechaFin,
            ],
            [
                'materia_id.required' => "La materia es requerida",
                'periodo_id.required' => "El periodo es requerido",
                'empleado_id.required' => "El empleado es requerido",
                'extFecha.required'    => "La fecha de Extraordinario es requerida",
                'extFecha.after_or_equal' => "La fecha del extraordinario debe ser después o igual a las fecha de inicio de extraordinarios programada en el calendario de exámenes de este periodo.",
                'extFecha.before_or_equal' => "La fecha de extraordinario no puede ser mayor a la establecida como fecha de Fin de extraordinarios. Revise el calendario de exámenes de este periodo.",
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            if ($request->extHoraInicioLunes != "") {
                $extHoraInicioLunes = \Carbon\Carbon::parse($request->extHoraInicioLunes)->format('H');
                $extMinutoInicioLunes = \Carbon\Carbon::parse($request->extHoraInicioLunes)->format('i');
            } else {
                $extHoraInicioLunes = null;
                $extMinutoInicioLunes = null;
            }

            if ($request->extHoraInicioMartes != "") {
                $extHoraInicioMartes = \Carbon\Carbon::parse($request->extHoraInicioMartes)->format('H');
                $extMinutoInicioMartes = \Carbon\Carbon::parse($request->extHoraInicioMartes)->format('i');
            } else {
                $extHoraInicioMartes = null;
                $extMinutoInicioMartes = null;
            }

            if ($request->extHoraInicioMiercoles != "") {
                $extHoraInicioMiercoles = \Carbon\Carbon::parse($request->extHoraInicioMiercoles)->format('H');
                $extMinutoInicioMiercoles = \Carbon\Carbon::parse($request->extHoraInicioMiercoles)->format('i');
            } else {
                $extHoraInicioMiercoles = null;
                $extMinutoInicioMiercoles = null;
            }

            if ($request->extHoraInicioJueves != "") {
                $extHoraInicioJueves = \Carbon\Carbon::parse($request->extHoraInicioJueves)->format('H');
                $extMinutoInicioJueves = \Carbon\Carbon::parse($request->extHoraInicioJueves)->format('i');
            } else {
                $extHoraInicioJueves = null;
                $extMinutoInicioJueves = null;
            }
            if ($request->extHoraInicioViernes != "") {
                $extHoraInicioViernes = \Carbon\Carbon::parse($request->extHoraInicioViernes)->format('H');
                $extMinutoInicioViernes = \Carbon\Carbon::parse($request->extHoraInicioViernes)->format('i');
            } else {
                $extHoraInicioViernes = null;
                $extMinutoInicioViernes = null;
            }
            if ($request->extHoraInicioSabado != "") {
                $extHoraInicioSabado = \Carbon\Carbon::parse($request->extHoraInicioSabado)->format('H');
                $extMinutoInicioSabado = \Carbon\Carbon::parse($request->extHoraInicioSabado)->format('i');
            } else {
                $extHoraInicioSabado = null;
                $extMinutoInicioSabado = null;
            }


            // Hora fin dias
            if ($request->extHoraFinLunes != "") {
                $extHoraFinLunes = \Carbon\Carbon::parse($request->extHoraFinLunes)->format('H');
                $extMinutoFinLunes = \Carbon\Carbon::parse($request->extHoraFinLunes)->format('i');
            } else {
                $extHoraFinLunes = null;
                $extMinutoFinLunes = null;
            }

            if ($request->extHoraFinMartes != "") {
                $extHoraFinMartes = \Carbon\Carbon::parse($request->extHoraFinMartes)->format('H');
                $extMinutoFinMartes = \Carbon\Carbon::parse($request->extHoraFinMartes)->format('i');
            } else {
                $extHoraFinMartes = null;
                $extMinutoFinMartes = null;
            }

            if ($request->extHoraFinMiercoles != "") {
                $extHoraFinMiercoles = \Carbon\Carbon::parse($request->extHoraFinMiercoles)->format('H');
                $extMinutoFinMiercoles = \Carbon\Carbon::parse($request->extHoraFinMiercoles)->format('i');
            } else {
                $extHoraFinMiercoles = null;
                $extMinutoFinMiercoles = null;
            }

            if ($request->extHoraFinJueves != "") {
                $extHoraFinJueves = \Carbon\Carbon::parse($request->extHoraFinJueves)->format('H');
                $extMinutoFinJueves = \Carbon\Carbon::parse($request->extHoraFinJueves)->format('i');
            } else {
                $extHoraFinJueves = null;
                $extMinutoFinJueves = null;
            }
            if ($request->extHoraFinViernes != "") {
                $extHoraFinViernes = \Carbon\Carbon::parse($request->extHoraFinViernes)->format('H');
                $extMinutoFinViernes = \Carbon\Carbon::parse($request->extHoraFinViernes)->format('i');
            } else {
                $extHoraFinViernes = null;
                $extMinutoFinViernes = null;
            }

            if ($request->extHoraFinSabado != "") {
                $extHoraFinSabado = \Carbon\Carbon::parse($request->extHoraFinSabado)->format('H');
                $extMinutoFinSabado = \Carbon\Carbon::parse($request->extHoraFinSabado)->format('i');
            } else {
                $extHoraFinSabado = null;
                $extMinutoFinSabado = null;
            }

            if ($request->extHoraInicioSesion01 != "") {
                $extHoraInicioSesion01 = \Carbon\Carbon::parse($request->extHoraInicioSesion01)->format('H');
                $extMinutoInicioSesion01 = \Carbon\Carbon::parse($request->extHoraInicioSesion01)->format('i');
            } else {
                $extHoraInicioSesion01 = null;
                $extMinutoInicioSesion01 = null;
            }

            if ($request->extHoraInicioSesion02 != "") {
                $extHoraInicioSesion02 = \Carbon\Carbon::parse($request->extHoraInicioSesion02)->format('H');
                $extMinutoInicioSesion02 = \Carbon\Carbon::parse($request->extHoraInicioSesion02)->format('i');
            } else {
                $extHoraInicioSesion02 = null;
                $extMinutoInicioSesion02 = null;
            }

            if ($request->extHoraInicioSesion03 != "") {
                $extHoraInicioSesion03 = \Carbon\Carbon::parse($request->extHoraInicioSesion03)->format('H');
                $extMinutoInicioSesion03 = \Carbon\Carbon::parse($request->extHoraInicioSesion03)->format('i');
            } else {
                $extHoraInicioSesion03 = null;
                $extMinutoInicioSesion03 = null;
            }

            if ($request->extHoraInicioSesion04 != "") {
                $extHoraInicioSesion04 = \Carbon\Carbon::parse($request->extHoraInicioSesion04)->format('H');
                $extMinutoInicioSesion04 = \Carbon\Carbon::parse($request->extHoraInicioSesion04)->format('i');
            } else {
                $extHoraInicioSesion04 = null;
                $extMinutoInicioSesion04 = null;
            }
            if ($request->extHoraInicioSesion05 != "") {
                $extHoraInicioSesion05 = \Carbon\Carbon::parse($request->extHoraInicioSesion05)->format('H');
                $extMinutoInicioSesion05 = \Carbon\Carbon::parse($request->extHoraInicioSesion05)->format('i');
            } else {
                $extHoraInicioSesion05 = null;
                $extMinutoInicioSesion05 = null;
            }

            if ($request->extHoraInicioSesion06 != "") {
                $extHoraInicioSesion06 = \Carbon\Carbon::parse($request->extHoraInicioSesion06)->format('H');
                $extMinutoInicioSesion06 = \Carbon\Carbon::parse($request->extHoraInicioSesion06)->format('i');
            } else {
                $extHoraInicioSesion06 = null;
                $extMinutoInicioSesion06 = null;
            }

            if ($request->extHoraInicioSesion07 != "") {
                $extHoraInicioSesion07 = \Carbon\Carbon::parse($request->extHoraInicioSesion07)->format('H');
                $extMinutoInicioSesion07 = \Carbon\Carbon::parse($request->extHoraInicioSesion07)->format('i');
            } else {
                $extHoraInicioSesion07 = null;
                $extMinutoInicioSesion07 = null;
            }
            if ($request->extHoraInicioSesion08 != "") {
                $extHoraInicioSesion08 = \Carbon\Carbon::parse($request->extHoraInicioSesion08)->format('H');
                $extMinutoInicioSesion08 = \Carbon\Carbon::parse($request->extHoraInicioSesion08)->format('i');
            } else {
                $extHoraInicioSesion08 = null;
                $extMinutoInicioSesion08 = null;
            }
            if ($request->extHoraInicioSesion09 != "") {
                $extHoraInicioSesion09 = \Carbon\Carbon::parse($request->extHoraInicioSesion09)->format('H');
                $extMinutoInicioSesion09 = \Carbon\Carbon::parse($request->extHoraInicioSesion09)->format('i');
            } else {
                $extHoraInicioSesion09 = null;
                $extMinutoInicioSesion09 = null;
            }
            if ($request->extHoraInicioSesion10 != "") {
                $extHoraInicioSesion10 = \Carbon\Carbon::parse($request->extHoraInicioSesion10)->format('H');
                $extMinutoInicioSesion10 = \Carbon\Carbon::parse($request->extHoraInicioSesion10)->format('i');
            } else {
                $extHoraInicioSesion10 = null;
                $extMinutoInicioSesion10 = null;
            }
            if ($request->extHoraInicioSesion11 != "") {
                $extHoraInicioSesion11 = \Carbon\Carbon::parse($request->extHoraInicioSesion11)->format('H');
                $extMinutoInicioSesion11 = \Carbon\Carbon::parse($request->extHoraInicioSesion11)->format('i');
            } else {
                $extHoraInicioSesion11 = null;
                $extMinutoInicioSesion11 = null;
            }
            if ($request->extHoraInicioSesion12 != "") {
                $extHoraInicioSesion12 = \Carbon\Carbon::parse($request->extHoraInicioSesion12)->format('H');
                $extMinutoInicioSesion12 = \Carbon\Carbon::parse($request->extHoraInicioSesion12)->format('i');
            } else {
                $extHoraInicioSesion12 = null;
                $extMinutoInicioSesion12 = null;
            }
            if ($request->extHoraInicioSesion13 != "") {
                $extHoraInicioSesion13 = \Carbon\Carbon::parse($request->extHoraInicioSesion13)->format('H');
                $extMinutoInicioSesion13 = \Carbon\Carbon::parse($request->extHoraInicioSesion13)->format('i');
            } else {
                $extHoraInicioSesion13 = null;
                $extMinutoInicioSesion13 = null;
            }
            if ($request->extHoraInicioSesion14 != "") {
                $extHoraInicioSesion14 = \Carbon\Carbon::parse($request->extHoraInicioSesion14)->format('H');
                $extMinutoInicioSesion14 = \Carbon\Carbon::parse($request->extHoraInicioSesion14)->format('i');
            } else {
                $extHoraInicioSesion14 = null;
                $extMinutoInicioSesion14 = null;
            }
            if ($request->extHoraInicioSesion01 != "") {
                $extHoraInicioSesion15 = \Carbon\Carbon::parse($request->extHoraInicioSesion15)->format('H');
                $extMinutoInicioSesion15 = \Carbon\Carbon::parse($request->extHoraInicioSesion15)->format('i');
            } else {
                $extHoraInicioSesion15 = null;
                $extMinutoInicioSesion15 = null;
            }
            if ($request->extHoraInicioSesion01 != "") {
                $extHoraInicioSesion16 = \Carbon\Carbon::parse($request->extHoraInicioSesion16)->format('H');
                $extMinutoInicioSesion16 = \Carbon\Carbon::parse($request->extHoraInicioSesion16)->format('i');
            } else {
                $extHoraInicioSesion16 = null;
                $extMinutoInicioSesion16 = null;
            }
            if ($request->extHoraInicioSesion17 != "") {
                $extHoraInicioSesion17 = \Carbon\Carbon::parse($request->extHoraInicioSesion17)->format('H');
                $extMinutoInicioSesion17 = \Carbon\Carbon::parse($request->extHoraInicioSesion17)->format('i');
            } else {
                $extHoraInicioSesion17 = null;
                $extMinutoInicioSesion17 = null;
            }
            if ($request->extHoraInicioSesion18 != "") {
                $extHoraInicioSesion18 = \Carbon\Carbon::parse($request->extHoraInicioSesion18)->format('H');
                $extMinutoInicioSesion18 = \Carbon\Carbon::parse($request->extHoraInicioSesion18)->format('i');
            } else {
                $extHoraInicioSesion18 = null;
                $extMinutoInicioSesion18 = null;
            }

            // fin sesion
            if ($request->extHoraFinSesion01 != "") {
                $extHoraFinSesion01 = \Carbon\Carbon::parse($request->extHoraFinSesion01)->format('H');
                $extMinutoFinSesion01 = \Carbon\Carbon::parse($request->extHoraFinSesion01)->format('i');
            } else {
                $extHoraFinSesion01 = null;
                $extMinutoFinSesion01 = null;
            }

            if ($request->extHoraFinSesion02 != "") {
                $extHoraFinSesion02 = \Carbon\Carbon::parse($request->extHoraFinSesion02)->format('H');
                $extMinutoFinSesion02 = \Carbon\Carbon::parse($request->extHoraFinSesion02)->format('i');
            } else {
                $extHoraFinSesion02 = null;
                $extMinutoFinSesion02 = null;
            }
            if ($request->extHoraFinSesion03 != "") {
                $extHoraFinSesion03 = \Carbon\Carbon::parse($request->extHoraFinSesion03)->format('H');
                $extMinutoFinSesion03 = \Carbon\Carbon::parse($request->extHoraFinSesion03)->format('i');
            } else {
                $extHoraFinSesion03 = null;
                $extMinutoFinSesion03 = null;
            }
            if ($request->extHoraFinSesion04 != "") {
                $extHoraFinSesion04 = \Carbon\Carbon::parse($request->extHoraFinSesion04)->format('H');
                $extMinutoFinSesion04 = \Carbon\Carbon::parse($request->extHoraFinSesion04)->format('i');
            } else {
                $extHoraFinSesion04 = null;
                $extMinutoFinSesion04 = null;
            }
            if ($request->extHoraFinSesion05 != "") {
                $extHoraFinSesion05 = \Carbon\Carbon::parse($request->extHoraFinSesion05)->format('H');
                $extMinutoFinSesion05 = \Carbon\Carbon::parse($request->extHoraFinSesion05)->format('i');
            } else {
                $extHoraFinSesion05 = null;
                $extMinutoFinSesion05 = null;
            }
            if ($request->extHoraFinSesion06 != "") {
                $extHoraFinSesion06 = \Carbon\Carbon::parse($request->extHoraFinSesion06)->format('H');
                $extMinutoFinSesion06 = \Carbon\Carbon::parse($request->extHoraFinSesion06)->format('i');
            } else {
                $extHoraFinSesion06 = null;
                $extMinutoFinSesion06 = null;
            }
            if ($request->extHoraFinSesion07 != "") {
                $extHoraFinSesion07 = \Carbon\Carbon::parse($request->extHoraFinSesion07)->format('H');
                $extMinutoFinSesion07 = \Carbon\Carbon::parse($request->extHoraFinSesion07)->format('i');
            } else {
                $extHoraFinSesion07 = null;
                $extMinutoFinSesion07 = null;
            }
            if ($request->extHoraFinSesion08 != "") {
                $extHoraFinSesion08 = \Carbon\Carbon::parse($request->extHoraFinSesion08)->format('H');
                $extMinutoFinSesion08 = \Carbon\Carbon::parse($request->extHoraFinSesion08)->format('i');
            } else {
                $extHoraFinSesion08 = null;
                $extMinutoFinSesion08 = null;
            }
            if ($request->extHoraFinSesion09 != "") {
                $extHoraFinSesion09 = \Carbon\Carbon::parse($request->extHoraFinSesion09)->format('H');
                $extMinutoFinSesion09 = \Carbon\Carbon::parse($request->extHoraFinSesion09)->format('i');
            } else {
                $extHoraFinSesion09 = null;
                $extMinutoFinSesion09 = null;
            }
            if ($request->extHoraFinSesion10 != "") {
                $extHoraFinSesion10 = \Carbon\Carbon::parse($request->extHoraFinSesion10)->format('H');
                $extMinutoFinSesion10 = \Carbon\Carbon::parse($request->extHoraFinSesion10)->format('i');
            } else {
                $extHoraFinSesion10 = null;
                $extMinutoFinSesion10 = null;
            }
            if ($request->extHoraFinSesion11 != "") {
                $extHoraFinSesion11 = \Carbon\Carbon::parse($request->extHoraFinSesion11)->format('H');
                $extMinutoFinSesion11 = \Carbon\Carbon::parse($request->extHoraFinSesion11)->format('i');
            } else {
                $extHoraFinSesion11 = null;
                $extMinutoFinSesion11 = null;
            }
            if ($request->extHoraFinSesion12 != "") {
                $extHoraFinSesion12 = \Carbon\Carbon::parse($request->extHoraFinSesion12)->format('H');
                $extMinutoFinSesion12 = \Carbon\Carbon::parse($request->extHoraFinSesion12)->format('i');
            } else {
                $extHoraFinSesion12 = null;
                $extMinutoFinSesion12 = null;
            }
            if ($request->extHoraFinSesion13 != "") {
                $extHoraFinSesion13 = \Carbon\Carbon::parse($request->extHoraFinSesion13)->format('H');
                $extMinutoFinSesion13 = \Carbon\Carbon::parse($request->extHoraFinSesion13)->format('i');
            } else {
                $extHoraFinSesion13 = null;
                $extMinutoFinSesion13 = null;
            }
            if ($request->extHoraFinSesion14 != "") {
                $extHoraFinSesion14 = \Carbon\Carbon::parse($request->extHoraFinSesion14)->format('H');
                $extMinutoFinSesion14 = \Carbon\Carbon::parse($request->extHoraFinSesion14)->format('i');
            } else {
                $extHoraFinSesion14 = null;
                $extMinutoFinSesion14 = null;
            }
            if ($request->extHoraFinSesion15 != "") {
                $extHoraFinSesion15 = \Carbon\Carbon::parse($request->extHoraFinSesion15)->format('H');
                $extMinutoFinSesion15 = \Carbon\Carbon::parse($request->extHoraFinSesion15)->format('i');
            } else {
                $extHoraFinSesion15 = null;
                $extMinutoFinSesion15 = null;
            }
            if ($request->extHoraFinSesion16 != "") {
                $extHoraFinSesion16 = \Carbon\Carbon::parse($request->extHoraFinSesion16)->format('H');
                $extMinutoFinSesion16 = \Carbon\Carbon::parse($request->extHoraFinSesion16)->format('i');
            } else {
                $extHoraFinSesion16 = null;
                $extMinutoFinSesion16 = null;
            }
            if ($request->extHoraFinSesion17 != "") {
                $extHoraFinSesion17 = \Carbon\Carbon::parse($request->extHoraFinSesion17)->format('H');
                $extMinutoFinSesion17 = \Carbon\Carbon::parse($request->extHoraFinSesion17)->format('i');
            } else {
                $extHoraFinSesion17 = null;
                $extMinutoFinSesion17 = null;
            }
            if ($request->extHoraFinSesion18 != "") {
                $extHoraFinSesion18 = \Carbon\Carbon::parse($request->extHoraFinSesion18)->format('H');
                $extMinutoFinSesion18 = \Carbon\Carbon::parse($request->extHoraFinSesion18)->format('i');
            } else {
                $extHoraFinSesion18 = null;
                $extMinutoFinSesion18 = null;
            }

            $extraordinario = Bachiller_extraordinarios::findOrFail($id);
            $extraordinario->periodo_id = $request->periodo_id;
            $extraordinario->bachiller_materia_id = $request->materia_id;
            $extraordinario->bachiller_fecha_regularizacion_id = $request->bachiller_fecha_regularizacion_id;
            $extraordinario->extTipo               = $request->extTipo;
            $extraordinario->extFecha = $request->extFecha;
            $extraordinario->extHora = $request->extHora;
            $extraordinario->extLugar = NULL;
            $extraordinario->bachiller_empleado_id = $request->empleado_id;
            $extraordinario->bachiller_empleado_sinodal_id = $request->empleado_sinodal_id;
            $extraordinario->extNumeroFolio = $request->extNumeroFolio;
            $extraordinario->extNumeroActa = $request->extNumeroActa;
            $extraordinario->extNumeroLibro = $request->extNumeroLibro;
            $extraordinario->extPago = Utils::validaEmpty($request->extPago);
            $extraordinario->extAlumnosInscritos = $request->extAlumnosInscritos;
            $extraordinario->extGrupo = $request->extGrupo;
            $extraordinario->extHoraInicioLunes    = $extHoraInicioLunes;
            $extraordinario->extHoraFinLunes       = $extHoraFinLunes;
            $extraordinario->extAulaLunes          = $request->extAulaLunes;
            $extraordinario->extHoraInicioMartes    = $extHoraInicioMartes;
            $extraordinario->extHoraFinMartes       = $extHoraFinMartes;
            $extraordinario->extAulaMartes          = $request->extAulaMartes;
            $extraordinario->extHoraInicioMiercoles    = $extHoraInicioMiercoles;
            $extraordinario->extHoraFinMiercoles       = $extHoraFinMiercoles;
            $extraordinario->extAulaMiercoles          = $request->extAulaMiercoles;
            $extraordinario->extHoraInicioJueves    = $extHoraInicioJueves;
            $extraordinario->extHoraFinJueves       = $extHoraFinJueves;
            $extraordinario->extAulaJueves          = $request->extAulaJueves;
            $extraordinario->extHoraInicioViernes    = $extHoraInicioViernes;
            $extraordinario->extHoraFinViernes       = $extHoraFinViernes;
            $extraordinario->extAulaViernes          = $request->extAulaViernes;
            $extraordinario->extHoraInicioSabado    = $extHoraInicioSabado;
            $extraordinario->extHoraFinSabado       = $extHoraFinSabado;
            $extraordinario->extAulaSabado          = $request->extAulaSabado;
            $extraordinario->extFechaSesion01       = $request->extFechaSesion01;
            $extraordinario->extFechaSesion02       = $request->extFechaSesion02;
            $extraordinario->extFechaSesion03       = $request->extFechaSesion03;
            $extraordinario->extFechaSesion04       = $request->extFechaSesion04;
            $extraordinario->extFechaSesion05       = $request->extFechaSesion05;
            $extraordinario->extFechaSesion06       = $request->extFechaSesion06;
            $extraordinario->extFechaSesion07       = $request->extFechaSesion07;
            $extraordinario->extFechaSesion08       = $request->extFechaSesion08;
            $extraordinario->extFechaSesion09       = $request->extFechaSesion09;
            $extraordinario->extFechaSesion10       = $request->extFechaSesion10;
            $extraordinario->extFechaSesion11       = $request->extFechaSesion11;
            $extraordinario->extFechaSesion12       = $request->extFechaSesion12;
            $extraordinario->extFechaSesion13       = $request->extFechaSesion13;
            $extraordinario->extFechaSesion14       = $request->extFechaSesion14;
            $extraordinario->extFechaSesion15       = $request->extFechaSesion15;
            $extraordinario->extFechaSesion16       = $request->extFechaSesion16;
            $extraordinario->extFechaSesion17       = $request->extFechaSesion17;
            $extraordinario->extFechaSesion18       = $request->extFechaSesion18;
            $extraordinario->extHoraInicioSesion01  = $extHoraInicioSesion01;
            $extraordinario->extHoraInicioSesion02  = $extHoraInicioSesion02;
            $extraordinario->extHoraInicioSesion03  = $extHoraInicioSesion03;
            $extraordinario->extHoraInicioSesion04  = $extHoraInicioSesion04;
            $extraordinario->extHoraInicioSesion05  = $extHoraInicioSesion05;
            $extraordinario->extHoraInicioSesion06  = $extHoraInicioSesion06;
            $extraordinario->extHoraInicioSesion07  = $extHoraInicioSesion07;
            $extraordinario->extHoraInicioSesion08  = $extHoraInicioSesion08;
            $extraordinario->extHoraInicioSesion09  = $extHoraInicioSesion09;
            $extraordinario->extHoraInicioSesion10  = $extHoraInicioSesion10;
            $extraordinario->extHoraInicioSesion11  = $extHoraInicioSesion11;
            $extraordinario->extHoraInicioSesion12  = $extHoraInicioSesion12;
            $extraordinario->extHoraInicioSesion13  = $extHoraInicioSesion13;
            $extraordinario->extHoraInicioSesion14  = $extHoraInicioSesion14;
            $extraordinario->extHoraInicioSesion15  = $extHoraInicioSesion15;
            $extraordinario->extHoraInicioSesion16  = $extHoraInicioSesion16;
            $extraordinario->extHoraInicioSesion17  = $extHoraInicioSesion17;
            $extraordinario->extHoraInicioSesion18  = $extHoraInicioSesion18;
            $extraordinario->extHoraFinSesion01  = $extHoraFinSesion01;
            $extraordinario->extHoraFinSesion02  = $extHoraFinSesion02;
            $extraordinario->extHoraFinSesion03  = $extHoraFinSesion03;
            $extraordinario->extHoraFinSesion04  = $extHoraFinSesion04;
            $extraordinario->extHoraFinSesion05  = $extHoraFinSesion05;
            $extraordinario->extHoraFinSesion06  = $extHoraFinSesion06;
            $extraordinario->extHoraFinSesion07  = $extHoraFinSesion07;
            $extraordinario->extHoraFinSesion08  = $extHoraFinSesion08;
            $extraordinario->extHoraFinSesion09  = $extHoraFinSesion09;
            $extraordinario->extHoraFinSesion10  = $extHoraFinSesion10;
            $extraordinario->extHoraFinSesion11  = $extHoraFinSesion11;
            $extraordinario->extHoraFinSesion12  = $extHoraFinSesion12;
            $extraordinario->extHoraFinSesion13  = $extHoraFinSesion13;
            $extraordinario->extHoraFinSesion14  = $extHoraFinSesion14;
            $extraordinario->extHoraFinSesion15  = $extHoraFinSesion15;
            $extraordinario->extHoraFinSesion16  = $extHoraFinSesion16;
            $extraordinario->extHoraFinSesion17  = $extHoraFinSesion17;
            $extraordinario->extHoraFinSesion18  = $extHoraFinSesion18;

            $extraordinario->extMinutoInicioLunes = $extMinutoInicioLunes;
            $extraordinario->extMinutoFinLunes = $extMinutoFinLunes;
            $extraordinario->extMinutoInicioMartes = $extMinutoInicioMartes;
            $extraordinario->extMinutoFinMartes = $extMinutoFinMartes;
            $extraordinario->extMinutoInicioMiercoles = $extMinutoInicioMiercoles;
            $extraordinario->extMinutoFinMiercoles = $extMinutoFinMiercoles;
            $extraordinario->extMinutoInicioJueves = $extMinutoInicioJueves;
            $extraordinario->extMinutoFinJueves = $extMinutoFinJueves;
            $extraordinario->extMinutoInicioViernes = $extMinutoInicioViernes;
            $extraordinario->extMinutoFinViernes = $extMinutoFinViernes;
            $extraordinario->extMinutoInicioSabado = $extMinutoInicioSabado;
            $extraordinario->extMinutoFinSabado = $extMinutoFinSabado;
            $extraordinario->extMinutoInicioSesion01 = $extMinutoInicioSesion01;
            $extraordinario->extMinutoInicioSesion02 = $extMinutoInicioSesion02;
            $extraordinario->extMinutoInicioSesion03 = $extMinutoInicioSesion03;
            $extraordinario->extMinutoInicioSesion04 = $extMinutoInicioSesion04;
            $extraordinario->extMinutoInicioSesion05 = $extMinutoInicioSesion05;
            $extraordinario->extMinutoInicioSesion06 = $extMinutoInicioSesion06;
            $extraordinario->extMinutoInicioSesion07 = $extMinutoInicioSesion07;
            $extraordinario->extMinutoInicioSesion08 = $extMinutoInicioSesion08;
            $extraordinario->extMinutoInicioSesion09 = $extMinutoInicioSesion09;
            $extraordinario->extMinutoInicioSesion10 = $extMinutoInicioSesion10;
            $extraordinario->extMinutoInicioSesion11 = $extMinutoInicioSesion11;
            $extraordinario->extMinutoInicioSesion12 = $extMinutoInicioSesion12;
            $extraordinario->extMinutoInicioSesion13 = $extMinutoInicioSesion13;
            $extraordinario->extMinutoInicioSesion14 = $extMinutoInicioSesion14;
            $extraordinario->extMinutoInicioSesion15 = $extMinutoInicioSesion15;
            $extraordinario->extMinutoInicioSesion16 = $extMinutoInicioSesion16;
            $extraordinario->extMinutoInicioSesion17 = $extMinutoInicioSesion17;
            $extraordinario->extMinutoInicioSesion18 = $extMinutoInicioSesion18;
            $extraordinario->extMinutoFinSesion01 = $extMinutoFinSesion01;
            $extraordinario->extMinutoFinSesion02 = $extMinutoFinSesion02;
            $extraordinario->extMinutoFinSesion03 = $extMinutoFinSesion03;
            $extraordinario->extMinutoFinSesion04 = $extMinutoFinSesion04;
            $extraordinario->extMinutoFinSesion05 = $extMinutoFinSesion05;
            $extraordinario->extMinutoFinSesion06 = $extMinutoFinSesion06;
            $extraordinario->extMinutoFinSesion07 = $extMinutoFinSesion07;
            $extraordinario->extMinutoFinSesion08 = $extMinutoFinSesion08;
            $extraordinario->extMinutoFinSesion09 = $extMinutoFinSesion09;
            $extraordinario->extMinutoFinSesion10 = $extMinutoFinSesion10;
            $extraordinario->extMinutoFinSesion11 = $extMinutoFinSesion11;
            $extraordinario->extMinutoFinSesion12 = $extMinutoFinSesion12;
            $extraordinario->extMinutoFinSesion13 = $extMinutoFinSesion13;
            $extraordinario->extMinutoFinSesion14 = $extMinutoFinSesion14;
            $extraordinario->extMinutoFinSesion15 = $extMinutoFinSesion15;
            $extraordinario->extMinutoFinSesion16 = $extMinutoFinSesion16;
            $extraordinario->extMinutoFinSesion17 = $extMinutoFinSesion17;
            $extraordinario->extMinutoFinSesion18 = $extMinutoFinSesion18;
            $extraordinario->save();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
        alert('Escuela Modelo', 'El recuperativo se ha actualizado con éxito', 'success')->showConfirmButton();
        return redirect()->back();
    }

    public function update_docente(Request $request, $id)
    {


        $validator = Validator::make($request->all(),
            [
                'empleado_id' => 'required',
            ],
            [

                'empleado_id.required' => "El empleado es requerido",

            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $extraordinario = Bachiller_extraordinarios::findOrFail($id);
            $extraordinario->bachiller_empleado_id = $request->empleado_id;
            $extraordinario->bachiller_empleado_sinodal_id = $request->empleado_sinodal_id;
            $extraordinario->save();



        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
        alert('Escuela Modelo', 'El docente a recuperativo se ha actualizado con éxito', 'success')->showConfirmButton();
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $extraordinario = Bachiller_extraordinarios::find($id);

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe recuperativo solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        if($extraordinario->bachiller_inscritos()->count() + $extraordinario->bachiller_preinscritos()->count() > 0) {
            alert("No se puede borrar el recuperativo #{$extraordinario->id}", 'Actualmente hay alumnos inscritos a este recuperativo o en proceso de solicitud. Ya se ha generado una ficha pendiente por pagar. Favor de dirigirse a la opción PREINSCRITOS EXTRAORDINARIOS y revisar quienes son los alumnos que desean inscribirse a este examen. Es importante que se comunique con ellos para validar que no hayan pagado la inscripción a este examen que desea eliminar', 'warning')->showConfirmButton();
            return redirect()->back();
        }

        try {
            if (Utils::validaPermiso('extraordinario', $extraordinario->bachiller_materia->plan->programa_id)) {

                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                return redirect('extraordinario');
            }
            if ($extraordinario->delete()) {

                alert('Escuela Modelo', 'El recuperativo se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {

                alert()->error('Error...', 'No se puedo eliminar el recuperativo')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $extraordinario = Bachiller_extraordinarios::with('bachiller_empleado','bachiller_empleadoSinodal', 'periodo', 'bachiller_materia')->find($id);

        $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::where('id', $extraordinario->bachiller_fecha_regularizacion_id)->first();
        if($bachiller_fechas_regularizacion != ""){
            $frFechaInicioCursosDia = \Carbon\Carbon::parse($bachiller_fechas_regularizacion->frFechaInicioCursos)->format('d');
            $frFechaInicioCursosMes = \Carbon\Carbon::parse($bachiller_fechas_regularizacion->frFechaInicioCursos)->format('m');
            $frFechaInicioCursosYear = \Carbon\Carbon::parse($bachiller_fechas_regularizacion->frFechaInicioCursos)->format('Y');
            $inicioCurso = $frFechaInicioCursosDia.'/'.Utils::num_meses_corto_string($frFechaInicioCursosMes).'/'.$frFechaInicioCursosYear;

            $frFechaFinCursosDia = \Carbon\Carbon::parse($bachiller_fechas_regularizacion->frFechaFinCursos)->format('d');
            $frFechaFinCursosMes = \Carbon\Carbon::parse($bachiller_fechas_regularizacion->frFechaFinCursos)->format('m');
            $frFechaFinCursosYear = \Carbon\Carbon::parse($bachiller_fechas_regularizacion->frFechaFinCursos)->format('Y');
            $finCurso = $frFechaFinCursosDia.'/'.Utils::num_meses_corto_string($frFechaFinCursosMes).'/'.$frFechaFinCursosYear;

            $fecha_regularizacion = 'Importe: ' . $bachiller_fechas_regularizacion->frImporteRecursamiento.' - Fecha inicio curso: '.$inicioCurso. ' - Fecha fin curso:'.$finCurso;
        }else{
            $fecha_regularizacion = "";
        }

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe recuperativo solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        return view('bachiller.extraordinario.show', compact('extraordinario', 'fecha_regularizacion'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

       $extraordinario = Bachiller_extraordinarios::select(
        'bachiller_extraordinarios.*',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnio',
        'periodos.perFechaInicial',
        'periodos.perFechaFinal',
        'bachiller_materias.matClave',
        'bachiller_materias.matNombre',
        'bachiller_materias.matSemestre',
        'bachiller_empleados.empNombre as perNombre','bachiller_empleados.empApellido1 as perApellido1','bachiller_empleados.empApellido2 as perApellido2',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'empleadoAux.empApellido1', 'empleadoAux.empApellido2', 'empleadoAux.empNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre')
        ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
        ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
        ->join('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
        ->leftJoin('bachiller_empleados as empleadoAux', 'bachiller_extraordinarios.bachiller_empleado_sinodal_id', '=', 'empleadoAux.id')
        ->where('bachiller_extraordinarios.id', $id)
        ->first();

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe recuperativo solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }

        if($extraordinario->bachiller_inscritos()->count() + $extraordinario->bachiller_preinscritos()->count() > 0) {
            alert("No se puede editar el Recuperativo #{$extraordinario->id}", 'Actualmente hay alumnos inscritos a este recuperativo o en proceso de solicitud. Ya se ha generado una ficha pendiente por pagar. Favor de dirigirse a la opción PREINSCRITOS RECUPERATIVOS y revisar quienes son los alumnos que desean inscribirse a este examen. Es importante que se comunique con ellos para validar que no hayan pagado la inscripción a este examen que desea modificar', 'warning')->showConfirmButton();
            return redirect()->back();
        }


        $empleados = Bachiller_empleados::where('empEstado', '<>', 'B')->get();
        // $aulas = Aula::where('ubicacion_id', $extraordinario->materia->plan->programa->escuela->departamento->ubicacion->id)->get();
        $hoy = Carbon::now('America/Merida')->format('Y-m-d');

        //VALIDA PERMISOS EN EL PROGRAMA
        // if (Utils::validaPermiso('extraordinario', $extraordinario->bachiller_materia->plan->programa_id)) {
        //     alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
        //     return redirect()->back();
        // }

        return view('bachiller.extraordinario.edit', compact('extraordinario', 'empleados', 'hoy'));
    }

    public function editar_docente($id)
    {
    //    $extraordinario = Bachiller_extraordinarios::with('bachiller_empleado', 'bachiller_empleadoSinodal', 'periodo', 'bachiller_materia')->find($id);

         $extraordinario = Bachiller_extraordinarios::select(
        'bachiller_extraordinarios.id','bachiller_extraordinarios.extAlumnosInscritos',
        'bachiller_extraordinarios.extPago','bachiller_extraordinarios.extFecha','bachiller_extraordinarios.extHora',
        'bachiller_extraordinarios.bachiller_empleado_id',
        'bachiller_extraordinarios.bachiller_empleado_sinodal_id',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnio',
        'periodos.perFechaInicial',
        'periodos.perFechaFinal',
        'bachiller_materias.matClave',
        'bachiller_materias.matNombre',
        'bachiller_materias.matSemestre',
        'bachiller_empleados.empNombre as perNombre','bachiller_empleados.empApellido1 as perApellido1','bachiller_empleados.empApellido2 as perApellido2',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'empleadoAux.empApellido1', 'empleadoAux.empApellido2', 'empleadoAux.empNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre')
        ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
        ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
        ->join('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
        ->leftJoin('bachiller_empleados as empleadoAux', 'bachiller_extraordinarios.bachiller_empleado_sinodal_id', '=', 'empleadoAux.id')
        ->where('bachiller_extraordinarios.id', $id)
        ->first();

        if (!$extraordinario) {
            alert()->error('Ups...', 'No existe recuperativo solicitado')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        }


        $empleados = Bachiller_empleados::where('empEstado', '<>', 'B')->get();
        // $aulas = Aula::where('ubicacion_id', $extraordinario->materia->plan->programa->escuela->departamento->ubicacion->id)->get();
        $hoy = Carbon::now('America/Merida')->format('Y-m-d');

        //VALIDA PERMISOS EN EL PROGRAMA
        // if (Utils::validaPermiso('extraordinario', $extraordinario->bachiller_materia->plan->programa_id)) {
        //     alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
        //     return redirect()->back();
        // }

        return view('bachiller.extraordinario.edit-docente', compact('extraordinario', 'empleados', 'hoy'));
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

    public function solicitar(Request $request, $extraordinario_id, $periodo_id, $bachiller_materia_id)
    {
        $fechaActual = Carbon::now('CDT');
        $aceptadaSinOrdinario = false;
        $ultOportunidad = false;

        $alumno = Alumno::where('aluClave', Auth::user()->username)->first();
        $alumno_id = $alumno->id;
        $results = DB::select(DB::raw("SELECT
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
        );"));
        $cursos = collect($results)->first();
        $curso = Curso::with("alumno.persona", "periodo.departamento.ubicacion", "cgt.plan.programa")
                 ->where("id", $cursos->cursos_id)->first();
        $ubicacion = $curso ? $curso->periodo->departamento->ubicacion : null;
        $ubicacion_id = $ubicacion->id;

        /**
        * Si el alumno está inscrito a un extra con la misma fecha, no puede inscribirse a este extra.
        */
        $extraordinario = Bachiller_extraordinarios::find($extraordinario_id);
        $fechaOcupada = Bachiller_inscritosextraordinarios::where('alumno_id', $alumno_id)
        ->whereDate('iexFecha', '=', $extraordinario->extFecha)->get();
        if($fechaOcupada->isNotEmpty()) {
            alert()->warning('No se puede procesar la Solicitud', 'El alumno ya tiene un examen para esa misma fecha.')->showConfirmButton();
            return back()->withInput();
        }

        // valida si el alumno ya esta inscrito
        $alumnoYaInscrito = Bachiller_inscritosextraordinarios::select('bachiller_inscritosextraordinarios.*', 'bachiller_materias.matCreditos')
                        ->join('bachiller_extraordinarios', 'bachiller_inscritosextraordinarios.extraordinario_id', '=', 'bachiller_extraordinarios.id')
                        ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
                        ->where('alumno_id', $alumno_id)
                        ->where('bachiller_inscritosextraordinarios.iexEstado', '!=', 'C')
                        ->where('bachiller_materias.id', '=', $bachiller_materia_id)
                        ->where('bachiller_extraordinarios.periodo_id', '=', $periodo_id)
        				// ->where('extraordinario_id', '=', $extraordinario_id)
                        ->get();
                        
        if($alumnoYaInscrito->isNotEmpty()) {
            alert()->warning('No se puede procesar la Solicitud', 'Ya se encuentra inscrito a este recuperativo.')->showConfirmButton();
            return back()->withInput();
        }

        // valida el numero de creditos
        $bachillerExtraordinarios = Bachiller_inscritosextraordinarios::select('bachiller_inscritosextraordinarios.*', 'bachiller_materias.matCreditos')
                    ->join('bachiller_extraordinarios', 'bachiller_inscritosextraordinarios.extraordinario_id', '=', 'bachiller_extraordinarios.id')
                    ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
                    ->where('bachiller_inscritosextraordinarios.iexEstado', '!=', 'C')
                    ->where('bachiller_extraordinarios.periodo_id', $periodo_id)
                    ->where('alumno_id', $alumno_id)
                    ->whereNull('iexFolioHistorico')
                    ->get();
        $totalMatCreditos = 0;
        $totalMatCreditos += $alumnoYaInscrito->sum('matCreditos');
        $totalMatCreditos += $bachillerExtraordinarios->sum('matCreditos');
        $totalMatCreditos += $request->matCreditos;

        // return $totalMatCreditos;
        
        if ($totalMatCreditos > 15) {
            alert()->warning('No se puede procesar la Solicitud', 'Ya has alcanzado el máximo de créditos.')->showConfirmButton();
            return back()->withInput();
        }

        $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::find($extraordinario->bachiller_fecha_regularizacion_id);

        if($extraordinario->extTipo == "ACOMPAÑAMIENTO"){
           $alumnos_permitidos = $bachiller_fechas_regularizacion->frMaximoAcomp;
        }

        if($extraordinario->extTipo == "RECURSAMIENTO"){
            $alumnos_permitidos = $bachiller_fechas_regularizacion->frMaximoRecursamiento;
        }

        if($extraordinario->extAlumnosInscritos < $alumnos_permitidos){
            try {

                $inscritoExt = New Bachiller_inscritosextraordinarios;
                $inscritoExt->alumno_id = $alumno_id;
                $inscritoExt->extraordinario_id = $extraordinario_id;
                $inscritoExt->iexFecha = $fechaActual->format('Y-m-d');
                $inscritoExt->iexCalificacion = NULL;
                $inscritoExt->iexEstado = 'N';
                $inscritoExt->iexFolioHistorico = NULL;
                $inscritoExt->usuario_at = 1;
                $inscritoExt->save();
    
                $extra = $inscritoExt->bachiller_extraordinario;
                $extraUpdated = $this->updateNumInscritosExtra($extra);
    
                $extPago = $inscritoExt->bachiller_extraordinario->extPago;
                $pagoLetras = NumeroALetras::convert($extPago,'PESOS',true);
    
                if($ubicacion_id == 1 || $ubicacion_id == 2 || $ubicacion_id == 4){
                    //Yucatán
                    $inscrito = Bachiller_inscritos::with('curso','bachiller_grupo')
                    ->whereHas('curso',function($query) use($inscritoExt){
                        $query->where('alumno_id',$inscritoExt->alumno_id);
                    })
                    ->whereHas('bachiller_grupo',function($query) use($inscritoExt){
                        $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id);
                    })
                    ->first();
    
                    // aun no hay tabla pendiente
                    if($inscrito){
                        $calificaciones = Bachiller_inscritos::where('id',$inscrito->id)
                            ->first();
                        if(!$calificaciones->insCalificacionOrdinario){
                            $aceptadaSinOrdinario = true;
                        }
                    }else{
                        $aceptadaSinOrdinario = true;
                    }
    
                    $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                        ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id)
                        ->where('histTipoAcreditacion','O2')->get();
                    if(count($historicosX2) > 0){
                        $ultOportunidad = true;
                    }
    
                }else{
                    //Chetumal
                    $inscrito = Bachiller_cch_inscritos::with('curso','bachiller_cch_grupo')
                    ->whereHas('curso',function($query) use($inscritoExt){
                        $query->where('alumno_id',$inscritoExt->alumno_id);
                    })
                    ->whereHas('bachiller_cch_grupo',function($query) use($inscritoExt){
                        $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id);
                    })
                    ->first();
                    if($inscrito){
                        $calificaciones = Bachiller_cch_inscritos::where('id',$inscrito->id)
                            ->first();
                        if(!$calificaciones->insCalificacionOrdinario){
                            $aceptadaSinOrdinario = true;
                        }
                    }else{
                        $aceptadaSinOrdinario = true;
                    }
    
                    $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                        ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id)
                        ->where('histTipoAcreditacion','X2')->get();
                    if(count($historicosX2) > 0){
                        $ultOportunidad = true;
                    }
                }
    
                if($extraUpdated){
                    alert('Escuela Modelo', 'La solicitud de recuperativo se ha guardado correctamente', 'success')->showConfirmButton();
                }else{
                    alert('Escuela Modelo', 'La solicitud de recuperativo se ha
                        guardado correctamente, pero el Recuperativo no fue actualizado'
                        , 'warning')
                    ->showConfirmButton();
                }
    
                // Unix
                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');
                //Nombre del archivo PDF de descarga
                $nombreArchivo = "pdf_recibo_extraordinario";
                //Cargar vista del PDF
                $pdf = PDF::loadView("bachiller.extraordinario.pdf.pdf_recibo_extraordinario",[
                "inscritoExt" => $inscritoExt,
                "pagoLetras" => $pagoLetras,
                "aceptadaSinOrdinario" => $aceptadaSinOrdinario,
                "ultOportunidad" => $ultOportunidad,
                "fechaActual" => $this->dateDMY($fechaActual),
                "horaActual" => $fechaActual->format('H:i:s'),
                "nombreArchivo" => 'pdf_curso_regularizacion',
                'img' => public_path() . "/images/logo-pago.jpg",
                'alt' => 'logo',
                'extraordinario' => $extraordinario
                ]);
                $pdf->setPaper('letter', 'portrait');
                $pdf->defaultFont = 'Times Sans Serif';
                return $pdf->stream($nombreArchivo . '.pdf');
    
                // return redirect()->back();
    
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
    
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect()->back()->withInput();
            }
        }else{
            alert()->info('Escuela Modelo', "El grupo de ".$extraordinario->extTipo. " ha alcanzado el maximo de alumnos a inscribir")->showConfirmButton();
            return redirect()->back();
        }

        
    }

    public function generarRecuprativoPDF($extraordinario_id)
    {
        $extraordinario = Bachiller_extraordinarios::find($extraordinario_id);
        //
        $alumno = Alumno::where('aluClave', Auth::user()->username)->first();
        $alumno_id = $alumno->id;
        // 
        $inscritoExt = Bachiller_inscritosextraordinarios::where('alumno_id', $alumno_id)->where('extraordinario_id', '=', $extraordinario_id)->first();
        //
        $fechaActual = Carbon::now('CDT');
        $aceptadaSinOrdinario = false;
        $ultOportunidad = false;
        //
        $results = DB::select(DB::raw("SELECT
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
        );"));
        $cursos = collect($results)->first();
        $curso = Curso::with("alumno.persona", "periodo.departamento.ubicacion", "cgt.plan.programa")
                 ->where("id", $cursos->cursos_id)->first();
        $ubicacion = $curso ? $curso->periodo->departamento->ubicacion : null;
        $ubicacion_id = $ubicacion->id;
        //
        if($ubicacion_id == 1 || $ubicacion_id == 2 || $ubicacion_id == 4){
            //Yucatán
            $inscrito = Bachiller_inscritos::with('curso','bachiller_grupo')
            ->whereHas('curso',function($query) use($inscritoExt){
                $query->where('alumno_id',$inscritoExt->alumno_id);
            })
            ->whereHas('bachiller_grupo',function($query) use($inscritoExt){
                $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id);
            })
            ->first();

            // aun no hay tabla pendiente
            if($inscrito){
                $calificaciones = Bachiller_inscritos::where('id',$inscrito->id)
                    ->first();
                if(!$calificaciones->insCalificacionOrdinario){
                    $aceptadaSinOrdinario = true;
                }
            }else{
                $aceptadaSinOrdinario = true;
            }

            $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id)
                ->where('histTipoAcreditacion','X2')->get();
            if(count($historicosX2) > 0){
                $ultOportunidad = true;
            }

        }else{
            //Chetumal
            $inscrito = Bachiller_cch_inscritos::with('curso','bachiller_cch_grupo')
            ->whereHas('curso',function($query) use($inscritoExt){
                $query->where('alumno_id',$inscritoExt->alumno_id);
            })
            ->whereHas('bachiller_cch_grupo',function($query) use($inscritoExt){
                $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id);
            })
            ->first();
            if($inscrito){
                $calificaciones = Bachiller_cch_inscritos::where('id',$inscrito->id)
                    ->first();
                if(!$calificaciones->insCalificacionOrdinario){
                    $aceptadaSinOrdinario = true;
                }
            }else{
                $aceptadaSinOrdinario = true;
            }

            $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id)
                ->where('histTipoAcreditacion','X2')->get();
            if(count($historicosX2) > 0){
                $ultOportunidad = true;
            }
        }
        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_recibo_extraordinario";
        //Cargar vista del PDF
        $pdf = PDF::loadView("bachiller.extraordinario.pdf.pdf_recibo_extraordinario",[
        "inscritoExt" => $inscritoExt,
        "aceptadaSinOrdinario" => $aceptadaSinOrdinario,
        "ultOportunidad" => $ultOportunidad,
        "fechaActual" => $this->dateDMY($fechaActual),
        "horaActual" => $fechaActual->format('H:i:s'),
        "nombreArchivo" => 'pdf_curso_regularizacion',
        'img' => public_path() . "/images/logo-pago.jpg",
        'alt' => 'logo',
        'extraordinario' => $extraordinario
        ]);
        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo . '.pdf');
    }


    public function solicitudStore(Request $request)
    {
        $fechaActual = Carbon::now('CDT');
        $aceptadaSinOrdinario = false;
        $ultOportunidad = false;


        $validator = Validator::make($request->all(),
            [
                'alumno_id'         => 'required',
                'iexEstado'         => 'required',
                'extraordinario_id' => 'required',

            ],
            [
                'alumno_id.required'         => "El alumno es requerido",
                'iexEstado.required'         => "El estatus de pago es requerido",
                'extraordinario_id.required' => "El folio extraordinario es requerido"
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /**
        * Si el alumno está inscrito a un extra con la misma fecha, no puede inscribirse a este extra.
        */
        $extraordinario = Bachiller_extraordinarios::find($request->extraordinario_id);
        $fechaOcupada = Bachiller_inscritosextraordinarios::where('alumno_id', $request->alumno_id)
        ->whereDate('iexFecha', '=', $extraordinario->extFecha)->get();
        if($fechaOcupada->isNotEmpty()) {
            alert()->warning('No se puede procesar la Solicitud', 'El alumno ya tiene un examen para esa misma fecha.')->showConfirmButton();
            return back()->withInput();
        }

        try {

            $inscritoExt = New Bachiller_inscritosextraordinarios;
            $inscritoExt->alumno_id = $request->alumno_id;
            $inscritoExt->extraordinario_id = $request->extraordinario_id;
            $inscritoExt->iexFecha = $request->iexFecha;
            $inscritoExt->iexCalificacion = NULL;
            $inscritoExt->iexEstado = $request->iexEstado;
            $inscritoExt->iexFolioHistorico = NULL;
            $inscritoExt->save();

            $extra = $inscritoExt->bachiller_extraordinario;
            $extraUpdated = $this->updateNumInscritosExtra($extra);

            $extPago = $inscritoExt->bachiller_extraordinario->extPago;
            $pagoLetras = NumeroALetras::convert($extPago,'PESOS',true);

            if($request->ubicacion_id == 1 || $request->ubicacion_id == 2 || $request->ubicacion_id == 4){
                //Yucatán
                $inscrito = Bachiller_inscritos::with('curso','bachiller_grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('bachiller_grupo',function($query) use($inscritoExt){
                    $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id);
                })
                ->first();

                // aun no hay tabla pendiente
                if($inscrito){
                    $calificaciones = Bachiller_inscritos::where('id',$inscrito->id)
                        ->first();
                    if(!$calificaciones->insCalificacionOrdinario){
                        $aceptadaSinOrdinario = true;
                    }
                }else{
                    $aceptadaSinOrdinario = true;
                }

                $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                    ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id)
                    ->where('histTipoAcreditacion','X2')->get();
                if(count($historicosX2) > 0){
                    $ultOportunidad = true;
                }

            }else{
                //Chetumal
                $inscrito = Bachiller_cch_inscritos::with('curso','bachiller_cch_grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('bachiller_cch_grupo',function($query) use($inscritoExt){
                    $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id);
                })
                ->first();
                if($inscrito){
                    $calificaciones = Bachiller_cch_inscritos::where('id',$inscrito->id)
                        ->first();
                    if(!$calificaciones->insCalificacionOrdinario){
                        $aceptadaSinOrdinario = true;
                    }
                }else{
                    $aceptadaSinOrdinario = true;
                }

                $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                    ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->materia_id)
                    ->where('histTipoAcreditacion','X2')->get();
                if(count($historicosX2) > 0){
                    $ultOportunidad = true;
                }

            }



            if($extraUpdated){
                alert('Escuela Modelo', 'La solicitud de recuperativo se ha guardado correctamente', 'success')->showConfirmButton();
            }else{
                alert('Escuela Modelo', 'La solicitud de recuperativo se ha
                    guardado correctamente, pero el Recuperativo no fue actualizado'
                    , 'warning')
                ->showConfirmButton();
            }

            // Unix
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');
            //Nombre del archivo PDF de descarga
            $nombreArchivo = "pdf_recibo_extraordinario";
            //Cargar vista del PDF
            $pdf = PDF::loadView("bachiller.extraordinario.pdf.pdf_recibo_extraordinario",[
            "inscritoExt" => $inscritoExt,
            "pagoLetras" => $pagoLetras,
            "aceptadaSinOrdinario" => $aceptadaSinOrdinario,
            "ultOportunidad" => $ultOportunidad,
            "fechaActual" => $this->dateDMY($fechaActual),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo
            ]);
            $pdf->setPaper('letter', 'portrait');
            $pdf->defaultFont = 'Times Sans Serif';
            // return $pdf->stream($nombreArchivo . '.pdf');

            return redirect()->back();

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
    }




    /**
     * Show the form for edit a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudShow($id)
    {
        $solicitud = Bachiller_inscritosextraordinarios::with('bachiller_extraordinario')->findOrFail($id);
        $iexEstado = ESTADO_SOLICITUD;
        return view('bachiller.extraordinario.show-solicitud', compact('solicitud', 'iexEstado'));
    }


    /**
     * Show the form for edit a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudEdit($id)
    {
        $solicitud = Bachiller_inscritosextraordinarios::with('bachiller_extraordinario')->findOrFail($id);
        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('solicitud_extraordinario', $solicitud->bachiller_extraordinario->bachiller_materia->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('solicitudes/bachiller_recuperativos');
        } else {
            $iexEstado = ESTADO_SOLICITUD;
            return view('bachiller.extraordinario.edit-solicitud', compact('solicitud', 'iexEstado'));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudUpdate(Request $request, $id)
    {
        try {
            $inscritoExtraordinario = Bachiller_inscritosextraordinarios::findOrFail($id);
            $inscritoExtraordinario->iexCalificacion    = $request->input('iexCalificacion');
            $inscritoExtraordinario->iexEstado          = $request->input('iexEstado');
            $inscritoExtraordinario->iexTipoPago          = $request->input('iexTipoPago');
            $inscritoExtraordinario->save();

            $extra = $inscritoExtraordinario->bachiller_extraordinario;
            $extraUpdated = $this->updateNumInscritosExtra($extra);

            if($extraUpdated){
            alert('Escuela Modelo', 'La solicitud del recuperativo se ha actualizado con éxito', 'success')->showConfirmButton();
            }else{
                alert('Escuela Modelo', 'La solicitud del recuperativo se ha
                        actualizado correctamente, pero el Recuperativo no fue
                        actualizado'
                        , 'warning')
                    ->showConfirmButton();
            }

            return redirect('solicitudes/bachiller_recuperativos');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('edit/bachiller_solicitud/' . $id)->withInput();
        }
    }


    public function solicitudCancelar(Request $request)
    {
        try {
            $inscritoExtraordinario = Bachiller_inscritosextraordinarios::findOrFail($request->id);
            $inscritoExtraordinario->iexEstado = "C";
            $inscritoExtraordinario->save();

            $extra = $inscritoExtraordinario->bachiller_extraordinario;
            $extraUpdated = $this->updateNumInscritosExtra($extra);

            if($extraUpdated){
                alert('Escuela Modelo', 'La solicitud del recuperativo se ha
                 cancelado con éxito', 'success')->showConfirmButton();
            }else{
                alert('Escuela Modelo', 'La solicitud del recuperativo se ha
                    cancelado correctamente, pero el Recuperativo no fue
                    actualizado'
                    , 'warning')
                ->showConfirmButton();
            }

            return redirect('solicitudes/bachiller_recuperativos');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect()->back()->withInput();
        }
    }

    public function solicitudRecibo(Request $request){

        $fechaActual = Carbon::now('CDT');
        $aceptadaSinOrdinario = false;
        $ultOportunidad = false;

        try {
            $inscritoExt = Bachiller_inscritosextraordinarios::findOrFail($request->id);

            $extPago = $inscritoExt->bachiller_extraordinario->extPago;
            $pagoLetras = NumeroALetras::convert($extPago,'PESOS',true);

            if($request->ubicacion_id == 1 || $request->ubicacion_id == 2 || $request->ubicacion_id == 4){
                $inscrito = Bachiller_inscritos::with('curso','bachiller_grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('bachiller_grupo',function($query) use($inscritoExt){
                    $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->bachiller_materia_id);
                })
                ->first();
                // Pendiente
                if($inscrito){
                    $calificaciones = Bachiller_inscritos::where('id',$inscrito->id)
                        ->first();
                    if(!$calificaciones->insCalificacionOrdinario){
                        $aceptadaSinOrdinario = true;
                    }
                }
            }else{
                // Chetumal
                $inscrito = Bachiller_cch_inscritos::with('curso','bachiller_cch_grupo')
                ->whereHas('curso',function($query) use($inscritoExt){
                    $query->where('alumno_id',$inscritoExt->alumno_id);
                })
                ->whereHas('bachiller_cch_grupo',function($query) use($inscritoExt){
                    $query->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->bachiller_materia_id);
                })
                ->first();
                if($inscrito){
                    $calificaciones = Bachiller_cch_inscritos::where('id',$inscrito->id)
                        ->first();
                    if(!$calificaciones->insCalificacionOrdinario){
                        $aceptadaSinOrdinario = true;
                    }
                }
            }


            $historicosX2 = Bachiller_historico::where('alumno_id',$inscritoExt->alumno_id)
                ->where('bachiller_materia_id',$inscritoExt->bachiller_extraordinario->bachiller_materia_id)
                ->where('histTipoAcreditacion','O2')->get();
            if(count($historicosX2) > 0){
                $ultOportunidad = true;
            }


            alert('Escuela Modelo', 'La solicitud del recuperativo se ha guardado correctamente', 'success')->showConfirmButton();

            // Unix
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');
            //Nombre del archivo PDF de descarga
            $nombreArchivo = "pdf_recibo_extraordinario";
            //Cargar vista del PDF
            $pdf = PDF::loadView("bachiller.extraordinario.pdf.pdf_recibo_extraordinario",[
            "inscritoExt" => $inscritoExt,
            "pagoLetras" => $pagoLetras,
            "aceptadaSinOrdinario" => $aceptadaSinOrdinario,
            "ultOportunidad" => $ultOportunidad,
            "fechaActual" => $this->dateDMY($fechaActual),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo
            ]);
            $pdf->setPaper('letter', 'portrait');
            $pdf->defaultFont = 'Times Sans Serif';
            return $pdf->stream($nombreArchivo . '.pdf');


        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
    }

    public function actaExamen($id){

        $extraordinario = Bachiller_extraordinarios::find($id);
        $inscritos = Bachiller_inscritosextraordinarios::where('extraordinario_id',$extraordinario->id)
        // ->where('iexEstado', 'P')
        ->get();

        // mio
        $periodoAnio = Periodo::find($extraordinario->periodo_id);
        $bachiller_materia = Bachiller_materias::find($extraordinario->bachiller_materia_id);



        if($inscritos->isEmpty()) {
            alert()->error('Error', 'No existen registros con la información proporcionada')->showConfirmButton();
                return back()->withInput();
        }

        $inscritoIds = $inscritos->map(function($item,$key){
            return $item->id;
        });

        $inscritoEx = collect();
        $fechaActual = Carbon::now();
        $periodo = '';

        foreach($inscritoIds as $inscrito_id){
            $inscrito = Bachiller_inscritosextraordinarios::where('id', '=', $inscrito_id)->first();
            $idExtra = $inscrito->bachiller_extraordinario->id;
            $iexEstado = $inscrito->iexEstado;


            //Datos del alumno
            $aluClave = $inscrito->alumno->aluClave;
            $perApellido1 = $inscrito->alumno->persona->perApellido1;
            $perApellido2 = $inscrito->alumno->persona->perApellido2;
            $perNombre = $inscrito->alumno->persona->perNombre;
            $alumnoNombre = $perApellido1.' '.$perApellido2.' '.$perNombre;
            //Datos del empleado (maestro)
             $perApellido1Emp = $inscrito->bachiller_extraordinario->bachiller_empleado->empApellido1;
            $perApellido2Emp = $inscrito->bachiller_extraordinario->bachiller_empleado->empApellido2;
            $perNombreEmp = $inscrito->bachiller_extraordinario->bachiller_empleado->empNombre;
            $empleadoNombre = $perNombreEmp.' '.$perApellido1Emp.' '.$perApellido2Emp;
            $empleadoId = $inscrito->bachiller_extraordinario->empleado_id;
            //Datos de la secretaria administrativa
            $depTituloDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depTituloDoc;
            $depNombreDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depNombreDoc;
            $depPuestoDoc = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->depPuestoDoc;

            $iexCalificacion = $inscrito->iexCalificacion;
            $planClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->planClave;
            $progClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->progClave;
            $progNombre = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->progNombre;
            $ubiClave = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiClave;
            $ubiNombre = $inscrito->bachiller_extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiNombre;
            $matClave = $inscrito->bachiller_extraordinario->bachiller_materia->matClave;
            $matNombre = $inscrito->bachiller_extraordinario->bachiller_materia->matNombre;
            $extClave = $inscrito->bachiller_extraordinario->id;
            $extFecha = $inscrito->bachiller_extraordinario->extFecha;
            $extHora = $inscrito->bachiller_extraordinario->extHora;
            $extGrupo = $inscrito->bachiller_extraordinario->extGrupo;
            $califLetras = $iexCalificacion === null ? '' : str_replace(" CON 00/100","",NumeroALetras::convert($iexCalificacion));

            if($inscrito->bachiller_extraordinario->bachiller_materia->esAlfabetica()) {
              $califLetras = $iexCalificacion == 0 ? 'APROBADO' : 'NO APROBADO';
              $iexCalificacion = $iexCalificacion == 0 ? 'A' : 'NA';
            }



            // $optativa = Optativa::where('id',$inscrito->bachiller_extraordinario->optativa_id)->first();

            $inscritoEx->push([
              'idExtra'=>$idExtra,
              'aluClave'=>$aluClave,
              'perApellido1'=>$perApellido1,
              'alumnoNombre'=>$alumnoNombre,
              'empleadoNombre'=>$empleadoNombre,
              'empleadoId'=>$empleadoId,
              'depTituloDoc'=>$depTituloDoc,
              'depNombreDoc'=>$depNombreDoc,
              'depPuestoDoc'=>$depPuestoDoc,
              'iexCalificacion'=>$iexCalificacion,
              'califLetras'=>$califLetras,
              'progClave'=>$progClave,
              'progNombre'=>$progNombre,
              'matClave'=>$matClave,
              'planClave'=>$planClave,
              'matNombre'=>$matNombre,
              'extClave'=>$extClave,
              'extFecha'=>$extFecha,
              'extHora'=>$extHora,
              'extGrupo'=>$extGrupo,
              'ubiClave'=>$ubiClave,
            //   'optativa'=>$optativa,
              'ubiNombre'=>$ubiNombre,
              'iexEstado' => $iexEstado
            ]);

          }

            //   recorremos el array para ir agregando y porder actualizar el iexEstado a PAGADO
            foreach (collect($inscritoEx) as $key => $value) {

                $clave_pago = $value["aluClave"];
                // MetodosPagoExtras::actualizaEstadoPago($periodoAnio->perAnioPago,$clave_pago,$bachiller_materia->matSemestre,$periodoAnio->perNumero,$extraordinario->id);


                // $ejecutar_SP = DB::select("call procBachillerActualizaEstadoRecuperativo(".$periodoAnio->perAnioPago.",
                // ".$clave_pago.", ".$bachiller_materia->matSemestre.", ".$periodoAnio->perNumero.", ".$extraordinario->id.")");
            }


          $inscritoEx = $inscritoEx->sortBy('perApellido1');
          $inscritoEx = $inscritoEx->groupBy('idExtra');

          setlocale(LC_TIME, 'es_ES.UTF-8');
          // En windows
          setlocale(LC_TIME, 'spanish');
          $nombreArchivo = 'pdf_acta_extraordinario';
          $pdf = PDF::loadView('reportes.pdf.bachiller.'. $nombreArchivo, [

            "inscritoEx" => $inscritoEx,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo,
            "periodo" => $periodo,
            "peridoPago" => $periodoAnio->perAnioPago,
            "extraordinario_id" => $extraordinario->id
            /*
            "nombreArchivo" => $nombreArchivo,
            "aluEstado" => $request->aluEstado,
            "fechaActual" => $fechaActual->toDateString(),
            "horaActual" => $fechaActual->toTimeString()
            */
          ]);


          $pdf->setPaper('letter', 'portrait');
          $pdf->defaultFont = 'Times Sans Serif';

          return $pdf->stream($nombreArchivo . '.pdf');

    }

    public function validarAlumno($aluClave){

        $alumno = Alumno::where('aluClave',$aluClave)->first();
        $curso = Curso::with('cgt.plan.programa.escuela.departamento.ubicacion')->where('alumno_id',$alumno->id)
        ->where('curEstado','<>','B')->latest('curFechaRegistro')->first();

        $departamento = $curso->cgt->plan->programa->escuela->departamento;

        $periodo = Periodo::find($departamento->perActual);

        // $inscritoExtraordinario = InscritoExtraordinario::with('extraordinarios')
        // ->whereHas('extraordinarios',function($query) use ($departamento){
        //     $query->where('periodo_id',$departamento->perActual);
        // })
        // ->where('alumno_id',$alumno->id)->get();

        // $extras = $inscritoExtraordinario->filter(function($item,$key) use($departamento){
        //    return $item->iexCalificacion < $departamento->depCalMinAprob;
        // });

        $extras = Bachiller_inscritosextraordinarios::select(
            'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extAlumnosInscritos',
            'bachiller_extraordinarios.extPago','bachiller_inscritosextraordinarios.iexFecha','bachiller_extraordinarios.extHora',
            'periodos.perNumero','periodos.perAnio','bachiller_materias.matClave','bachiller_materias.matNombreOficial as matNombre',
            'bachiller_empleados.empNombre as perNombre','bachiller_empleados.empApellido1 as perApellido1','bachiller_empleados.empApellido2 as perApellido2','planes.planClave',
            'programas.progNombre','ubicacion.ubiNombre','bachiller_inscritosextraordinarios.iexCalificacion')
            ->join('bachiller_extraordinarios', 'bachiller_inscritosextraordinarios.extraordinario_id', '=', 'bachiller_extraordinarios.id')
            ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            // ->leftJoin('aulas', 'bachiller_extraordinarios.aula_id', '=', 'aulas.id')
            ->join('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
            // ->join('personas', 'empleados.persona_id', '=', 'personas.id')
            // ->leftjoin('optativas','bachiller_extraordinarios.optativa_id','optativas.id')
            // ->where('periodo.id',$departamento->perActual)
            ->where('bachiller_inscritosextraordinarios.iexCalificacion','<',$departamento->depCalMinAprob)
            ->whereBetween('bachiller_inscritosextraordinarios.iexFecha',[$periodo->perFechaInicial,$periodo->perFechaFinal])
            ->where('bachiller_inscritosextraordinarios.alumno_id',$alumno->id);


        return Datatables::of($extras)
        ->filterColumn('nombreCompleto',function($query, $keyword) {
            return $query->whereHas('empleado.persona', function($query) use($keyword) {
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            });
        })
        ->addColumn('nombreCompleto',function($query) {
            return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
        })
        ->addColumn('iexFecha',function($query) {
            return Utils::fecha_string($query->iexFecha,true);
        })
        ->addColumn('iexCalificacion',function($query){
            switch ($query->iexCalificacion) {
                case -1:
                return 'NPE';
                break;

                case -2:
                return 'SD';
                break;

                case -3:
                return 'Npa';
                break;

                default:
                return $query->iexCalificacion;
                break;
            }
        })
        ->make(true);

    }

    public function agregarExtra($extraordinario_id)
    {
        //OBTENER Extraordinario e inscritos
        $extraordinario  = Bachiller_extraordinarios::with('bachiller_materia.plan.programa','periodo','bachiller_empleado')->find($extraordinario_id);
        $inscritoextra  = Bachiller_inscritosextraordinarios::with('alumno.persona')->where('extraordinario_id',$extraordinario_id)->where('iexEstado','!=','C')->get();

        $periodo = Periodo::find($extraordinario->periodo_id);
        $semestre = $extraordinario->bachiller_materia->matSemestre;
        $perNumero = $extraordinario->periodo->perNumero;

        // actualiza el iexEstado
        foreach ($inscritoextra as $key => $value) {
            $clave_pago = $value->alumno->aluClave;
            // $ejecutar_SP = DB::select("call procBachillerActualizaEstadoRecuperativo(".$periodo->perAnioPago.",
            // ".$clave_pago.", ".$semestre.", ".$perNumero.", ".$extraordinario->id.")");
        }


        $inscritos = $inscritoextra->map(function ($item, $key) {
            $item->sortByNombres = $item->alumno->persona->perApellido1 . "-" .
            $item->alumno->persona->perApellido2  . "-" .
            $item->alumno->persona->perNombre;
            $item->iexEstado;

            return $item;
        })->sortBy("sortByNombres");

        $motivosFalta = DB::table("motivosfalta")->get()->sortByDesc("id");



        return view('bachiller.calificaciones_chetumal.extraordinario.create',compact('extraordinario','inscritos', 'motivosFalta', 'periodo'));

    }

    public function extraStore(Request $request)
    {
        $extraordinario_id = $request->extraordinario_id;
        //OBTENER Inscritos Extraordinarios
        $extraordinario  = Bachiller_extraordinarios::with('bachiller_materia.plan.programa','periodo','bachiller_empleado')->find($extraordinario_id);
        $inscritoextra  = Bachiller_inscritosextraordinarios::with('alumno.persona')->where('extraordinario_id',$extraordinario_id)->where('iexEstado','!=','C')->get();


        try {

            $calificacion = $request->calificacion;

            $inscEx  = $request->has("calificacion.inscEx")  ? collect($calificacion["inscEx"])  : collect();
            $asistencia = $request->has("calificacion.asistencia")  ? collect($calificacion["asistencia"])  : collect();

            foreach ($inscritoextra as $inscrito) {
                $inscritoEx  = Bachiller_inscritosextraordinarios::find($inscrito->id);
                $calificacionEx = $inscEx->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();

                $miAsistencia = $asistencia->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();



                if ($miAsistencia != 10) {
                    $calificacionEx = 0;
                }

                if ($inscritoEx) {
                    $inscritoEx->iexCalificacion  = !is_null($calificacionEx) ? $calificacionEx  : $inscritoEx->iexCalificacion;
                    $inscritoEx->motivofalta_id = $miAsistencia;
                    $inscritoEx->save();
                }
            }

            alert('Escuela Modelo', 'Se registraron las calificaciones con éxito', 'success')->showConfirmButton();
            return redirect('bachiller_calificacion/agregarextra/' . $extraordinario_id)->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('bachiller_calificacion/agregarextra/' . $extraordinario_id)->withInput();
        }
    }

    public function crearReporte()
    {
        // Mostrar el conmbo solo las ubicaciones correspondientes
    if (auth()->user()->campus_cme == 1 || auth()->user()->campus_cva == 1) {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
      }

      if (auth()->user()->campus_cch == 1) {
        $ubicaciones = Ubicacion::where('id', 3)->get();
      }
        return view('bachiller.extraordinario.create-extraordinario-reporte', compact('ubicaciones'));
    }

    public function generarReporte(Request $request){
        $fechaActual = Carbon::now();

        $bachillerExtra = Bachiller_extraordinarios::select(
            'bachiller_extraordinarios.id as extraordinario_id','bachiller_extraordinarios.extAlumnosInscritos',
            'bachiller_extraordinarios.extPago','bachiller_extraordinarios.extFecha','bachiller_extraordinarios.extHora',
            'periodos.perNumero','periodos.perAnio','bachiller_materias.matClave','bachiller_materias.matNombreOficial as matNombre',
            'bachiller_empleados.empNombre as perNombre','bachiller_empleados.empApellido1 as perApellido1','bachiller_empleados.empApellido2 as perApellido2','planes.planClave',
            'programas.progClave','ubicacion.ubiClave', 'empleadoAux.empApellido1', 'empleadoAux.empApellido2', 'empleadoAux.empNombre')
            ->join('periodos', 'bachiller_extraordinarios.periodo_id', '=', 'periodos.id')
            ->join('bachiller_materias', 'bachiller_extraordinarios.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('bachiller_empleados', 'bachiller_extraordinarios.bachiller_empleado_id', '=', 'bachiller_empleados.id')
            ->leftJoin('bachiller_empleados as empleadoAux', 'bachiller_extraordinarios.bachiller_empleado_sinodal_id', '=', 'empleadoAux.id')
            ->whereNull('bachiller_extraordinarios.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('bachiller_materias.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('escuelas.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->whereNull('bachiller_empleados.deleted_at');

        if ($request->ubicacion_id) {
            $bachillerExtra->where('ubicacion.id', $request->ubicacion_id);
        }
        if ($request->departamento_id) {
            $bachillerExtra->where('departamentos.id', $request->departamento_id);
        }
        if ($request->periodo_id) {
            $bachillerExtra->where('periodos.id', $request->periodo_id);
        }
        if ($request->escuela_id) {
            $bachillerExtra->where('escuelas.id', $request->escuela_id);
        }
        if ($request->programa_id) {
            $bachillerExtra->where('programas.id', $request->programa_id);
        }
        if ($request->plan_id) {
            $bachillerExtra->where('planes.id', $request->plan_id);
        }

        $bachillerExtra = $bachillerExtra->get();

        if($bachillerExtra->isEmpty()) {
            alert()->error('Error', 'No existen registros con la información proporcionada')->showConfirmButton();
                return back()->withInput();
        }

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $nombreArchivo = "pdf_reporte_extraordinario";
        //Cargar vista del PDF
        $pdf = PDF::loadView("reportes.pdf.bachiller.reporte_extraordinario.".$nombreArchivo,[
        "bachillerExtra" => $bachillerExtra,
        "fechaActual" => $this->dateDMY($fechaActual),
        "horaActual" => $fechaActual->format('H:i:s'),
        "nombreArchivo" => $nombreArchivo
        ]);
        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo . '.pdf');
    }
}
