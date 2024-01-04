<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Support\Facades\DB;
use PDF;


use Ficha;
use Carbon\Carbon;
use App\Models\Beca;
use App\Models\Pago;
use App\Models\Plan;
use App\Models\Cuota;
use App\Models\Curso;

use App\Http\Helpers\Utils;
use App\Models\Escuela;
use App\Models\Periodo;
use Illuminate\Http\Request;
use App\Models\Programa;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Http\Controllers\Controller;
use App\Http\Helpers\GenerarReferencia;
use RealRashid\SweetAlert\Facades\Alert;


class TarjetasPagoAlumnosSPController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }


  public function reporte()
  {

    return View('reportes/tarjetas_pago_alumnos.spcreate', [
      "becas" => Beca::all(),
      "ubicaciones" => Ubicacion::where('ubiClave', '<>', '000')->get()
    ]);
  }


  public function imprimir(Request $request)
  {

        /*
        $periodo      = Periodo::where("id", "=", $request->periodo_id)->first();
        $ubicacion    = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
        $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
        $escuela      = Escuela::where("id", "=", $request->escuela_id)->first();
        $programa     = Programa::where("id", "=", $request->programa_id)->first();
        $plan         = Plan::where("id", "=", $request->plan_id)->first();

        $escClave = $escuela ? $escuela->escClave: "";
        $ubiClave = $ubicacion ? $ubicacion->ubiClave: "";

        $perNumero = $periodo ? $periodo->perNumero: "";
        $perAnio   = $periodo ? $periodo->perAnio: "";
        $depClave  = $departamento ? $departamento->depClave: "";
        $progClave = $programa ? $programa->progClave: "";
        $planClave = $plan ? $plan->planClave: "";

        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        //dd($conpRefClave);
        //
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;
        */

         // dd($request->all());
        // $periodo      = Periodo::where("id", "=", $request->periodo_id)->first();
        // $ubicacion    = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
        // $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
        // $escuela      = Escuela::where("id", "=", $request->escuela_id)->first();
        // $programa     = Programa::where("id", "=", $request->programa_id)->first();
        // $plan         = Plan::where("id", "=", $request->plan_id)->first();


        // conceptos referencia ubicacion
        // En base a lo que tenga el alumno seleccionar => conprefclave
        // Curso actual del alumno logeado. Clave, nivel, escuela

        // si no tiene conprefclave => por el momento no puedo generar la ficha HSBC favor de generar BBVA

        $conpRefClave = "";
        if ($request->banco == "HSBC") {
          $concRefUbicacion = DB::table("conceptosreferenciaubicacion")
            ->where("ubiClave", "=", $request->ubiClave)
            ->where("depClave", "=", $request->depClave)
            ->where("escClave", "=", $request->escClave)
          ->first();

          if (!$concRefUbicacion) {
            alert()->error('Error', 'por el momento no se puede generar la libreta de pago para el banco HSBC, favor de contactar al departamento de control escolar de la Universidad.')->showConfirmButton();
            return back()->withInput();
          }
          else
          {
              $conpRefClave =  $concRefUbicacion->conpRefClave;
          }
        }

      if ($request->banco == "BBVA") {
          $concRefUbicacion = DB::table("conceptosreferenciaubicacion")
              ->where("ubiClave", "=", $request->ubiClave)
              ->where("depClave", "=", $request->depClave)
              ->where("escClave", "=", $request->escClave)
              ->first();

          if (!$concRefUbicacion) {
              alert()->error('Error', 'por el momento no se puede generar la libreta de pago para el banco HSBC, favor de contactar al departamento de control escolar de la Universidad.')->showConfirmButton();
              return back()->withInput();
          }
          else
          {
              $conpRefClave =  $concRefUbicacion->conpRefClave;
          }
      }

        $perNumero = $request->perNumero;
        $perAnio   = $request->perAnio;
        $ubiClave  = $request->ubiClave;
        $depClave  = $request->depClave;
        $escClave = $request->escClave;
        $progClave = $request->progClave;
        $planClave = $request->planClave;

        $periodoPapasDesesperados = Periodo::where("id", "=", $request->perActual)->first();



        if ($depClave == "SUP" || $depClave == "POS")
        {
            $id_periodoSiguiente = $request->periodo_id;
            if ($request->periodo_id == $request->perAnte)
            {
                $id_periodoSiguiente = $request->perActual;
            }
            if ($request->periodo_id == $request->perActual)
            {
                $id_periodoSiguiente = $request->perSig;
            }
            if ($request->periodo_id == $request->perSig)
            {
                $id_periodoSiguiente = $request->perSig;
            }

            $fechaActual = Carbon::now('CDT');
            if ( $fechaActual <= $periodoPapasDesesperados->perFechaFinal)
            {
                $id_periodoSiguiente = $request->perActual;
            }

            //dd($fechaActual, $periodoPapasDesesperados->perFechaFinal, $fechaActual <= $periodoPapasDesesperados->perFechaFinal);

            $cursos = DB::select(DB::raw("SELECT
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
              escuelas.escClave,
              programas.progClave,
              cgt.cgtGradoSemestre as 'semestre',
              cgt.cgtGrupo as 'grupo',
              cgt.id as 'cgt_id',
              periodos.perNumero,
              periodos.perAnio,
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
              AND departamentos.deleted_at IS NULL
              INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
              AND ubicacion.deleted_at IS NULL
            WHERE
              cursos.deleted_at IS NULL
              AND aluClave = $request->aluClave
              AND curEstado in ('R', 'A', 'C', 'P')
              AND periodos.perAnioPago = $request->perAnioPago
              AND periodos.id IN (
                    $id_periodoSiguiente
            );"));

            //dd($cursoSiguiente );

            if(!empty($cursos))
            {

                $cursoSiguiente = collect($cursos)->first();

                $procLibretaPago = DB::select('call procLibretaPagoCOVID("'
                    .$cursoSiguiente->perNumero.'", "'
                    .$cursoSiguiente->perAnio.'", "'
                    .$cursoSiguiente->ubiClave.'", "'
                    .$cursoSiguiente->depClave.'", "'
                    .$cursoSiguiente->escClave.'", "", "", "", "", "", "", "", "", "", "'
                    .$request->aluClave.'", "")');
            }
            else {

                $procLibretaPago = DB::select('call procLibretaPagoCOVID("'
                    . $perNumero . '", "'
                    . $perAnio . '", "'
                    . $ubiClave . '", "'
                    . $depClave . '", "'
                    . $escClave . '", "'
                    . $progClave . '", "'
                    . $planClave . '", "'
                    . $request->cgtGradoSemestre . '", "'
                    . $request->cgtGrupo . '", "'
                    . $request->curEstado . '", "'
                    . $request->curPlanPago . '", "'
                    . $request->vigenciaBeca . '", "'
                    . $request->bcaClave . '", "'
                    . $request->porcentajeBeca . '", "'
                    . $request->aluClave . '", "'
                    . $request->banco . '")');
            }
        }

        if ($depClave == "MAT" || $depClave == "PRE")
        {
              $procLibretaPago = DB::select('call procLibretaPagoCOVIDPre("'
                  . $perNumero . '", "'
                  . $perAnio . '", "'
                  . $ubiClave . '", "'
                  . $depClave . '", "'
                  . $escClave . '", "'
                  . $progClave . '", "'
                  . $planClave . '", "'
                  . $request->cgtGradoSemestre . '", "'
                  . $request->cgtGrupo . '", "'
                  . $request->curEstado . '", "'
                  . $request->curPlanPago . '", "'
                  . $request->vigenciaBeca . '", "'
                  . $request->bcaClave . '", "'
                  . $request->porcentajeBeca . '", "'
                  . $request->aluClave . '", "'
                  . $request->banco . '")');
        }

        if ($depClave == "PRI")
      {
          $procLibretaPago = DB::select('call procLibretaPagoCOVIDPri("'
              . $perNumero . '", "'
              . $perAnio . '", "'
              . $ubiClave . '", "'
              . $depClave . '", "'
              . $escClave . '", "'
              . $progClave . '", "'
              . $planClave . '", "'
              . $request->cgtGradoSemestre . '", "'
              . $request->cgtGrupo . '", "'
              . $request->curEstado . '", "'
              . $request->curPlanPago . '", "'
              . $request->vigenciaBeca . '", "'
              . $request->bcaClave . '", "'
              . $request->porcentajeBeca . '", "'
              . $request->aluClave . '", "'
              . $request->banco . '")');
      }

        if ($depClave == "SEC")
        {
          $procLibretaPago = DB::select('call procLibretaPagoCOVIDSec("'
              . $perNumero . '", "'
              . $perAnio . '", "'
              . $ubiClave . '", "'
              . $depClave . '", "'
              . $escClave . '", "'
              . $progClave . '", "'
              . $planClave . '", "'
              . $request->cgtGradoSemestre . '", "'
              . $request->cgtGrupo . '", "'
              . $request->curEstado . '", "'
              . $request->curPlanPago . '", "'
              . $request->vigenciaBeca . '", "'
              . $request->bcaClave . '", "'
              . $request->porcentajeBeca . '", "'
              . $request->aluClave . '", "'
              . $request->banco . '")');
      }

      if ($depClave == "BAC")
      {
          $procLibretaPago = DB::select('call procLibretaPagoCOVIDBac("'
              . $perNumero . '", "'
              . $perAnio . '", "'
              . $ubiClave . '", "'
              . $depClave . '", "'
              . $escClave . '", "'
              . $progClave . '", "'
              . $planClave . '", "'
              . $request->cgtGradoSemestre . '", "'
              . $request->cgtGrupo . '", "'
              . $request->curEstado . '", "'
              . $request->curPlanPago . '", "'
              . $request->vigenciaBeca . '", "'
              . $request->bcaClave . '", "'
              . $request->porcentajeBeca . '", "'
              . $request->aluClave . '", "'
              . $request->banco . '")');

      }

      $bancoSeleccionado = $request->banco;

      $procLibretaPago = collect($procLibretaPago);

      $procLibretaPago->map(function ($item, $key) use ($bancoSeleccionado, $conpRefClave)
      {
          $generarReferencia = new GenerarReferencia;

          if (!is_null($item->importe1))
          {
              $fecha1 = Carbon::parse($item->fecha1);

              $item->fecha1Formato = sprintf('%02d', $fecha1->day)
                  . "/" . Utils::num_meses_corto_string($fecha1->month)
                  . "/" . $fecha1->year;
          }
          if (!is_null($item->importe2)) {
              $fecha2 = Carbon::parse($item->fecha2);

              $item->fecha2Formato = sprintf('%02d', $fecha2->day)
                  . "/" . Utils::num_meses_corto_string($fecha2->month)
                  . "/" . $fecha2->year;
          }
          if (!is_null($item->importe3)) {
              $fecha3 = Carbon::parse($item->fecha3);

              $item->fecha3Formato = sprintf('%02d', $fecha3->day)
                  . "/" . Utils::num_meses_corto_string($fecha3->month)
                  . "/" . $fecha3->year;
          }


          if ($item->estado == "DEBE") {

              if ($item->titulo == "INSCRIPCION") {
                  $referenciaInscParcial = $item->clavePago . $item->anioConc . "00";

                  $fechaRef1 = Carbon::parse($item->fecha1);
                  $fechaRef2 = Carbon::parse($item->fecha2);
                  $fechaRef3 = Carbon::parse($item->fecha3);

                  $fechaInscRef1 = "$fechaRef1->year-$fechaRef1->month-$fechaRef1->day";
                  $fechaInscRef2 = "$fechaRef2->year-$fechaRef2->month-$fechaRef2->day";
                  $fechaInscRef3 = "$fechaRef3->year-$fechaRef3->month-$fechaRef3->day";

                  $referenciaInscripcion1 = null;
                  $referenciaInscripcion2 = null;
                  $referenciaInscripcion3 = null;

                  if (!is_null($item->importe1)) {
                      $inscripcionRef = number_format(ceil($item->importe1), 2, '.', '');

                      if ($bancoSeleccionado == "BBVA")
                      {
                          //$referenciaInscripcion1 = $generarReferencia
                          //    ->crear($referenciaInscParcial, $fechaInscRef1, $inscripcionRef);
                          $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                              $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                              null, "P");

                          $referenciaInscripcion1 = $generarReferencia
                              ->crearBBVA($referenciaInscParcial, $fechaInscRef1, $inscripcionRef, $conpRefClave, $refNum);
                      }

                      if ($bancoSeleccionado == "HSBC")
                      {
                          $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                              $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                              null, "P");

                          $referenciaInscripcion1 = $generarReferencia
                              ->crearHSBC($referenciaInscParcial, $fechaInscRef1, $inscripcionRef, $conpRefClave, $refNum);
                      }

                  }

                  if (!is_null($item->importe2)) {
                      $inscripcionRef = number_format(ceil($item->importe2), 2, '.', '');

                      if ($bancoSeleccionado == "BBVA") {
                          /*
                          $referenciaInscripcion2 = $generarReferencia
                              ->crear($referenciaInscParcial, $fechaInscRef2, $inscripcionRef);
                          */
                          $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                              $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                              null, "P");

                          $referenciaInscripcion2 = $generarReferencia
                              ->crearBBVA($referenciaInscParcial, $fechaInscRef2, $inscripcionRef, $conpRefClave, $refNum);
                      }

                      if ($bancoSeleccionado == "HSBC") {
                          $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                              $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                              null, "P");

                          $referenciaInscripcion2 = $generarReferencia
                              ->crearHSBC($referenciaInscParcial, $fechaInscRef2, $inscripcionRef, $conpRefClave, $refNum);
                      }

                  }

                  if (!is_null($item->importe3)) {
                      $inscripcionRef = number_format(ceil($item->importe3), 2, '.', '');

                      if ($bancoSeleccionado == "BBVA") {
                          /*
                          $referenciaInscripcion3 = $generarReferencia
                              ->crear($referenciaInscParcial, $fechaInscRef3, $inscripcionRef);
                          */
                          $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                              $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                              null, "P");

                          $referenciaInscripcion3 = $generarReferencia
                              ->crearBBVA($referenciaInscParcial, $fechaInscRef3, $inscripcionRef, $conpRefClave, $refNum);
                      }

                      if ($bancoSeleccionado == "HSBC") {
                          $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                              $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                              null, "P");

                          $referenciaInscripcion3 = $generarReferencia
                              ->crearHSBC($referenciaInscParcial, $fechaInscRef3, $inscripcionRef, $conpRefClave, $refNum);
                      }
                  }

                  $item->referencia1 = $referenciaInscripcion1;
                  $item->referencia2 = $referenciaInscripcion2;
                  $item->referencia3 = $referenciaInscripcion3;
              }

              if ($item->titulo != "INSCRIPCION") {
                  // dd($item);
                  $referenciaPago1 = null;
                  $referenciaPago2 = null;
                  $referenciaPago3 = null;

                  if (!is_null($item->importe1)) {
                      $refNum = $item->anioConc . $item->concepto;
                      $refConcepto = $item->clavePago . $refNum;
                      $cuotaImporte = number_format(ceil($item->importe1), 2, '.', '');
                      $fechaImporte = $item->fecha1;

                      if ($bancoSeleccionado == "BBVA") {
                          //if($curso->curPlanPago == "A") {
                          $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                              $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                              null, "P");
                          //$refConcepto = $item->clavePago . $refNum;
                          //}
                          //$referenciaPago1 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);

                          $referenciaPago1 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                      }
                      if ($bancoSeleccionado == "HSBC") {
                          //if($curso->curPlanPago == "A") {
                          $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha1, $item->importe1, $item->refImpConc1,
                              $item->refImpBeca1, $item->refImpPP1, $item->refImpAntCred1, $item->refImpRecar1, null,
                              null, "P");
                          //$refConcepto = $item->clavePago . $refNum;
                          //}
                          $referenciaPago1 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                      }
                  }

                  if (!is_null($item->importe2)) {


                      $refNum = $item->anioConc . $item->concepto;
                      $refConcepto = $item->clavePago . $refNum;
                      $cuotaImporte = number_format(ceil($item->importe2), 2, '.', '');
                      $fechaImporte = $item->fecha2;

                      if ($bancoSeleccionado == "BBVA") {
                          //if($curso->curPlanPago == "A") {
                          $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                              $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                              null, "P");
                          //$refConcepto = $item->clavePago . $refNum;
                          //}
                          //$referenciaPago2 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
                          $referenciaPago2 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                      }
                      if ($bancoSeleccionado == "HSBC") {
                          //if($curso->curPlanPago == "A") {
                          $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha2, $item->importe2, $item->refImpConc2,
                              $item->refImpBeca2, $item->refImpPP2, $item->refImpAntCred2, $item->refImpRecar2, null,
                              null, "P");
                          //$refConcepto = $item->clavePago . $refNum;
                          //}
                          $referenciaPago2 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                      }
                      // }
                  }

                  if (!is_null($item->importe3))
                  {
                      $refNum = $item->anioConc . $item->concepto;
                      $refConcepto = $item->clavePago . $refNum;
                      $cuotaImporte = number_format(ceil($item->importe3), 2, '.', '');
                      $fechaImporte = $item->fecha3;

                      if ($bancoSeleccionado == "BBVA") {
                          //if($curso->curPlanPago == "A") {
                          $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                              $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                              null, "P");
                          //$refConcepto = $item->clavePago . $refNum;
                          //}
                          //$referenciaPago3 = $generarReferencia->crear($refConcepto, $fechaImporte, $cuotaImporte);
                          $referenciaPago3 = $generarReferencia->crearBBVA($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                      }
                      if ($bancoSeleccionado == "HSBC") {
                          //if($curso->curPlanPago == "A") {
                          $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                              $item->alumno_id, $item->programa_id, $item->anioCuota,
                              $item->concepto, $item->fecha3, $item->importe3, $item->refImpConc3,
                              $item->refImpBeca3, $item->refImpPP3, $item->refImpAntCred3, $item->refImpRecar3, null,
                              null, "P");
                          //$refConcepto = $item->clavePago . $refNum;
                          //}
                          $referenciaPago3 = $generarReferencia->crearHSBC($refConcepto, $fechaImporte, $cuotaImporte, $conpRefClave, $refNum);
                      }
                  }


                  $item->referenciaPago1 = $referenciaPago1;
                  $item->referenciaPago2 = $referenciaPago2;
                  $item->referenciaPago3 = $referenciaPago3;
              }
          }

          return $item;
      });

        // dd($procLibretaPago);


        $procLibretaPago = $procLibretaPago->groupBy("clavePago");


        $fechaActual = Carbon::now("CDT");
        $fechaActualFormatoTarjeta = sprintf('%02d', $fechaActual->day)
            . "/" . Utils::num_meses_corto_string($fechaActual->month)
            . "/" . $fechaActual->year;

        $horaActual = $fechaActual->format("H:i:s");

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        if ($bancoSeleccionado == "BBVA") {
            $pdf = PDF::loadView("reportes.pdf.tarjetas_pago_sp.tarjeta_pago_todo_bbva", [
                "pagos" => $procLibretaPago,
                "fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
                "horaActual" => $horaActual
            ]);
        }

        if ($bancoSeleccionado == "HSBC") {
            $pdf = PDF::loadView("reportes.pdf.tarjetas_pago_sp.tarjeta_pago_todo_hsbc", [
                "pagos" => $procLibretaPago,
                "fechaActualFormatoTarjeta" => $fechaActualFormatoTarjeta,
                "horaActual" => $horaActual
            ]);
        }


        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream("archivo" . '.pdf');
        return $pdf->download($nombreArchivo . '.pdf');




  }



}
