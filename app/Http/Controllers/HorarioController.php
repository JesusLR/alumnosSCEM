<?php

namespace App\Http\Controllers;

use DB;

use App\Http\Models\Pago;
use App\Http\Models\Alumno;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HorarioController extends Controller
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
      // $procAppCalificaciones = DB::select("call procAppCalificaciones(".$claveAlumno.")");
      // $procAppOrdinarios = DB::select("call procAppOrdinarios(".$claveAlumno.")");
      // $procAppExtraordinarios = DB::select("call procAppExtraordinarios(".$claveAlumno.")");
      // $procAppCalifExtra = DB::select("call procAppCalifExtra(".$claveAlumno.")");
      
      // dd($procAppHorarios);

      return view('alumnos_info.horario.show-list', [
        "alumno" => $alumno,
        "persona" => $persona
      ]);
    }


    

    public function list(Request $request)
    {
      $claveAlumno = (Auth::user()->username);
      $procAppHorarios = DB::select("call procAppHorarios(".$claveAlumno.")");
        return DataTables::of($procAppHorarios)
        ->make(true);
    }//list.


}
