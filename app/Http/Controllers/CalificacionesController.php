<?php

namespace App\Http\Controllers;

use DB;

use App\Http\Models\Pago;
use App\Http\Models\Alumno;
use App\Http\Models\Curso;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

use App\Http\Models\Portal_configuracion;

class CalificacionesController extends Controller
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
      $ubicacion = self::ubicacion_alumno($claveAlumno);
      $encuesta = DB::table('validaencuesta')->where('encAluClave', $claveAlumno)->first();
      // 
      $configEvaluacionDocente = Portal_configuracion::Where('pcClave', 'EVALUACION_DOCENTE')->first();
      $evaluacionDocenteActivo = $configEvaluacionDocente->pcEstado == 'A' ? true: false;
      $EVALUACION_DOCENTE = $evaluacionDocenteActivo;
      //
      if($EVALUACION_DOCENTE && $encuesta && $encuesta->encValidado == 'N' && auth()->user()->depClave == "SUP" && ($ubicacion->ubiClave == "CME" || $ubicacion->ubiClave == "CVA")) {
        alert('Encuesta pendiente', 'Requerimos que contestes la encuesta antes de poder ver tus calificaciones.', 'warning')->showConfirmButton();
        return redirect('encuesta');
      }
      $alumno = Alumno::where("aluClave", "=",$claveAlumno)->first();
      $persona = $alumno->persona;
      // $procAppCalificaciones = DB::select("call procAppCalificaciones(".$claveAlumno.")");
      // dd($procAppCalificaciones);
      $view = auth()->user()->depClave == "POS" ? 'show-list-pos': 'show-list';
      $curso = $alumno->cursos()->where('curEstado', 'R')
            ->whereNull('deleted_at')
            ->orderBy("curFechaRegistro", "desc")
            ->latest()->first();
      $perAnioPago = $curso->periodo->departamento->periodoActual->perAnioPago;

      return view('alumnos_info.calificaciones.'.$view, [
        "alumno" => $alumno,
        "persona" => $persona,
        'perAnioPago' => $perAnioPago
      ]);
    }


    public function list(Request $request)
    {
      $claveAlumno = (Auth::user()->username);
      $procAppCalificaciones = DB::select("call procAppCalificaciones(".$claveAlumno.")");
        return DataTables::of($procAppCalificaciones)
        ->make(true);
    }//list.

    private static function ubicacion_alumno($aluClave) {
      $curso = Curso::whereHas('alumno', function($query) use ($aluClave) {
              $query->where('aluClave', $aluClave);
            })->latest('curFechaRegistro')->first();
      return $curso ? $curso->periodo->departamento->ubicacion : null;
    }

}
