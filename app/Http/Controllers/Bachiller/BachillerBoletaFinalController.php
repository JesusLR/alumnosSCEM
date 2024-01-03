<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Http\Models\Curso;
use App\Http\Models\Primaria\Primaria_calendario_calificaciones_docentes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Auth;

class BachillerBoletaFinalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $aluClave = Auth::user()->username;
        $fullName = Auth::user()->nombre;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(7);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(17);
        $perActualCVA = $departamentoCVA->perActual;

        $curso = Curso::select('cursos.id', 'cursos.periodo_id', 'cgt.plan_id', 'cursos.curEstado')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->where('alumnos.aluClave', '=', $aluClave)
        ->whereIn('cursos.periodo_id', [$perActualCME, $perActualCVA])
        ->first();

        return view('bachiller.boleta_final.show-index',[
            'aluClave' => $aluClave,
            'fullName' => $fullName
        ]);
    }

    public function imprimir(Request $request)
    {
        $aluClave = Auth::user()->username;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(7);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(17);
        $perActualCVA = $departamentoCVA->perActual;

        $curso = Curso::select('cursos.id', 'cursos.periodo_id', 'cgt.plan_id', 'cursos.curEstado')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->where('alumnos.aluClave', '=', $aluClave)
        ->whereIn('cursos.periodo_id', [$perActualCME, $perActualCVA])
        ->first();

        $periodoCME = Periodo::find($perActualCME);
        $periodoCVA = Periodo::find($perActualCVA);

        // Para boletas del 2022
        if ($periodoCME->perAnio >= 2022 || $periodoCVA->perAnio >= 2022) {
            $bachiller_inscritos = Bachiller_inscritos::select(
                'bachiller_inscritos.id',
                'bachiller_inscritos.curso_id',
                'bachiller_inscritos.bachiller_grupo_id',
                'bachiller_inscritos.insCalificacionParcial1',
                'bachiller_inscritos.insFaltasParcial1',
                'bachiller_inscritos.insCalificacionParcial2',
                'bachiller_inscritos.insFaltasParcial2',
                'bachiller_inscritos.insCalificacionParcial3',
                'bachiller_inscritos.insFaltasParcial3',
                'bachiller_inscritos.insCalificacionFinal',
                'bachiller_inscritos.insPromedioParcial',
                'bachiller_inscritos.insPuntosObtenidosCorte1',
                'bachiller_inscritos.insPuntosObtenidosCorte2',
                'bachiller_inscritos.insPuntosObtenidosCorte3',
                'bachiller_inscritos.insPuntosMaximosCorte1',
                'bachiller_inscritos.insPuntosMaximosCorte2',
                'bachiller_inscritos.insPuntosMaximosCorte3',
                'bachiller_inscritos.insPuntosObtenidosAcumulados',
                'bachiller_inscritos.insPuntosMaximosAcumulados',
                'alumnos.id AS alumno_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'bachiller_grupos.gpoClave',
                'bachiller_grupos.gpoGrado',
                'bachiller_grupos.gpoMatComplementaria',
                'bachiller_grupos.bachiller_materia_acd_id',
                'bachiller_grupos.bachiller_materia_id',
                'bachiller_materias.id as bachiller_materia_id',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'bachiller_materias.matNombreCorto',
                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perNumero',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre',
                'planes.id as plan_id',
                'planes.planClave',
                'ubicacion.ubiClave',
                'cgt.cgtGradoSemestre as semestre',
                'cgt.cgtGrupo as grupo',
                'cursos.curEstado'

            )
                ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
                ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->leftJoin('bachiller_materias_acd', 'bachiller_grupos.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
                ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
                ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->whereIn('periodos.id', [$perActualCME, $perActualCVA])
                ->where('alumnos.aluClave', $aluClave)
                ->whereNull('bachiller_inscritos.deleted_at')
                ->whereNull('cursos.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->whereNull('periodos.deleted_at')
                ->whereNull('bachiller_empleados.deleted_at')
                ->whereNull('departamentos.deleted_at')
                ->whereNull('planes.deleted_at')
                ->whereNull('cgt.deleted_at')
                ->whereNull('programas.deleted_at')
                ->whereNull('ubicacion.deleted_at')
                ->orderBy('personas.perApellido1')
                ->orderBy('personas.perApellido2')
                ->orderBy('personas.perNombre')
                ->orderBy('bachiller_materias.matClave', 'ASC')
                ->get();


            if (count($bachiller_inscritos) < 1) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');


            $alumno = $bachiller_inscritos->groupBy('aluClave');
            $bachiller_materias = $bachiller_inscritos->groupBy('bachiller_materia_id');

            $parametro_NombreArchivo = "pdf_boleta_final";
            $pdf = PDF::loadView('bachiller.boleta_final.pdf.' . $parametro_NombreArchivo, [
                "cicloEscolar" => Utils::num_meses_corto_string(\Carbon\Carbon::parse($bachiller_inscritos[0]->perFechaInicial)->format('m')) . '/' . $bachiller_inscritos[0]->perAnio . '-' . Utils::num_meses_corto_string(\Carbon\Carbon::parse($bachiller_inscritos[0]->perFechaFinal)->format('m')) . '/' . $bachiller_inscritos[0]->perAnio,
                "alumno" => $alumno,
                "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
                "bachiller_materias" => $bachiller_materias
            ]);

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }

        if($periodo->perAnio < 2022){
            return "En proceso...";
        }
    }

    public function adeudo()
    {
        $aluClave = Auth::user()->username;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(7);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(17);
        $perActualCVA = $departamentoCVA->perActual;

        $curso = Curso::select('cursos.id', 'cursos.periodo_id', 'cgt.plan_id', 'cursos.curEstado')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->where('alumnos.aluClave', '=', $aluClave)
        ->whereIn('cursos.periodo_id', [$perActualCME, $perActualCVA])
        ->first();

        $periodoCME = Periodo::find($perActualCME);
        $periodoCVA = Periodo::find($perActualCVA);

        // Para boletas del 2022
        if ($periodoCME->perAnio >= 2022 || $periodoCVA->perAnio >= 2022) {
            $bachiller_inscritos = Bachiller_inscritos::select(
                'bachiller_inscritos.id',
                'bachiller_inscritos.curso_id',
                'bachiller_inscritos.bachiller_grupo_id',
                'bachiller_inscritos.insCalificacionParcial1',
                'bachiller_inscritos.insFaltasParcial1',
                'bachiller_inscritos.insCalificacionParcial2',
                'bachiller_inscritos.insFaltasParcial2',
                'bachiller_inscritos.insCalificacionParcial3',
                'bachiller_inscritos.insFaltasParcial3',
                'bachiller_inscritos.insCalificacionFinal',
                'bachiller_inscritos.insPromedioParcial',
                'bachiller_inscritos.insPuntosObtenidosCorte1',
                'bachiller_inscritos.insPuntosObtenidosCorte2',
                'bachiller_inscritos.insPuntosObtenidosCorte3',
                'bachiller_inscritos.insPuntosMaximosCorte1',
                'bachiller_inscritos.insPuntosMaximosCorte2',
                'bachiller_inscritos.insPuntosMaximosCorte3',
                'bachiller_inscritos.insPuntosObtenidosAcumulados',
                'bachiller_inscritos.insPuntosMaximosAcumulados',
                'alumnos.id AS alumno_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'bachiller_grupos.gpoClave',
                'bachiller_grupos.gpoGrado',
                'bachiller_grupos.gpoMatComplementaria',
                'bachiller_grupos.bachiller_materia_acd_id',
                'bachiller_grupos.bachiller_materia_id',
                'bachiller_materias.id as bachiller_materia_id',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'bachiller_materias.matNombreCorto',
                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perNumero',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre',
                'planes.id as plan_id',
                'planes.planClave',
                'ubicacion.ubiClave',
                'cgt.cgtGradoSemestre as semestre',
                'cgt.cgtGrupo as grupo',
                'cursos.curEstado'

            )
                ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
                ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->leftJoin('bachiller_materias_acd', 'bachiller_grupos.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
                ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
                ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->whereIn('periodos.id', [$perActualCME, $perActualCVA])
                ->where('alumnos.aluClave', $aluClave)
                ->whereNull('bachiller_inscritos.deleted_at')
                ->whereNull('cursos.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->whereNull('periodos.deleted_at')
                ->whereNull('bachiller_empleados.deleted_at')
                ->whereNull('departamentos.deleted_at')
                ->whereNull('planes.deleted_at')
                ->whereNull('cgt.deleted_at')
                ->whereNull('programas.deleted_at')
                ->whereNull('ubicacion.deleted_at')
                ->orderBy('personas.perApellido1')
                ->orderBy('personas.perApellido2')
                ->orderBy('personas.perNombre')
                ->orderBy('bachiller_materias.matClave', 'ASC')
                ->get();


            if (count($bachiller_inscritos) < 1) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');


            $alumno = $bachiller_inscritos->groupBy('aluClave');
            $bachiller_materias = $bachiller_inscritos->groupBy('bachiller_materia_id');

            $parametro_NombreArchivo = "pdf_adeudo";
            // view("bachiller.boleta_final.pdf.pdf_adeudo");
            $pdf = PDF::loadView('bachiller.boleta_final.pdf.' . $parametro_NombreArchivo, [
                "cicloEscolar" => Utils::num_meses_corto_string(\Carbon\Carbon::parse($bachiller_inscritos[0]->perFechaInicial)->format('m')) . '/' . $bachiller_inscritos[0]->perAnio . '-' . Utils::num_meses_corto_string(\Carbon\Carbon::parse($bachiller_inscritos[0]->perFechaFinal)->format('m')) . '/' . $bachiller_inscritos[0]->perAnio,
                "alumno" => $alumno,
                "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
                "bachiller_materias" => $bachiller_materias
            ]);

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }

        if($periodo->perAnio < 2022){
            return "En proceso...";
        }
    }
}
