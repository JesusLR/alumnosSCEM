<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PrimariaReporteBoletaController extends Controller
{
    public function boleta($curso_id)
    {


        $parametro_NombreArchivo = 'pdf_primaria_boleta_calificaciones';
        $parametro_Titulo = "BOLETA DE CALIFICACIONES DEL ALUMNO(A)";
        $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesCurso("
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
        $parametro_tipo = $resultado_registro->carrera; //PRB
        $ubicacion = $resultado_registro->ubicacion;
        $depClaveOficial = $resultado_registro->depClaveOficial;

        if($ubicacion == "CME"){
            $campus = "primariaCME";
        }else{
            $campus = "primariaCVA";
        }

        //$fechaActual = Carbon::now();
        $fechaActual = Carbon::now('America/Merida');

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        

        // view('primaria.PDF.pdf_primaria_boleta_calificaciones');
        $pdf = PDF::loadView('primaria.PDF.'. $parametro_NombreArchivo, [
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
            "parametro_tipo" => $parametro_tipo,
            "campus" => $campus,
            "depClaveOficial" => $depClaveOficial
        ]);


        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');

    }
}
