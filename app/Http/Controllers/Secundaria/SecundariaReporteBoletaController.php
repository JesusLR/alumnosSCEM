<?php

namespace App\Http\Controllers\Secundaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Curso;
use App\Http\Models\Secundaria\Secundaria_porcentajes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaReporteBoletaController extends Controller
{
    public function boleta($curso_id)
    {

        $cursos = Curso::select('cursos.id', 'periodos.id as periodo_id', 'periodos.departamento_id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->where('cursos.id', '=', $curso_id)
        ->first();

        // obtener los porcentajes 
        $secundaria_porcentajes = Secundaria_porcentajes::where('departamento_id', '=', $cursos->departamento_id)
        ->where('periodo_id', '=', $cursos->periodo_id)
        ->whereNull('deleted_at')
        ->first();
        

        $parametro_NombreArchivo = 'pdf_secundaria_boleta_calificaciones';
        $parametro_Titulo = "BOLETA DE CALIFICACIONES DEL ALUMNO(A)";
        $resultado_array =  DB::select("call procSecundariaCalificacionesCurso("
            .$curso_id
            .")");
        $resultado_collection = collect( $resultado_array );

        if($resultado_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno(a). Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }
        $resultado_registro = $resultado_array[0];


        $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');


        //dd($pagos_deudores_collection);
        $parametro_Alumno = $resultado_registro->nombres . " ". $resultado_registro->ape_paterno .
            " " . $resultado_registro->ape_materno;
        $parametro_Clave = $resultado_registro->clave_pago;
        $parametro_Grupo = $resultado_registro->gpoGrado . "". $resultado_registro->gpoClave;
        $parametro_Curp = $resultado_registro->curp;
        $parametro_Ciclo = $resultado_registro->ciclo_escolar;

        if($resultado_registro->ubicacion == "CME"){
            $campus = "CampusCME";
        }else{
            $campus = "CampusCVA";
        }

        //$fechaActual = Carbon::now();
        $fechaActual = Carbon::now('America/Merida');

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        

        $pdf = PDF::loadView('secundaria.PDF.'. $parametro_NombreArchivo, [
            "calificaciones" => $resultado_collection,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cicloEscolar" => $parametro_Ciclo,
            "curp" => $parametro_Curp,
            "nombreAlumno" => $parametro_Alumno,
            "clavepago" => $parametro_Clave,
            "gradogrupo" => $parametro_Grupo,
            "titulo" => $parametro_Titulo,
            "alumnoAgrupado" => $alumnoAgrupado,
            "secundaria_porcentajes" => $secundaria_porcentajes,
            "campus" => $campus
        ]);


        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');

    }
}
