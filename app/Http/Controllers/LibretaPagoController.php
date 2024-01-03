<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Models\Pago;
use App\Http\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Yajra\DataTables\Facades\DataTables;
use App\Http\Models\Portal_configuracion;

class LibretaPagoController extends Controller
{

  public function __construct() {
      $this->middleware('auth');
      $this->middleware('permisos:alumno');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    $claveAlumno = (Auth::user()->username);
    $alumno = Alumno::where("aluClave", "=",$claveAlumno)->first();
    $persona = $alumno->persona;

    //CADA AÑO SE PREGUNTA QUE PLAN DE PAGO
    //SE TIENE QUE INSERTAR LOS REGISTROS DEL CURSO ACTUAL
    $config = Portal_configuracion::Where('pcClave', 'DEFINE_PRORRATEO_LIBRETA_PAGO')->first();
    $portConfActivo = $config->pcEstado == 'A' ? true: false;
    $DEFINE_PRORRATEO_LIBRETA_PAGO = $portConfActivo;

    if ($DEFINE_PRORRATEO_LIBRETA_PAGO)
    {
          $procActualizarPlanesPago = DB::select("call procPortalAlumnosPlanPagoCurso()");
    }

    $resultado = DB::select(DB::raw("SELECT
          aluClave AS 'clave_pago',
          alumnos.id AS 'alumnos_id',
          cursos.id as 'cursos_id'
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
            depClave IN ('SUP', 'POS', 'PRE', 'MAT', 'PRI', 'SEC', 'BAC')
        );"));
    $cursoidActualAlumno = collect($resultado)->first();

    $userAlumnoPlanPago = DB::table("users_alumnos_planpago")
      ->where("clave_pago", "=", $claveAlumno)
      ->where("alumnos_id", "=", $cursoidActualAlumno->alumnos_id)
      ->where("cursos_id", "=", $cursoidActualAlumno->cursos_id)
    ->first();
    // dd($userAlumnoPlanPago);

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
        depClave IN ('SUP', 'POS', 'PRE', 'MAT', 'PRI', 'SEC', 'BAC')
    );"));
    $result = collect($results)->first();

      $resultsPerAnterior = DB::select(DB::raw("SELECT
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
      AND cursos.periodo_id = departamentos.perAnte
      AND departamentos.deleted_at IS NULL
      INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
      AND ubicacion.deleted_at IS NULL
    WHERE
      cursos.deleted_at IS NULL
      AND aluClave = $claveAlumno
      AND curEstado in ('R', 'A', 'C', 'P')
      AND periodos.id IN (
      SELECT
        perAnte
      FROM
        departamentos
      WHERE
        depClave IN ('SUP', 'POS', 'PRE', 'MAT', 'PRI', 'SEC', 'BAC')
    );"));
      $resultPerAnterior = collect($resultsPerAnterior)->first();

      //REVISAMOS SI CURSO EL PERIODO 3, Y FUE REGULAR

      $cursoEstadoRegularPerAnte = "NO";
      if ($resultPerAnterior)
      {
          if ($resultPerAnterior->perNumero == 3
              && $resultPerAnterior->curEstado == "R"
              && $result->perNumero == 1
              && ($result->depClave == "SUP" || $result->depClave == "POS")
              && ($result->carrera == $resultPerAnterior->carrera)
                )
          {
              $cursoEstadoRegularPerAnte = "SI";
          }
      }

      //dd($resultPerAnterior->perNumero, $resultPerAnterior->curEstado, $resultPerAnterior->carrera,
      //    $result->perNumero, $result->depClave, $result->carrera, $cursoEstadoRegularPerAnte);

      // dd($userAlumnoPlanPago->ubicacion,$userAlumnoPlanPago->curPlanPago,$userAlumnoPlanPago->puedeCambiardePlan,$userAlumnoPlanPago->depClave);

      //ES DEUDOR DE INSCRIPCIONES
      /*
      $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
      $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);
      $condicion = ' AND ( conc_pago IN ("99") )';
      $pago99 = DB::select("call procDeudasAlumnoAnioPago("
          ."1".","
          .$claveAlumno.","
          .$result->perAnioPago.","
          ."'".$condicion."'".","
          ."'I'".","
          ."'".$temporary_table_name."')");
      $sumadePagos = DB::table($temporary_table_name)->where("cve_fila", "=", "TL$")->first();
      DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );
      $esDeudorInscripcion99 = "NO";
      if (($result->depClave == "SUP" || $result->depClave == "POS") )
      {
          if ($sumadePagos)
          {
              if ( (float)$sumadePagos->total_mes > 0 )
              {
                  $esDeudorInscripcion99 = "SI";
              }
          }
      }
          */

      $view_libreta_pago = Portal_configuracion::Where('pcClave', 'VIEW_PDF_LIBRETA_PAGO')->first();
      
    return view('libreta_pago.create', [
      "alumno" => $alumno,
      "persona" => $persona,
      "userAlumnoPlanPago" => $userAlumnoPlanPago,
      "filtroTarjetaPago" =>$result,
      "cursoEstadoRegularPerAnte" =>$cursoEstadoRegularPerAnte,
      "motrar_libreta" => $view_libreta_pago->pcEstado
      //"filtroCursoAnterior" => $resultPerAnterior,
      //"esDeudorInscripcion99" => $esDeudorInscripcion99
    ]);
  }

  public function updatePago(Request $request)
  {
      $claveAlumno = (Auth::user()->username);
      $alumno = Alumno::where("aluClave", "=",$claveAlumno)->first();
      // dd($request->plan_pago);

      $resultado = DB::select(DB::raw("SELECT
          aluClave AS 'clave_pago',
          alumnos.id AS 'alumnos_id',
          cursos.id as 'cursos_id'
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
            depClave IN ('SUP', 'POS', 'PRE')
        );"));

      $cursoidActualAlumno = collect($resultado)->first();

      $userAlumnoPlanPago = DB::table("users_alumnos_planpago")
            ->where("clave_pago", "=", $claveAlumno)
            ->where("alumnos_id", "=", $cursoidActualAlumno->alumnos_id)
            ->where("cursos_id", "=", $cursoidActualAlumno->cursos_id)
            ->update([
          "puedeCambiardePlan" => "NO",
          "curPlanPago" => $request->plan_pago,
          "updated_at" => Carbon::now()
        ]);

      $cursoPlanPago = DB::table("cursos")
          ->where("id", "=", $cursoidActualAlumno->cursos_id)
          ->update([
              "curPlanPago" => $request->plan_pago,
              "updated_at" => Carbon::now()
          ]);



        alert()->success('Realizado', 'Plan de pago modificado correctamente')->showConfirmButton();
        return redirect()->back()->withInput();

  }

}
