<?php

namespace App\Http\Controllers\Bachiller;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Pago;
use App\Models\Alumno;
use App\Models\Departamento;
use App\Models\Periodo;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class BachillerHorarioYucatanController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('horarios');
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

      $procAppHorarios = DB::select("call procBachillerAppHorariosAlumnoYucatanPortal(".$alumno->aluClave.")");
      $agrupamos = collect($procAppHorarios)->groupBy('bachiller_grupo_id');

      return view('bachiller.horario.show-list2', [
        "alumno" => $alumno,
        "persona" => $persona,
        "agrupamos" => $agrupamos
      ]);
    }


    

    public function list(Request $request)
    {
      $claveAlumno = (Auth::user()->username);
      $procAppHorarios = DB::select("call procBachillerAppHorariosAlumnoYucatanPortal(".$claveAlumno.")");
        return DataTables::of($procAppHorarios)
        ->make(true);
    }//list.

     public function imprimir($aluClave = null)
    {
        // dd($request->plan_id, $request->programa_id, $request->periodo_id, $request->gpoGrado, $request->gpoClave, $request->aluClave);     

      
        $llamar_sp = DB::select("call procBachillerAppHorariosAlumnoYucatanPortal(".$aluClave.")");
            $resultado_collection = collect($llamar_sp);

            // Para obtener las fechas del periodo seleccionado 
            if($resultado_collection[0]->ubiClave == "CME"){
              $dep = Departamento::findOrFail(7);
              $periodo_id = $dep->perActual;              
            }

            if($resultado_collection[0]->ubiClave == "CVA"){
              $dep = Departamento::findOrFail(17);
              $periodo_id = $dep->perActual;
            }

            $periodo = Periodo::findOrFail($periodo_id);
            $perFechaInicialMes = Utils::num_meses_corto_string(\Carbon\Carbon::parse($periodo->perFechaInicial)->format('m'));
            $perFechaFinalMes = Utils::num_meses_corto_string(\Carbon\Carbon::parse($periodo->perFechaFinal)->format('m'));
            $cicloEscolar = \Carbon\Carbon::parse($periodo->perFechaInicial)->format('d').'/'.$perFechaInicialMes.'/'.\Carbon\Carbon::parse($periodo->perFechaInicial)->format('Y').' - '.\Carbon\Carbon::parse($periodo->perFechaInicial)->format('d').'/'.$perFechaFinalMes.'/'.\Carbon\Carbon::parse($periodo->perFechaFinal)->format('Y');

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $mesCorto = Utils::num_meses_corto_string($fechaActual->format('m'));
            $fechaHoy = $fechaActual->format('d').'/'.$mesCorto.'/'.$fechaActual->format('Y');

            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay horario disponible para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $parametro_NombreArchivo = "pdf_horario_alumno_nuevo";
            // view('bachiller.horario.PDF.pdf_horario_alumno_nuevo')
            $pdf = PDF::loadView('bachiller.horario.PDF.' . $parametro_NombreArchivo, [
                "fechaActual" => $fechaHoy,
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $cicloEscolar,
                "alumno" => $resultado_collection
            ]);



            // $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');

       
       
        
    }


}
