<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

use App\Http\Models\Portal_configuracion;

class EncuestaController extends Controller
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
  public function make()
  {
    $encuesta = self::buscarEncuesta(auth()->user()->username)->first();
    // 
    $configEvaluacionDocente = Portal_configuracion::Where('pcClave', 'EVALUACION_DOCENTE')->first();
    $evaluacionDocenteActivo = $configEvaluacionDocente->pcEstado == 'A' ? true: false;
    $EVALUACION_DOCENTE = $evaluacionDocenteActivo;
    //
    if($EVALUACION_DOCENTE && $encuesta && $encuesta->encValidado == 'S') {
      alert('Encuesta realizada', 'Ya has realizado la encuesta', 'warning')->showConfirmButton();
      return back()->withInput();
    }

    return view('encuesta.create', [
      'encuesta' => $encuesta,
    ]);
  }

  public function verificar_codigo(Request $request) {
    $encuesta = self::buscarEncuesta(auth()->user()->username)->first();

    if($encuesta && $request->codigo == str_pad($encuesta->encCodigo, 6, '0', STR_PAD_LEFT)) {
      try {
        $this->actualizarEncuestas(auth()->user()->username);
      } catch (Exception $e) {
        alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
        return back()->withInput();
      }
      alert('Validado', 'Se ha realizado la validación exitosa del código.', 'success')->showConfirmButton();
      return redirect('calificaciones');
    }

    alert('código incorrecto', 'se ha ingresado un código que no es el correspondiente a su encuesta.', 'warning')->showConfirmButton();
    return back()->withInput();
  }

  /**
   * @param int $aluClave
   */
  private static function buscarEncuesta($aluClave) {

    return DB::table('validaencuesta')->where('encAluClave', $aluClave);
  }

  /**
   * @param int $aluClave
   */
  private function actualizarEncuestas($aluClave) {
    try {
      self::buscarEncuesta($aluClave)->update(['encValidado' => 'S']);
    } catch (Exception $e) {
      throw $e;
    }
  }

}
