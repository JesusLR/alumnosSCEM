<?php

namespace App\Http\Controllers;

use DB;

use App\Models\Pago;
use App\Models\Alumno;
use App\Models\CalendarioExamen;
use App\Models\Curso;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ExtraordinariosController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permisos:alumno');
    }

    public function check($start, $end)
    {
      return Carbon::now()->between(Carbon::createFromFormat('Y-m-d', $start), Carbon::createFromFormat('Y-m-d', $end));
    }

    public function extOportunidad_DentroDelPeriodo()
    {
      $curso = Curso::select('periodo_id')
      ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
      ->where('alumnos.aluClave',Auth::user()->username)
      ->orderBy('cursos.created_at', 'desc')
      ->first();

      $calendario = CalendarioExamen::where('periodo_id', $curso->periodo_id)->first();
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

      // DD($claveAlumno);
      $extOportunidad_DentroDelPeriodo = $this->extOportunidad_DentroDelPeriodo();
      $procAppExtraordinarios = DB::select("call procAppExtraordinarios(".$claveAlumno.", ".$extOportunidad_DentroDelPeriodo.")");

      // dd(".$claveAlumno.", ".$extOportunidad_DentroDelPeriodo.");

      return view('alumnos_info.extraordinarios.show-list', [
        "alumno" => $alumno,
        "persona" => $persona
      ]);
    }



    public function list(Request $request)
    {
      $claveAlumno = (Auth::user()->username);
      $extOportunidad_DentroDelPeriodo = $this->extOportunidad_DentroDelPeriodo();
      $procAppExtraordinarios = DB::select("call procAppExtraordinarios(".$claveAlumno.", ".$extOportunidad_DentroDelPeriodo.")");
        return DataTables::of($procAppExtraordinarios)
        ->make(true);
    }//list.


}
