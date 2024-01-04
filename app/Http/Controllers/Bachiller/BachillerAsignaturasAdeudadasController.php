<?php

namespace App\Http\Controllers\Bachiller;

use DB;

use App\Models\Pago;
use App\Models\Alumno;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BachillerAsignaturasAdeudadasController extends Controller
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
      // $procAppAsignaturas = DB::select("call procAppAsignaturas(".$claveAlumno.")");


      return view('bachiller.adeudadas.show-list', [
        "alumno" => $alumno,
        "persona" => $persona
      ]);
    }


    public function list(Request $request)
    {
      $alumno = Alumno::where('aluClave', auth()->user()->username)->first();
      $curso = $alumno->cursos()->with('cgt')->where('curEstado', 'R')
            ->whereNull('deleted_at')
            ->latest("curFechaRegistro")
            ->first();

      $procAppAsignaturas = DB::select("call procBachillerReprobadasAlumno(".$alumno->aluClave.")");
        return DataTables::of($procAppAsignaturas)
        ->setRowClass(static function($reprobada) {
          return $reprobada->maxSemestre - $reprobada->matSemestre > 1 ? 'urgente-aprobar-row' : '';
        })
        ->make(true);
    }//list.

}
