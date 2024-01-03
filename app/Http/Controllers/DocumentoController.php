<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class DocumentoController extends Controller
{
    public function __construct() {
        $this->middleware('auth');

    }

    public function index()
    {
        $url = '';
        $info = $this->getInfo();
        
        if ($info->ubiClave != "CME" && $info->ubiClave != "CVA") return redirect()->back();
        if ($info->depClave != "SUP" && $info->depClave != "POS") return redirect()->back();

        if ($info->depClave == "SUP") $url = 'subir_docs_licenciatura.mp4';
        if ($info->depClave == "POS") $url = 'subir_docs_posgrado.mp4';

        return view('documentos.main', compact('url'));
    }

    public function url()
    {
        $info = $this->getInfo();
        if ($info->ubiClave == "CME") return redirect('https://servicios.unimodelo.edu.mx/merida/documentos');
        if ($info->ubiClave == "CVA") return redirect('https://servicios.unimodelo.edu.mx/valladolid/documentos/');
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
}
