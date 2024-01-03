<?php

namespace App\Http\Controllers;

use DB;

use Carbon\Carbon;
use App\Http\Models\Pago;

use App\Http\Models\Alumno;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrdinariosController extends Controller
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


      // $procAppOrdinarios = DB::select("call procAppOrdinarios(".$claveAlumno.")");

      // dd($procAppOrdinarios);

      return view('alumnos_info.ordinarios.show-list', [
        "alumno" => $alumno,
        "persona" => $persona
      ]);
    }


    public function list(Request $request)
    {
      $claveAlumno = (Auth::user()->username);
      $procAppOrdinarios = DB::select("call procAppOrdinarios(".$claveAlumno.")");
      return DataTables::of($procAppOrdinarios)
      ->addColumn('fecha', function($item) {
        return Carbon::parse($item->fecha)->format("d-m-Y");
    })
      ->make(true);
    }//list.

}
