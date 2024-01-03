<?php

namespace App\Http\Controllers;

use App\Http\Helpers\GenerarReferencia;
use App\Http\Helpers\Utils;
use App\Models\Ficha;
use App\Models\InscritoExtraordinario;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Extraordinario;
use App\Models\Departamento;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\ConceptoPago;
use App\Models\Cuota;
use App\Models\PreinscritoExtraordinario;
use App\Models\Convenio;
use App\Models\Materia;
use App\Models\Portal_configuracion;
use App\Models\CalendarioExamen;
use Illuminate\Support\Facades\Auth;
use App\clases\personas\MetodosPersonas;
use App\clases\InscripcionExtraordinario\Notificacion;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

use DB;
use Exception;

class InscribirseExtraordinarioController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = Portal_configuracion::Where('pcClave', 'EXTRAORDINARIOS_ACTIVOS')->first();
        $EXTRAORDINARIOS_ACTIVOS = $config->pcEstado == 'A' ? true: false;
        if(!$EXTRAORDINARIOS_ACTIVOS) {
            alert('Módulo Inactivo', 'El módulo al que desea ingresar se encuentra temporalmente inactivo.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        //$this->depurando();
        $aluClave = Auth::user()->username;
        $alumno = Alumno::where('aluClave', $aluClave)->first();
        $persona = $alumno->persona;

        //ES DEUDOR, NO PUEDE PRESENTAR
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $temporary_table_name = "_palum3_". substr(str_shuffle($permitted_chars), 0, 15);
        $pagos = DB::select("call procDeudasAlumnoParaExtrasOmicron("
            ."1"

            .",".$alumno->aluClave
            .","."'I'"

            .",'".$temporary_table_name."')");
        $pago = DB::table($temporary_table_name)->where("cve_fila", "=", "TL$")->first();
        $concepto = DB::table("conceptospago")->where("conpClave", "=", $pago->conc_pago)->first();
        // $pagos = collect( $datatable_array );
        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );


        $reprobadas = $this->reprobadas_alumno($alumno);
        $reprobadasSinEduVida = $this->reprobadas_alumno_SINEDUVIDA($alumno);

        //SI NO HAY EXTRAS SE ENVIA NOTIFICACION, ENTRANDO A LA PANTALLA
        $reprobadasSinExtras = $this->obtenerMateriasReprobadasSinExtraordinarioAgendado($reprobadas);
        $ultimoCurso = $alumno->cursos()->with('cgt.plan.programa.escuela')->latest('curFechaRegistro')->first();
        if($reprobadasSinExtras->isNotEmpty()) {
            try {
                $notificacion = new Notificacion($ultimoCurso);
                $notificacion->reprobadasSinExtraordinario($reprobadasSinExtras);
            } catch (Exception $e) {}
        }

        //REPROBADAS URGENTES SIN EXTRA
        //$reprobadas_urgentes = $reprobadas->where('matSemestre', '<=', intval($ultimoCurso->cgt->cgtGradoSemestre) - 2);
        $reprobadas_urgentes = $reprobadas->filter(static function($reprobada) {
            return $reprobada->maxSemestre - $reprobada->matSemestre > 1;
        });
        $reprobadasUrgentesSinExtras = $this->obtenerMateriasReprobadasSinExtraordinarioAgendado($reprobadas_urgentes);

        //SI NO HAY EXTRAS, BRINCANDO MATERIAS DE EDUCACION PARA LA VIDA
        $reprobadasSinExtrasSinEduVida = $this->obtenerMateriasReprobadasSinExtraordinarioAgendado($reprobadasSinEduVida);


        //TIPO DE INGRESO , BUSCANDO EQ
        $procTipoIngreso = \Illuminate\Support\Facades\DB::select("call procPortalAlumnosInscritoTipoIngreso(" . $aluClave . ")");
        if ($procTipoIngreso) {
            $curTipoIngreso = $procTipoIngreso[0]->curTipoIngreso;
        }
        else
        {
            $curTipoIngreso = 'RI'; // RI por default si no hay valor en curTipoIngreso
        }

        return view('inscribir_extraordinario.show-list',
            compact('alumno', 'persona', 'reprobadas',
                'reprobadasSinExtras', 'reprobadasUrgentesSinExtras',
                'reprobadasSinExtrasSinEduVida',
                'pago', 'curTipoIngreso'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function depurando()
    {
        $aluClave = Auth::user()->username;
        $alumno = Alumno::where('aluClave', $aluClave)->first();

        $curso = $alumno->cursos()->where('curEstado', 'R')
            ->whereNull('deleted_at')
            ->orderBy("curFechaRegistro", "desc")
            ->latest()->first();
        $departamento = $curso->periodo->departamento;

        $extraordinarios_todos = Extraordinario::with(['periodo', 'materia.plan.programa.escuela.departamento.ubicacion', 'empleado.persona'])
            ->where('periodo_id', $departamento->periodoActual->id)->get();
        $reprobadas = $this->reprobadas_alumno($alumno);

        if($reprobadas->isNotEmpty())
        {
            $extraordinarios = $this->ordenar_reprobadas_primero($reprobadas, $extraordinarios_todos);

            if($extraordinarios->isEmpty())
            {
                alert()->error('Aviso', 'Usted tiene materias adeudadas que necesita presentar. Favor de comunicarse a la brevedad con su Coordinador de Carrera para solicitar el examen extraordinario en las fechas indicadas para el periodo en curso.')->showConfirmButton();
                return back()->withInput();
            }

        }
        else
        {
            $extraordinarios = Extraordinario::with(['periodo', 'materia.plan.programa.escuela.departamento.ubicacion', 'empleado.persona'])
                ->where('periodo_id', '0')->get();
        }

        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $alumno = Alumno::findOrFail($request->alumno_id);
        $ultimoCurso = $alumno->cursos()->with('cgt.plan.programa.escuela', 'periodo.departamento')
        ->whereHas('periodo.departamento', function($query) {
            $query->where('depClave', Auth::user()->depClave);
        })->latest('curFechaRegistro')->first();
        $extras = Extraordinario::whereIn('id', $request->extraordinarios_id)->get();
        $verificaextras = Extraordinario::whereIn('id', $request->extraordinarios_id)->get();
        $verificamaterias = Extraordinario::whereIn('id', $request->extraordinarios_id)->get();
        $extraordinarios = Extraordinario::whereIn('id', $request->extraordinarios_id)->get()->pluck('extFecha');

        $verificapreinscripcion = PreinscritoExtraordinario::whereIn('extraordinario_id', $request->extraordinarios_id)
            ->where('alumno_id', $request->alumno_id)->get();
        
        $verificaFechaPreinscripcion = PreinscritoExtraordinario::whereIn('extFecha', $extraordinarios->toArray())
            ->where('alumno_id', $request->alumno_id)->get();

        $verificainscripcion = InscritoExtraordinario::whereIn('extraordinario_id', $request->extraordinarios_id)
            ->where('alumno_id', $request->alumno_id)->get();

        $verificaFechaInscripcion = InscritoExtraordinario::whereIn('iexFecha', $extraordinarios->toArray())
            ->where('alumno_id', $request->alumno_id)->get();

        $total_a_pagar = $request->total_a_pagar;

        $reprobadas = $this->reprobadas_alumno($alumno);
        $reprobadasSinExtras = $this->obtenerMateriasReprobadasSinExtraordinarioAgendado($reprobadas);
        //REPROBADAS SIN EXAMEN, YA NO ES NECESARIO AQUI, SE ENVIA DESDE LA SOLICITUD
        /*
        if($reprobadasSinExtras->isNotEmpty()) {
            try {

                $notificacion = new Notificacion($ultimoCurso);
                $notificacion->reprobadasSinExtraordinario($reprobadasSinExtras);
            } catch (Exception $e) {

            }
        }
        */

        //Esta validación obliga a que el alumno seleccione todas las materias reprobadas urgentes.
        // Las reprobadas urgentes son las materias cuyo matSemestre es 2 grados menor que el grado actual del alumno.
        //$reprobadas_urgentes = $reprobadas->where('matSemestre', '<=', intval($ultimoCurso->cgt->cgtGradoSemestre) - 2);
        $reprobadas_urgentes = $reprobadas->filter(static function($reprobada) {
            return $reprobada->maxSemestre - $reprobada->matSemestre > 1;
        });
        $urgentesNoSeleccionadas = $reprobadas_urgentes->whereNotIn('materia_id', $extras->pluck('materia_id'));
        if($reprobadas_urgentes->isNotEmpty() && $urgentesNoSeleccionadas->isNotEmpty()) {
            alert('Reprobadas urgentes', 'Tienes materias obligatorias (marcadas en rojo) para seleccionar en este periodo, favor de seleccionarla ó si no apareciera en el siguiente listado, favor de comunicarse A LA BREVEDAD con su coordinador de carrera.', 'warning')->showConfirmButton();
            return back()->withInput();
        }


        //validar solo 15 seleccionados
        if ($extras->count() > 15)
        {
            alert()->error('Aviso', 'Ha excedido la cantidad máxima de exámenes para presentar en extraordinario (máximo 15 exámenes de asignaturas diferentes). Favor de volver a seleccionar sus exámenes.')->showConfirmButton();
            return back()->withInput();
        }

        //validar

        //validar asignaturas repetidas  -------------
        $hayRepetidas = false;
        $verificaextras->each(static function($item, $key) use ($verificamaterias, &$hayRepetidas)
        {
            $cuenta_materias_con_ese_id = $verificamaterias->where('materia_id', $item->materia_id);
            //dd($cuenta_materias_con_ese_id->count());
            //dd($cuenta_materias_con_ese_id->isNotEmpty());
            if( $cuenta_materias_con_ese_id->isNotEmpty()
                && ($cuenta_materias_con_ese_id->count() > 1) )
            {
                //dd($cuenta_materias_con_ese_id->count());
                $hayRepetidas = true;
                return false;
            }
            return $cuenta_materias_con_ese_id;
        });
        if ($hayRepetidas)
        {
            alert()->error('Error', 'No puede solicitar varias fechas de examen, para la misma asignatura. Favor de volver a seleccionar sus exámenes.')->showConfirmButton();
            return back()->withInput();
        }
        //-----------


        //validar que no choquen examenes en fecha y misma hora (no validamos minutos)  -------------
        // $hayRepetidas = false;
        // $verificaextras->each(static function($item, $key) use ($verificamaterias, &$hayRepetidas)
        // {
        //     $cuenta_materias_con_esa_fecha = $verificamaterias->where('extFecha', $item->extFecha);
        //     if( $cuenta_materias_con_esa_fecha->isNotEmpty()
        //         && ($cuenta_materias_con_esa_fecha->count() > 1) )
        //     {
        //         $hayRepetidas = true;
        //         return false;
        //     }
        //     return $cuenta_materias_con_esa_fecha;
        // });

        // if ($hayRepetidas)
        // {
        //     alert()->error('Error', 'No puede solicitar exámenes que concuerden con la misma fecha. Favor de volver a seleccionar sus exámenes.')->showConfirmButton();
        //     return back()->withInput();
        // }
        //-----------

        //validar que no choquen examenes en fecha -------------
        $hayRepetidas = false;
        $verificaextras->each(static function($item, $key) use ($verificamaterias, &$hayRepetidas)
        {
            $cuenta_materias_con_esa_fecha = $verificamaterias->where('extFecha', $item->extFecha);
            if( $cuenta_materias_con_esa_fecha->isNotEmpty()
                && ($cuenta_materias_con_esa_fecha->count() > 1) )
            {
                $hayRepetidas = true;
                return false;
            }
            return $cuenta_materias_con_esa_fecha;
        });
        if ($hayRepetidas)
        {
            alert()->error('Error', 'No puede presentar 2 ó más exámenes en la misma fecha. Favor de volver a seleccionar sus exámenes.')->showConfirmButton();
            return back()->withInput();
        }
        //-----------

        //validar que no este preinscrito antes a la misma materia -------------
        if ($verificapreinscripcion->count() > 0)
        {
            $examenRepetido = $verificapreinscripcion->first();
            alert()->error('Error', 'Ya ha generado previamente, una ficha de pago para el examen: '.$examenRepetido->matNombre.'. Favor de revisar nuevamente su listado de exámenes.')->showConfirmButton();
            return back()->withInput();
        }
        //-----------

        //validar que no este preinscrito antes a la misma fecha -------------
        if ($verificaFechaPreinscripcion->count() > 0)
        {
            $examenRepetido = $verificaFechaPreinscripcion->first();
            alert()->error('Error', 'Ya ha generado previamente, una ficha de pago para la misma fecha ('.$examenRepetido->extFecha.'). Favor de revisar nuevamente su listado de exámenes.')->showConfirmButton();
            return back()->withInput();
        }
        //-----------

        //validar que no este inscrito antes a la misma materia -------------
        if ($verificainscripcion->count() > 0)
        {
            $examenRepetido = $verificainscripcion->first();
            alert()->error('Error', 'Ha seleccionado un examen al cuál ya se encuentra inscrito. Favor de revisar la opción del menú "EXTRAORDINARIOS", para visualizar el listado de exámenes a los cuáles ya les aplicaron su pago correspondiente.')->showConfirmButton();
            return back()->withInput();
        }
        //-----------

        //validar que no este inscrito antes a la misma fecha -------------
        if ($verificaFechaInscripcion->count() > 0)
        {
            $examenRepetido = $verificaFechaInscripcion->first();
            alert()->error('Error', 'Ha seleccionado un examen al cuál ya se encuentra inscrito en la misma fecha. Favor de revisar la opción del menú "EXTRAORDINARIOS", para visualizar el listado de exámenes a los cuáles ya les aplicaron su pago correspondiente.')->showConfirmButton();
            return back()->withInput();
        }
        //-----------


        $fichaGeneradaBBVA = $this->prepararFichaBBVA($alumno, $total_a_pagar);
        //dd($fichaGenerada);
        //es un array no es collection
        $nuevareferenciaBBVA = $fichaGeneradaBBVA['referencia1'];
        //dd($nuevareferencia);

        $fichaGeneradaHSBC = $this->prepararFichaHSBC($alumno, $total_a_pagar);
        $nuevareferenciaHSBC = $fichaGeneradaHSBC['referencia1'];


        DB::beginTransaction();
        try {
            $extras->each(static function($extraordinario) use ($alumno, $nuevareferenciaBBVA, $nuevareferenciaHSBC)
            {
                $aluPersona = $alumno->persona;
                $empleado = $extraordinario->empleado;
                $empPersona = $empleado->persona;
                $materia = $extraordinario->materia;
                $fichaPeriodoid = $extraordinario->periodo_id;
                $plan = $materia->plan;
                $programa = $plan->programa;


                PreinscritoExtraordinario::create([
                    'alumno_id' => $alumno->id,
                    'extraordinario_id' => $extraordinario->id,
                    'empleado_id' => $empleado->id,
                    'materia_id' => $materia->id,
                    'aluClave' => $alumno->aluClave,
                    'aluNombre' => MetodosPersonas::nombreCompleto($aluPersona),
                    'empNombre' => MetodosPersonas::nombreCompleto($empPersona),
                    'ubiClave' => $programa->escuela->departamento->ubicacion->ubiClave,
                    'ubiNombre' => $programa->escuela->departamento->ubicacion->ubiNombre,
                    'progClave' => $programa->progClave,
                    'progNombre' => $programa->progNombre,
                    'matClave' => $materia->matClave,
                    'matNombre' => $materia->matNombre,
                    'extFecha' => $extraordinario->extFecha,
                    'extHora' => $extraordinario->extHora,
                    'extPago' => $extraordinario->extPago,
                    'pexEstado' => 'A',
                    'extOportunidad_DentroDelPeriodo' => $extraordinario->extOportunidad_DentroDelPeriodo,
                    'folioFichaPago' => substr($nuevareferenciaBBVA, 0, 15),
                    'folioFichaPagoBBVA' => $nuevareferenciaBBVA,
                    'folioFichaPagoHSBC' => $nuevareferenciaHSBC
                ]);
            });

        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Error', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();

        alert()->success('Realizado', 'Registro exitoso!')->showConfirmButton();

        return $this->generatePDF($fichaGeneradaBBVA, $fichaGeneradaHSBC);

        //return redirect('inscribirse_extraordinario');
    }

    public function check($start, $end)
    {
        return Carbon::now()->between(Carbon::createFromFormat('Y-m-d', $start), Carbon::createFromFormat('Y-m-d', $end));
    }

    public function extOportunidad_DentroDelPeriodo($periodo)
    {
        $calendario = CalendarioExamen::where('periodo_id', $periodo)->first();
        $extOportunidad_DentroDelPeriodo = 0;

        if ( $calendario && !is_null($calendario->calexFinOrdinario) && !is_null($calendario->calexFinExtraordinario) ) {
            $check = $this->check($calendario->calexFinOrdinario, $calendario->calexFinExtraordinario);
            if ($check) {
                $extOportunidad_DentroDelPeriodo = 1;
            } else {
                if ( !is_null($calendario->calexFinExtraordinario) && !is_null($calendario->calexFinExtraordinario2) ) {
                    $check2 = $this->check($calendario->calexFinExtraordinario, $calendario->calexFinExtraordinario2);
                    if ($check2) {
                        $extOportunidad_DentroDelPeriodo = 2;
                    } else {
                        if ( !is_null($calendario->calexFinExtraordinario) && !is_null($calendario->calexInicioExtraordinario3) ) {
                            $check3 = $this->check($calendario->calexFinExtraordinario2, $calendario->calexInicioExtraordinario3);
                            if ($check3) {
                                $extOportunidad_DentroDelPeriodo = 3;
                            }
                        }
                    }
                }
            }
        }
        return $extOportunidad_DentroDelPeriodo;
    }

    public function list($alumno_id) {
        $alumno = Alumno::findOrFail($alumno_id);
        $curso = $alumno->cursos()->with('cgt', 'periodo.departamento')->where('curEstado', 'R')
            ->whereHas('periodo.departamento', function($query) {
                $query->where('depClave', Auth::user()->depClave);
            })
            ->whereNull('deleted_at')
            ->latest("curFechaRegistro")
            ->first();

        $departamento = $curso->periodo->departamento;

        // obtener extOportunidad_DentroDelPeriodo
        $extOportunidad_DentroDelPeriodo = $this->extOportunidad_DentroDelPeriodo($departamento->periodoActual->id);

        $extraordinarios_todos = Extraordinario::with(['periodo', 'materia.plan.programa.escuela.departamento.ubicacion', 'empleado.persona', 'optativa.materia'])
        ->where('periodo_id', $departamento->periodoActual->id)->where('extOportunidad_DentroDelPeriodo', $extOportunidad_DentroDelPeriodo)->get();

        $reprobadas = $this->reprobadas_alumno($alumno);

        if($reprobadas->isNotEmpty())
        {
           $extraordinarios = $this->ordenar_reprobadas_primero($reprobadas, $extraordinarios_todos);

            if($extraordinarios->isEmpty())
            {
                alert()->error('Aviso', 'Usted tiene materias adeudadas que necesita presentar. Favor de comunicarse a la brevedad con su Coordinador de Carrera para solicitar el examen extraordinario en las fechas indicadas para el periodo en curso.')->showConfirmButton();
                return back()->withInput();
            }

        }
        else
        {

            $extraordinarios = Extraordinario::with(['periodo', 'materia.plan.programa.escuela.departamento.ubicacion', 'empleado.persona'])
                ->where('periodo_id', '0')->where('extOportunidad_DentroDelPeriodo', $extOportunidad_DentroDelPeriodo)->get();

        }



        return DataTables::of($extraordinarios)
        ->addIndexColumn()
        ->setRowClass(static function(Extraordinario $extraordinario) use ($reprobadas) {
            $materia = $extraordinario->materia;
            $reprobada = $reprobadas->where('materia_id', $extraordinario->materia_id)->first();
            $esUrgenteAprobar = $reprobada ? ($reprobada->maxSemestre - $materia->matSemestre > 1) : false;
            if($reprobada && $esUrgenteAprobar) {
                return "urgente-aprobar-row";
            } else {
                return "";
            }
        })
        ->addColumn('nombreDocente', static function(Extraordinario $extraordinario) {
            $persona = $extraordinario->empleado->persona;
            return MetodosPersonas::nombreCompleto($persona);
        })
        ->addColumn('matNombreCompleto', function($query) {
            $optNombre = $query->optativa ? ' - '. $query->optativa->optNombre : '';
            return $query->materia->matNombre . $optNombre;
        })
        ->addColumn('action', static function(Extraordinario $extraordinario) use ($reprobadas) {

            //Si se encuentra reprobada, se agrega la class "reprobada"
            $esReprobada = $reprobadas->where('materia_id', $extraordinario->materia_id)->first();
            $claseReprobada = $esReprobada ? 'reprobada' : '';

            $checkbox_id = 'extra-'.$extraordinario->id;

            return '<div class="row">
                        <div class="col s1">
                            <input type="checkbox" id="'.$checkbox_id.'" name="" value="'.$extraordinario->id.'" class="check_inscribir '.$claseReprobada.'" data-costo="'.$extraordinario->extPago.'" data-materia-id="'.$extraordinario->materia_id.'">
                            <label for="extra-'.$extraordinario->id.'">inscribirse</label>
                        </div>
                    </div>';
        })->toJson();
    }//list.



    /**
    * Ordena el DataTable para que aparezcan primero los extraordinarios de las materias reprobadas del alumno.
    *
    * @param  Collection $reprobadas
    * @param Collection $extraordinarios
    * @return Collection
    */
    public function ordenar_reprobadas_primero($lasreprobadas, $losextraordinarios)
    {
        $extras_ordenados = new Collection;

        $lasreprobadas->each(static function($item, $key) use ($losextraordinarios, $extras_ordenados) {
            $extraordinarios = $losextraordinarios->where('materia_id', $item->materia_id);

            if($extraordinarios->isNotEmpty()) {
                $extraordinarios->each(static function($extraordinario, $key) use($extras_ordenados) {
                    $extras_ordenados->push($extraordinario);
                });
            }
        });

        return $extras_ordenados;
    }//ordenar_reprobadas_primero.


    /**
    * devuelve las materias reprobadas del alumno.
    *
    * @param  App\Models\Alumno $alumno
    * @return Collection $reprobadas
    */
    public function reprobadas_alumno($alumno) {

        $aluClave = $alumno->aluClave;
        $reprobadas = DB::select('call procReprobadasAlumno(?)', array($aluClave));

        //dd(collect($reprobadas));

        return collect($reprobadas);
    }//reprobadas_alumno.

    public function reprobadas_alumno_SINEDUVIDA($alumno) {

        $aluClave = $alumno->aluClave;
        $reprobadas = DB::select('call procReprobadasAlumnoSinEduVida(?)', array($aluClave));

        //dd(collect($reprobadas));

        return collect($reprobadas);
    }//reprobadas_alumno.

    /**
     * Recibe una collection con el resultado del procedure procReprobadasAlumno.
     *
     * @param Illuminate\Support\Collection $reprobadas
     */
    private function obtenerMateriasReprobadasSinExtraordinarioAgendado(Collection $reprobadas): Collection {
        $extras = Extraordinario::whereIn('materia_id', $reprobadas->pluck('materia_id'))
        ->whereHas('periodo.departamento', static function($query) {
            $query->whereColumn('periodo_id', 'perActual');
        })
        ->get();

        return $reprobadas->whereNotIn('materia_id', $extras->pluck('materia_id'));
    }



    public function prepararFichaBBVA($el_alumno, $el_importe)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $generarReferencia = new GenerarReferencia;

        $ficha = [];

        $curso = $el_alumno->cursos()->latest()->first();
        $aluClave         = $el_alumno->aluClave;
        $fechaVencimiento = $date = Carbon::now()->addDay(2); //Carbon::now();
        $fechaVencimientoPago = $fechaVencimiento;
        $fechaFormato = $fechaVencimiento;
        $fechaFormatoSql = Carbon::parse($fechaFormato)->format("Y-m-d");
        $fechaVencimientoPago = $fechaVencimiento->day . "/" . Utils::num_meses_corto_string($fechaVencimiento->month) . "/" . $fechaVencimiento->year;

        $fechaVencimientoFicha = $fechaVencimiento->addDays(1); //$fechaVencimiento;
        $fechaVencimientoFicha = $fechaVencimiento->day . "/" . Utils::num_meses_corto_string($fechaVencimiento->month) . "/" . $fechaVencimiento->year;

        $alumno_id = $curso->alumno->id;
        $clave_pago = $curso->alumno->aluClave;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $perNumero = $curso->cgt->periodo->perNumero;
        $departamentoId = $curso->cgt->plan->programa->escuela->departamento->id;
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escuelaId = $curso->cgt->plan->programa->escuela->id;
        $programaId = $curso->cgt->plan->programa->id;
        $programa_id = $curso->cgt->plan->programa->id;
        $perAnioPago = $curso->periodo->perAnioPago;

        /*
        $cuotaDep  = Cuota::where([['cuoTipo', 'D'], ['dep_esc_prog_id', $departamentoId], ['cuoAnio', $perAnioPago]])->first();
        $cuotaEsc  = Cuota::where([['cuoTipo', 'E'], ['dep_esc_prog_id', $escuelaId], ['cuoAnio', $perAnioPago]])->first();
        $cuotaProg = Cuota::where([['cuoTipo', 'P'], ['dep_esc_prog_id', $programaId], ['cuoAnio', $perAnioPago]])->first();


        $cuotaActual = "";
        if ($cuotaDep) {
            $cuotaActual = $cuotaDep;
        }
        if ($cuotaEsc) {
            $cuotaActual = $cuotaEsc;
        }
        if ($cuotaProg) {
            $cuotaActual = $cuotaProg;
        }
        */

        //dd($cuotaDep, $cuotaEsc, $cuotaProg);
        /*
        if (!$cuotaActual) {
            alert()->error('Error...', "No existe cuota para este alumno");
            return back()->withInput();
        }

        $cuotaActual->cuoAnio;
        */

        $cuoAnio = $perAnioPago;

        //$permitted_chars = '0123456789';
        //$aleatorio_8_numeros = substr(str_shuffle($permitted_chars), 0, 8);
        //$conceptoRef = "8888" . $aleatorio_8_numeros; //$clave_pago . ($request->cuoAnio % 100) . $concepto;

        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;
        $cuoConcepto = "36";
        $cuoConceptoRef = $cuoConcepto;
        $ficha["cuoConceptoRef"] = $cuoConceptoRef;
        $cuoConcepto =  ($perAnioPago % 100) . $cuoConcepto;
        //$concepto         = "36"; //$request->cuoConcepto;
        //$conceptoRef = $clave_pago . ($perAnioPago % 100) . $concepto;
        $concepto = $clave_pago.$cuoConcepto;
        $importeRef = sprintf("%0.2f",$el_importe);

        $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
            $alumno_id, $programa_id, $cuoAnio,
            $cuoConceptoRef, $fechaFormatoSql, $importeRef, null,
            null, null, null, null, null,
            null, "P");

        $referencia = $generarReferencia->crearBBVA($concepto,$fechaFormatoSql,$importeRef,
            $conpRefClave, $refNum);

        $ficha['clave_pago']       = $clave_pago;
        $ficha['nombreAlumno']     = $curso->alumno->persona->perApellido1 . " " . $curso->alumno->persona->perApellido2 . " " . $curso->alumno->persona->perNombre;
        $ficha['progNombre']       = $curso->cgt->plan->programa->progNombreCorto;
        $ficha['gradoSemestre']    = $curso->cgt->cgtGradoSemestre;
        $ficha['ubicacion']        = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        //$ficha['cuoNumeroCuenta']  = "cuota->cuoNumeroCuenta";
        $ficha['cursoEscolar']     = $perAnio . "-" . ($perAnio + 1);
        $convenio = Convenio::where("departamento_id", "=", $departamentoId)->first();
        //$ficha['cuoNumeroCuenta']  = sprintf("%07s\n", $convenio->convNumero);
        $ficha['cuoNumeroCuenta']  = sprintf("%07s\n", "012914002018521323");
        $ficha['vencimientoFicha'] = $fechaVencimientoFicha;
        $ficha['cuoImporteInscripcion1']     = Utils::convertMoney($el_importe);
        $ficha['cuoFechaLimiteInscripcion1'] = $fechaVencimientoPago;
        $ficha['referencia1'] = $referencia;
        $ficha['nomConcepto'] = strtoupper('Derecho de Examen(es) ExtraOrdinario(s)');
        /*
        if ($concepto == "99" || $concepto == "00") {
            $ficha['nomConcepto'] = strtoupper($request->nomConcepto) . " " . $request->perNumero;
        }
        */

        Ficha::create([
            "fchNumPer"       => $curso->periodo->perNumero,
            "fchAnioPer"      => $perAnio,
            "fchClaveAlu"     => $clave_pago,
            "fchClaveCarr"    => $curso->cgt->plan->programa->progClave,
            "fchClaveProgAct" => NULL,
            "fchGradoSem"     => $curso->cgt->cgtGradoSemestre,
            "fchGrupo"        => $curso->cgt->cgtGrupo,
            "fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
            "fchHoraImpr"     => Carbon::now()->format("h:i:s"),
            "fchUsuaImpr"     => auth()->user()->id,
            "fchTipo"         => $curso->alumno->aluEstado,
            "fchConc"         => $ficha["cuoConceptoRef"],
            "fchFechaVenc1"   => $fechaFormatoSql,
            "fhcImp1"         => $importeRef,
            "fhcRef1"         => $referencia,
            "fchEstado"       => "A"
        ]);

        return $ficha;

        //return $this->generatePDF($ficha);
    }

    public function prepararFichaHSBC($el_alumno, $el_importe)
    {

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $generarReferencia = new GenerarReferencia;

        $ficha = [];

        $curso = $el_alumno->cursos()->latest()->first();
        $aluClave         = $el_alumno->aluClave;
        $fechaVencimiento = $date = Carbon::now()->addDay(2); //Carbon::now();
        $fechaVencimientoPago = $fechaVencimiento;
        $fechaFormato = $fechaVencimiento;
        $fechaFormatoSql = Carbon::parse($fechaFormato)->format("Y-m-d");
        $fechaVencimientoPago = $fechaVencimiento->day . "/" . Utils::num_meses_corto_string($fechaVencimiento->month) . "/" . $fechaVencimiento->year;

        $fechaVencimientoFicha = $fechaVencimiento->addDays(1); //$fechaVencimiento;
        $fechaVencimientoFicha = $fechaVencimiento->day . "/" . Utils::num_meses_corto_string($fechaVencimiento->month) . "/" . $fechaVencimiento->year;

        $alumno_id = $curso->alumno->id;
        $clave_pago = $curso->alumno->aluClave;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $perNumero = $curso->cgt->periodo->perNumero;
        $departamentoId = $curso->cgt->plan->programa->escuela->departamento->id;
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escuelaId = $curso->cgt->plan->programa->escuela->id;
        $programaId = $curso->cgt->plan->programa->id;
        $programa_id = $curso->cgt->plan->programa->id;
        $perAnioPago = $curso->periodo->perAnioPago;

        /*
        $cuotaDep  = Cuota::where([['cuoTipo', 'D'], ['dep_esc_prog_id', $departamentoId], ['cuoAnio', $perAnioPago]])->first();
        $cuotaEsc  = Cuota::where([['cuoTipo', 'E'], ['dep_esc_prog_id', $escuelaId], ['cuoAnio', $perAnioPago]])->first();
        $cuotaProg = Cuota::where([['cuoTipo', 'P'], ['dep_esc_prog_id', $programaId], ['cuoAnio', $perAnioPago]])->first();

        $cuotaActual = "";
        if ($cuotaDep) {
            $cuotaActual = $cuotaDep;
        }
        if ($cuotaEsc) {
            $cuotaActual = $cuotaEsc;
        }
        if ($cuotaProg) {
            $cuotaActual = $cuotaProg;
        }


        if (!$cuotaActual) {
            alert()->error('Error...', "No existe cuota para este alumno");
            return back()->withInput();
        }
        $cuoAnio = $cuotaActual->cuoAnio;
        */

        $cuoAnio = $perAnioPago;

        //$permitted_chars = '0123456789';
        //$aleatorio_8_numeros = substr(str_shuffle($permitted_chars), 0, 8);
        //$conceptoRef = "8888" . $aleatorio_8_numeros; //$clave_pago . ($request->cuoAnio % 100) . $concepto;

        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;
        $cuoConcepto = "36";
        $cuoConceptoRef = $cuoConcepto;
        $ficha["cuoConceptoRef"] = $cuoConceptoRef;
        $cuoConcepto =  ($perAnioPago % 100) . $cuoConcepto;
        //$concepto         = "36"; //$request->cuoConcepto;
        //$conceptoRef = $clave_pago . ($perAnioPago % 100) . $concepto;
        $concepto = $clave_pago.$cuoConcepto;
        $importeRef = sprintf("%0.2f",$el_importe);

        $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
            $alumno_id, $programa_id, $cuoAnio,
            $cuoConceptoRef, $fechaFormatoSql, $importeRef, null,
            null, null, null, null, null,
            null, "P");

        $referencia = $generarReferencia->crearHSBC($concepto,$fechaFormatoSql,$importeRef,
            $conpRefClave, $refNum);

        $ficha['clave_pago']       = $clave_pago;
        $ficha['nombreAlumno']     = $curso->alumno->persona->perApellido1 . " " . $curso->alumno->persona->perApellido2 . " " . $curso->alumno->persona->perNombre;
        $ficha['progNombre']       = $curso->cgt->plan->programa->progNombreCorto;
        $ficha['gradoSemestre']    = $curso->cgt->cgtGradoSemestre;
        $ficha['ubicacion']        = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        //$ficha['cuoNumeroCuenta']  = "cuota->cuoNumeroCuenta";
        $ficha['cursoEscolar']     = $perAnio . "-" . ($perAnio + 1);
        //$convenio = Convenio::where("departamento_id", "=", $departamentoId)->first();
        //$ficha['cuoNumeroCuenta']  = sprintf("%07s\n", $convenio->convNumero);
        $ficha['cuoNumeroCuenta']  = sprintf("%07s\n", "021180550300090224");
        $ficha['vencimientoFicha'] = $fechaVencimientoFicha;
        $ficha['cuoImporteInscripcion1']     = Utils::convertMoney($el_importe);
        $ficha['cuoFechaLimiteInscripcion1'] = $fechaVencimientoPago;
        $ficha['referencia1'] = $referencia;
        $ficha['nomConcepto'] = strtoupper('Derecho de Examen(es) ExtraOrdinario(s)');


        Ficha::create([
            "fchNumPer"       => $curso->periodo->perNumero,
            "fchAnioPer"      => $perAnio,
            "fchClaveAlu"     => $clave_pago,
            "fchClaveCarr"    => $curso->cgt->plan->programa->progClave,
            "fchClaveProgAct" => NULL,
            "fchGradoSem"     => $curso->cgt->cgtGradoSemestre,
            "fchGrupo"        => $curso->cgt->cgtGrupo,
            "fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
            "fchHoraImpr"     => Carbon::now()->format("h:i:s"),
            "fchUsuaImpr"     => auth()->user()->id,
            "fchTipo"         => $curso->alumno->aluEstado,
            "fchConc"         => $ficha["cuoConceptoRef"],
            "fchFechaVenc1"   => $fechaFormatoSql,
            "fhcImp1"         => $importeRef,
            "fhcRef1"         => $referencia,
            "fchEstado"       => "A"
        ]);

        return $ficha;

        //return $this->generatePDF($ficha);
    }

    private function generatePDF($ficha, $hsbc)
    {
        //valores de celdas
        //curso escolar
        $talonarios = ['bbva', 'hsbc', 'modelo'];

        $logoX = 150;
        $logoY['bbva'] = 12;
        $logoY['hsbc'] = 105;
        $logoY['modelo'] = 198;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['bbva'] = 20;
        $cursoY['hsbc'] = 112;
        $cursoY['modelo'] = 204;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['bbva'] = 15;
        $escuelaModeloY['hsbc'] = 107;
        $escuelaModeloY['modelo'] = 199;

        //Ficha de Deposito
        $fichaDepositoY['bbva'] = 25;
        $fichaDepositoY['hsbc'] = 117;
        $fichaDepositoY['modelo'] = 210;

        //alto de filas
        $filaH = 9;
        $filaMedia = 5;

        //inicio de filas
        $columna1 = 24;
        $columna2 = 69;
        $columna3 = 114;
        $columna4 = 159;
        //ancho de filas
        $anchoCorto = 45;
        $anchoMedio = 90;
        $anchoLargo = 135;

        //fila1
        $fila1['bbva'] = 35;
        $fila1['hsbc'] = 128;
        $fila1['modelo'] = 220;

        //fila2
        $fila2['bbva'] = 44;
        $fila2['hsbc'] = 137;
        $fila2['modelo'] = 226;

        //fila3
        $fila3['bbva'] = 53;
        $fila3['hsbc'] = 146;
        $fila3['modelo'] = 239;

        //fila3.5
        $fila35['bbva'] = 65;
        $fila35['hsbc'] = 158;
        $fila35['modelo'] = 251;

        //fila4
        $fila4['bbva'] = 70;
        $fila4['hsbc'] = 163;
        $fila4['modelo'] = 256;

        //fila5
        $fila5['bbva'] = 79;
        $fila5['hsbc'] = 172;
        $fila5['modelo'] = 265;

        //Clave de pago

        //Número de convenio

        //Nombre del Alumno
        $nombreC = utf8_decode($ficha['nombreAlumno']);
        $nombreC = strtoupper($nombreC);

        //ubicación
        $ubicacionC = "($ficha[ubicacion])";
        //concepto
        $conceptoC = $ficha['nomConcepto'];
        $conceptoC = utf8_decode($conceptoC);

        //pago1
        $pago1Fecha = "";
        $pago1Importe = "";
        $pago1Referencia = "";

        $pago1Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago1Importe = $ficha['cuoImporteInscripcion1'];
        $pago1Referencia = $ficha['referencia1'];

        //pago2
        $pago2Fecha = "";
        $pago2Importe = "";
        $pago2Referencia = "";

        $pago2Fecha = $hsbc['cuoFechaLimiteInscripcion1'];
        $pago2Importe = $hsbc['cuoImporteInscripcion1'];
        $pago2Referencia = $hsbc['referencia1'];

        //pago3
        $pago3Fecha = "";
        $pago3Importe = "";
        $pago3Referencia = "";

        $pago3Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago3Importe = $ficha['cuoImporteInscripcion1'];
        $pago3Referencia = $ficha['referencia1'];

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimientoFicha'];
        $vencimientohsbc = $hsbc['vencimientoFicha'];
        $vencimientomodelo = $hsbc['vencimientoFicha'];

        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: ") . Carbon::now("CDT")->format("d/m/Y h:i");
        $pdf = new \App\Http\Controllers\Pagos\EFEPDF('P','mm','Letter');
        $pdf->SetTitle("Ficha de pago | SCEM");
        $pdf->AliasNbPages();
        $pdf->AddPage();

        foreach ($talonarios as $talonarioInd)
        {
            if ($talonarioInd == "bbva")
            {
                //$pdf->Image(URL::to('images/bbva.png'),$logoX, $logoY[$talonarioInd]);
                //imprimir encabezados
                $pdf->SetFillColor(180, 190, 210);
                $pdf->SetFont('Arial', '', 10);

                //clave del alumno
                $pdf->SetXY($columna1, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH, "Clave del Alumno", 1, 0, 'L', 1);

                //convenio
                $pdf->SetXY($columna3, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH, utf8_decode("Clabe Interbancaria"), 1, 0, 'L', 1);

                //Nombre del alumno
                $pdf->SetXY($columna1, $fila2[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH, "Nombre del Alumno", 1, 0, 'L', 1);

                //Concepto de pago
                $pdf->SetXY($columna1, $fila3[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH, utf8_decode("Descripción"), 1, 0, 'L', 1);

                //Fecha límite
                $pdf->SetXY($columna1, $fila35[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);

                //Importe
                $pdf->SetXY($columna2, $fila35[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

                //Referencia
                $pdf->SetXY($columna3, $fila35[$talonarioInd]);
                $pdf->Cell($anchoMedio, $filaMedia, "Concepto de pago o referencia", 1, 0, 'C', 1);

                $pdf->SetFont('Arial','B', 12);
                $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');




                $pdf->SetXY($logoX,  $logoY[$talonarioInd]);
                $pdf->Cell($logoW, $logoH,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, 'C');



                $pdf->SetTextColor(40, 65, 110);
                $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
                $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH, "FICHA DE PAGO REFERENCIADO", 0, 0, 'C');
                $pdf->SetTextColor(0);


                $pdf->SetFont('Arial','',30);
                $pdf->SetXY(140,  $fila1[$talonarioInd]);
                $pdf->Cell(80, -25, "BBVA", 0, 0, "C");

                $pdf->SetFont('Arial','',10);
                //clave de pago
                $pdf->SetXY($columna2, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH,$ficha['clave_pago'], 1, 0);
                //numero de cuenta convenio
                $pdf->SetXY($columna4, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH,$ficha['cuoNumeroCuenta'], 1, 0);
                //nombre del alumno
                $pdf->SetXY($columna2, $fila2[$talonarioInd]);
                $pdf->Cell($anchoLargo, $filaH,$nombreC, 1, 0);
                //nombre del alumno
                $pdf->SetXY($columna2, $fila2[$talonarioInd]);
                $pdf->Cell($anchoLargo, $filaH,$ubicacionC, 1, 0, 'R');
                //concepto de pago
                $pdf->SetXY($columna2, $fila3[$talonarioInd]);
                $pdf->Cell($anchoLargo, $filaH,$conceptoC, 1, 0);

                //importes y fechas
                $pdf->SetY($fila4[$talonarioInd]);
                $pdf->SetX($columna1);
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1);

                /*
                $pdf->SetX($columna1);
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1);
                */

                //fecha de vencimiento y fecha de impresión

                $pdf->SetX($columna2);
                $pdf->SetFont('Arial', '', 11);
                // $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0); // título de la invalidación
                $pdf->SetFont('Arial', 'B', '10');
                $pdf->SetX($vencimientoX);
                // $pdf->SetX($columna2);
                // $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0); // fecha de invalidación

                $pdf->SetFont('Arial', 'I', '8');
                $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

                $pdf->SetY(84);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($anchoMedio, $filaH, utf8_decode("I. PAGO DIRECTO EN SUCURSAL BANCARIA BBVA:"), 0, 0);

                $pdf->SetY(87);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($anchoMedio, $filaH, utf8_decode("1-SI PAGA EN VENTANILLA DE SUCURSAL BANCARIA BBVA, UTILICE EL CONVENIO 1852132"), 0, 0);

                $pdf->SetY(90);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($anchoMedio, $filaH, utf8_decode("2-SI PAGA EN CAJERO AUTOMÁTICO BBVA, SELECCIONE PAGO DE SERVICIO CON EL CONVENIO 1852132"), 0, 0);

                $pdf->SetY(93);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($anchoMedio, $filaH, utf8_decode("II. PAGO EN LÍNEA (APLICACIÓN ó PORTAL WEB BANCARIO):"), 0, 0);

                $pdf->SetY(96);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($anchoMedio, $filaH, utf8_decode("A) SI PAGA DE BBVA A BBVA (DESDE SU PORTAL BANCARIO BBVA), UTILICE PAGO DE SERVICIO CON EL CONVENIO 1852132"), 0, 0);

                $pdf->SetY(99);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell($anchoMedio, $filaH, utf8_decode("B) DESDE OTRO BANCO A BBVA (SPEI), USAR LA CLABE INTERBANCARIA 012914002018521323"), 0, 0);


            }

            if ($talonarioInd == "hsbc")
            {
                //imprimir encabezados
                $pdf->SetFillColor(180, 190, 210);
                $pdf->SetFont('Arial', '', 10);

                //clave del alumno
                $pdf->SetXY($columna1, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH, "Clave del Alumno", 1, 0, 'L', 1);

                //convenio
                $pdf->SetXY($columna3, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH, utf8_decode("Clabe Interbancaria"), 1, 0, 'L', 1);

                //Nombre del alumno
                $pdf->SetXY($columna1, $fila2[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH, "Nombre del Alumno", 1, 0, 'L', 1);

                //Concepto de pago
                $pdf->SetXY($columna1, $fila3[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH, utf8_decode("Descripción"), 1, 0, 'L', 1);

                //Fecha límite
                $pdf->SetXY($columna1, $fila35[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);

                //Importe
                $pdf->SetXY($columna2, $fila35[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

                //Referencia
                $pdf->SetXY($columna3, $fila35[$talonarioInd]);
                $pdf->Cell($anchoMedio, $filaMedia, "Concepto de pago o referencia", 1, 0, 'C', 1);

                $pdf->SetFont('Arial','B', 12);
                $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$hsbc['cursoEscolar'], 0, 0,'C');

                $pdf->SetXY($logoX,  $logoY[$talonarioInd]);
                $pdf->Cell($logoW, $logoH,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, 'C');

                $pdf->SetTextColor(40, 65, 110);
                $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
                $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO POR TRANSFERENCIA ELECTRÓNICA SPEI"), 0, 0, 'C');
                $pdf->SetTextColor(0);

                $pdf->SetFont('Arial','',30);
                $pdf->SetXY(140,  $fila1[$talonarioInd]);
                $pdf->Cell(80, -25, "HSBC", 0, 0, "C");

                $pdf->SetFont('Arial','',10);
                //clave de pago
                $pdf->SetXY($columna2, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH,$hsbc['clave_pago'], 1, 0);
                //numero de cuenta convenio
                $pdf->SetXY($columna4, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH,"021180550300090224", 1, 0);
                //nombre del alumno
                $pdf->SetXY($columna2, $fila2[$talonarioInd]);
                $pdf->Cell($anchoLargo, $filaH,$nombreC, 1, 0);
                //nombre del alumno
                $pdf->SetXY($columna2, $fila2[$talonarioInd]);
                $pdf->Cell($anchoLargo, $filaH,$ubicacionC, 1, 0, 'R');
                //concepto de pago
                $pdf->SetXY($columna2, $fila3[$talonarioInd]);
                $pdf->Cell($anchoLargo, $filaH,$conceptoC, 1, 0);

                //importes y fechas
                $pdf->SetY($fila4[$talonarioInd]);
                $pdf->SetX($columna1);
                $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
                $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);

                /*
                $pdf->SetX($columna1);
                $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
                $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);
                */

                //fecha de vencimiento y fecha de impresión

                $pdf->SetX($columna2);
                $pdf->SetFont('Arial', '', 12);
                // $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0); // título de la invalidación
                $pdf->SetFont('Arial', 'B', '10');
                $pdf->SetX($vencimientoX);
                // $pdf->SetX($columna2);
                // $pdf->Cell($vencimientoW, $filaH, $vencimientohsbc, 0, 0); // fecha de invalidación

                $pdf->SetFont('Arial', 'I', '8');
                $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

                $pdf->SetY(177);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell($anchoMedio, $filaH, "                *** PARA PAGO EXCLUSIVO POR TRANSFERENCIA EN HSBC ***", 0, 0);

                $pdf->SetY(182);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "SI PAGA DE HSBC A HSBC, PAGAR COMO SERVICIO 9022", 0, 0);

                $pdf->SetY(186);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "DESDE OTRO BANCO A HSBC (SPEI), USAR LA CLABE INTERBANCARIA 021180550300090224", 0, 0);

            }

            if ($talonarioInd == "modelo")
            {
                //$pdf->Image(URL::to('images/bbva.png'),$logoX, $logoY[$talonarioInd]);
                //imprimir encabezados
                $pdf->SetFillColor(180, 190, 210);
                $pdf->SetFont('Arial', '', 10);

                //Fecha límite
                $pdf->SetXY($columna1, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);

                //Importe
                $pdf->SetXY($columna2, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

                //Referencia
                $pdf->SetXY($columna3, $fila1[$talonarioInd]);
                $pdf->Cell($anchoMedio, $filaMedia, "Concepto del pago", 1, 0, 'C', 1);

                $pdf->SetFont('Arial','B', 12);
                $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');

                $pdf->SetXY($logoX,  $logoY[$talonarioInd]);
                $pdf->Cell($logoW, $logoH,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, 'C');

                $pdf->SetTextColor(40, 65, 110);
                $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
                $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH, "PAGO EN EFECTIVO / OFICINAS DE UNIVERSIDAD", 0, 0, 'C');
                $pdf->SetTextColor(0);

                //importes y fechas
                $pdf->SetFont('Arial','',10);
                $pdf->SetY($fila2[$talonarioInd]);
                $pdf->SetX($columna1);
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1);

                $pdf->SetY(235);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell($anchoMedio, $filaH, "* * * PARA PAGO EXCLUSIVO EN VENTANILLA DE SECRETARIA ADMINISTRATIVA * * *", 0, 0);
                $pdf->SetY(243);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);

                $pdf->SetTextColor(255,0,0);
                $pdf->Cell($anchoMedio, $filaH, utf8_decode("PARA HACER VÁLIDO SU PAGO DE EFECTIVO, DEBE SOLICITAR EL RECIBO DE PAGO DIGITAL "), 0, 0);

                $pdf->SetY(247);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "EN LA CAJA DE LA SECRETARIA ADMINISTRATIVA DE LA UNIVERSIDAD", 0, 0);

                $pdf->SetTextColor(0,0,0);
            }
        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }
}

class EFEPDF extends Fpdf {
    public function Header() {
        //$this->SetFont('Arial','B',15);
        //$this->Cell(80);
        //$this->Cell(30,10,'Title',1,0,'C');
        //$this->Ln(20);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
