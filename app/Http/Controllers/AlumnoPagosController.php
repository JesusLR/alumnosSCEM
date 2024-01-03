<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Pago;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AlumnoPagosController extends Controller
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
        $alumno_id = $request->alumno_id;
        $alumno = Alumno::where("aluClave", "=",$alumno_id)->first();

        if (!$alumno) {
            alert()
            ->error('Ups...', 'Usuario incorrecto')
            ->showConfirmButton()
            ->autoClose(5000);

            return redirect()->route('login')->withInput();
        }


        $persona = $alumno->persona;


        if ($alumno->aluClave != Auth::user()->username) {
            alert()
            ->error('Ups...', 'Usuario incorrecto')
            ->showConfirmButton()
            ->autoClose(5000);

            return redirect()->route('login')->withInput();
        }



        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);

        if (Auth::user()->depClave == "SUP" || Auth::user()->depClave == "POS")
        {
            $pagos = DB::select("call procDeudasAlumnoParaPago("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }

        if (Auth::user()->depClave == "BAC")
        {
            $pagos = DB::select("call procDeudasAlumnoParaPagoBAC("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }

        if (Auth::user()->depClave == "SEC")
        {
            $pagos = DB::select("call procDeudasAlumnoParaPagoSEC("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }

        if (Auth::user()->depClave == "PRI")
        {
            $pagos = DB::select("call procDeudasAlumnoParaPagoPRI("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }

        if (Auth::user()->depClave == "PRE")
        {
            $pagos = DB::select("call procDeudasAlumnoParaPagoPRE("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }


        if (Auth::user()->depClave == "MAT")
        {
            $pagos = DB::select("call procDeudasAlumnoParaPagoMAT("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }


        $pago = DB::table($temporary_table_name)->where("cve_fila", "=", "TL$")->first();

        $concepto = DB::table("conceptospago")->where("conpClave", "=", $pago->conc_pago)->first();

        // $pagos = collect( $datatable_array );
        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );

        $info = $this->getInfo();

        return view('alumno_pagos.show-list-consulta', compact('alumno', 'persona', 'pago','concepto', 'info'));
    }

    private function getInfo() {
        return Curso::select(
            'departamentos.depClave',
             'ubicacion.ubiClave'
         )
         ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
         ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
         ->join('planes', 'cgt.plan_id', '=', 'planes.id')
         ->join('programas', 'planes.programa_id', '=', 'programas.id')
         ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
         ->join('departamentos',function($join){
             $join->on('escuelas.departamento_id', '=', 'departamentos.id')
                 ->on('cursos.periodo_id', '=', 'departamentos.perActual');
         })
         ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
         ->where('alumnos.aluClave', Auth::user()->username)
         ->first();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function list(Request $request)
    {
        $alumno_id = $request->alumno_id;
        $alumno = Alumno::findOrFail($alumno_id);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $temporary_table_name = "_". substr(str_shuffle($permitted_chars), 0, 15);

        /*
        $procDeudas = DB::select("call procDeudasAlumnoParaPago("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        */


        if (Auth::user()->depClave == "SUP" || Auth::user()->depClave == "POS")
        {
            $procDeudas = DB::select("call procDeudasAlumnoParaPago("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }

        if (Auth::user()->depClave == "BAC")
        {
            $procDeudas = DB::select("call procDeudasAlumnoParaPagoBAC("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }

        if (Auth::user()->depClave == "SEC")
        {
            $procDeudas = DB::select("call procDeudasAlumnoParaPagoSEC("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }

        if (Auth::user()->depClave == "PRI")
        {
            $procDeudas = DB::select("call procDeudasAlumnoParaPagoPRI("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }

        if (Auth::user()->depClave == "PRE")
        {
            $procDeudas = DB::select("call procDeudasAlumnoParaPagoPRE("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }


        if (Auth::user()->depClave == "MAT")
        {
            $procDeudas = DB::select("call procDeudasAlumnoParaPagoMAT("
                ."1"
                .",".$alumno->aluClave
                .","."'I'"
               .",'".$temporary_table_name."')");
        }


        $pagos = DB::table($temporary_table_name)
            ->where("cve_fila", "<>", "TL$")
            ->get();


        /*
        $pagos = DB::table($temporary_table_name)
            ->select(
                $temporary_table_name.'.cve_fila',
                $temporary_table_name.'.cve_pago',
                $temporary_table_name.'.conc_pago',
                $temporary_table_name.'.total_mes',
                $temporary_table_name.'.perAnioPago',
                $temporary_table_name.'.perNumero',
                $temporary_table_name.'.convNumero',
                $temporary_table_name.'.pagRefPago',
                $temporary_table_name.'.descripcion_pago',
                $temporary_table_name.'.pagFechaPago',
                $temporary_table_name.'.esDeuda')
            ->leftJoin('conceptospago', $temporary_table_name.'.conc_pago', '=', 'conceptospago.conpClave')
            ->where($temporary_table_name.'.cve_fila', "<>", "TL$")
            ->orderBy($temporary_table_name.'.perAnioPago', "desc")
            ->orderBy('conceptospago.ordenReportes', "desc")
            ->get();
            */

        // $pagos = collect( $datatable_array );
        // dd($pagos);
        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );


        return DataTables::of($pagos)
            ->addColumn('action', function($query) {
                $concepto = DB::table("conceptospago")->where("conpClave", "=", $query->conc_pago)->first();

                $btnAplicaPago = "";
                if ($query->puedePagar == "SI" && $concepto) {
                    $btnAplicaPago = '<form style="display: inline-block;" action="'. url('/pagos/ficha_general/ficha_alumno') .'" method="POST" target="_blank">
                    <input type="hidden" name="aluClave" value="' . $query->cve_pago .'">
                    <input type="hidden" name="cuoAnio" value="' . $query->perAnioPago . '">
                    <input type="hidden" name="cuoConcepto" value="' .  $query->conc_pago.'">
                    <input type="hidden" name="importeNormal" value="' .$query->total_mes.'">
                    <input type="hidden" name="nomConcepto" value="' .$concepto->conpNombre. ' ' . $query->perAnioPago . '">
                    <input type="hidden" name="perNumero" value="' .$query->perNumero.'">
                    <input type="hidden" name="convNumero" value="' .$query->convNumero.'">

                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <button type="submit" style=" background: transparent; padding: 0px;
                    border: 0px;
                    color: #0277bd;"  class="button button--icon js-button js-ripple-effect" title="Generar Ficha Pago">
                        <i class="material-icons">picture_as_pdf</i>
                    </button>

                </form>
                <div class="custom-control custom-checkbox" style="display:inline-block;margin-left:10px;">
                    <input type="checkbox" class="checkpago" name="aluCheckPago" id="aluCheckPago'.$query->cve_fila.'" data-id="'.$query->cve_fila.'" data-importe="'.$query->total_mes.'">
                    <label class="custom-control-label" style="font-size:12px;" for="aluCheckPago'.$query->cve_fila.'">seleccionar pago</label>
                </div>';
                }

                return $btnAplicaPago;
            })
        ->make(true);
    }//list.



}
