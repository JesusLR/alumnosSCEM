<?php

namespace App\Http\Controllers;

use DB;

use App\Models\Pago;
use App\Models\Alumno;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CalifExtraordinarioController extends Controller
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
      return view('alumnos_info.califextraordinarios.show-list',[
        "alumno" => $alumno,
        "persona" => $persona
      ]);
    }


    public function list(Request $request)
    {
      $claveAlumno = (Auth::user()->username);
      $procAppCalifExtra = DB::select("call procAppCalifExtra(".$claveAlumno.")");
        return DataTables::of($procAppCalifExtra)
      ->make(true);

    }//list.

}
