<?php

namespace App\Http\Controllers\Preescolar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
use Debugbar;
use PDF;


use App\Models\Grupo;
use App\Models\Curso;
use App\Models\Cgt;
use App\Models\Aula;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\Periodo;
use App\Models\Programa;
use App\Models\Plan;
use App\Models\Escuela;
use App\Models\Persona;
use App\Models\Preescolar_grupo;
use App\Models\Preescolar_inscrito;
use App\Models\Preescolar_materia;
use App\Models\Preescolar_calificacion;

class PreescolarCalificacionesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:preescolarcalificaciones',['except' => ['index']]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inscrito_id = $request->inscrito_id;
        $grupo_id = $request->grupo_id;
        $trimestre_a_evaluar = 1;

        $calificaciones = DB::table('preescolar_calificaciones')
            ->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id)
            ->where('preescolar_calificaciones.trimestre1',$trimestre_a_evaluar)
            ->where('preescolar_calificaciones.aplica','SI')
            ->get();

        //OBTENER GRUPO SELECCIONADO
        //$grupo = Grupo::with('plan.programa', 'materia', 'empleado.persona')->find($grupo_id);
        //OBTENER PROMEDIO PONDERADO EN MATERIA
        //$materia = Preescolar_materia::where('id', $grupo->preescolar_materia_id)->first();
        //$escuela = Escuela::where('id', $grupo->plan->programa->escuela_id)->first();

        $grupo = Preescolar_grupo::with('preescolar_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')
            ->find($grupo_id);

        $inscrito = Preescolar_inscrito::find($inscrito_id);
        $inscrito_faltas = "";
        $inscrito_observaciones = "";
        if ($trimestre_a_evaluar == 1)
        {
            $inscrito_faltas = $inscrito->trimestre1_faltas;
            $inscrito_observaciones = $inscrito->trimestre1_observaciones;
        }
        if ($trimestre_a_evaluar == 2)
        {
            $inscrito_faltas = $inscrito->trimestre2_faltas;
            $inscrito_observaciones = $inscrito->trimestre2_observaciones;
        }
        if ($trimestre_a_evaluar == 3)
        {
            $inscrito_faltas = $inscrito->trimestre3_faltas;
            $inscrito_observaciones = $inscrito->trimestre3_observaciones;
        }
        $curso = Curso::with('alumno.persona')->find($inscrito->curso_id);
        $trimestre1_edicion = 'SI';
        $grupo_abierto = 'SI';
        //dd($empleado);
        /*
        $grupo = Preescolar_grupo::with('preescolar_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')
            ->select('preescolar_grupos.*')
            ->where('id',$grupo_id);
        */
        /*
        $data = DB::table('preescolar_calificaciones')
            ->select('preescolar_calificaciones.id',
                'preescolarpreescolar_calificaciones.tipo as categoria',
                'preescolar_calificaciones.trimestre1 as trimestre',
                'preescolar_calificaciones.rubrica as aprendizaje',
                'preescolar_calificaciones.trimestre1_nivel as nivel')
            ->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id);
            //->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id)
            //->orderBy("alumnos.id", "desc");
        */
        //return view('table_edit', compact('data'));

        return View('preescolar.show-list-calificaciones',
            compact('calificaciones',
                'grupo',
                  'grupo_id',
                  'inscrito_id',
                  'inscrito_faltas',
                  'inscrito_observaciones',
                  'curso',
                  'trimestre_a_evaluar',
                  'trimestre1_edicion',
                  'grupo_abierto'));

    }



    public function create()
    {

    }


    public function update(Request $request, $id)
    {

    }

    public function store(Request $request)
    {
        $grupo_id = $request->grupo_id;
        $trimestre1_edicion = $request->trimestre1_edicion;
        $inscrito_id = $request->inscrito_id;
        $trimestre_a_evaluar = $request->trimestre_a_evaluar;
        $trimestre1_faltas = 0;
        $trimestre1_observaciones = "";


        try {

            $rubricas = DB::table('preescolar_calificaciones')
                ->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id)
                ->where('preescolar_calificaciones.trimestre1',$trimestre_a_evaluar)
                ->where('preescolar_calificaciones.aplica','SI')
                ->get();

            $calificaciones = $request->calificaciones;


            if ($trimestre_a_evaluar == 1)
            {
                $trimestre1Col  = $request->has("calificaciones.trimestre1")  ? collect($calificaciones["trimestre1"])  : collect();
                $trimestre1_faltas = $request->trimestreFaltas;
                $trimestre1_observaciones = $request->trimestreObservaciones;
            }



            // dd($inscritos->map(function ($item, $key) {
            //     return $item->id;
            // })->all());

            foreach ($rubricas as $rubrica) {
                $calificacion = Preescolar_calificacion::where('id', $rubrica->id)->first();

                if ($trimestre_a_evaluar == 1)
                {
                    $inscCalificacionRubrica = $trimestre1Col->filter(function ($value, $key) use ($rubrica) {
                        return $key == $rubrica->id;
                    })->first();

                    if ($calificacion) {
                        $calificacion->trimestre1_nivel = $inscCalificacionRubrica != null ? $inscCalificacionRubrica : $calificacion->trimestre1_nivel;
                        $calificacion->save();

                        //$result =  DB::select("call procInscritoPromedioParcial("." ".$inscrito->id." )");
                    }
                }
            }

            $inscritofaltas = Preescolar_inscrito::where('id', $inscrito_id)->first();
            if ($inscritofaltas) {
                if ($trimestre_a_evaluar == 1)
                {
                    $inscritofaltas->trimestre1_faltas = $trimestre1_faltas != null ? $trimestre1_faltas : $inscritofaltas->trimestre1_faltas;
                    $inscritofaltas->trimestre1_observaciones = $trimestre1_observaciones != null ? $trimestre1_observaciones : $inscritofaltas->trimestre1_observaciones;
                }

                $inscritofaltas->save();
            }


            alert('Escuela Modelo', 'Se registraron las calificaciones con éxito', 'success')->showConfirmButton()->autoClose(3000);
            return redirect('preescolarinscritos/'.$grupo_id);

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('preescolarinscritos/'.$grupo_id )->withInput();
        }
    }

    public function reportePrimerTrimestre($inscrito_id, $personas_id, $gpoGrado, $gpoClave){

        $trimestre_a_evaluar = 1;

        $calificaciones_array = DB::table('preescolar_calificaciones')
            ->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id)
            ->where('preescolar_calificaciones.trimestre1',$trimestre_a_evaluar)
            ->where('preescolar_calificaciones.aplica','SI')
            ->orderBy('preescolar_calificaciones.rubrica_id','asc')
            ->get();

        $calificaciones_collection = collect( $calificaciones_array );

        $persona = Persona::findOrFail($personas_id);
        $inscritos = Preescolar_inscrito::findOrFail($inscrito_id);
        $trimestre_faltas = $inscritos->trimestre1_faltas;
        $trimestre_observaciones = $inscritos->trimestre1_observaciones;
        $grupos = Preescolar_grupo::findOrFail($inscritos->preescolar_grupo_id);
        $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
        $personaDocente = Persona::findOrFail($empleado->persona_id);

        $grupo = Preescolar_grupo::with('preescolar_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')
            ->findOrFail($inscritos->preescolar_grupo_id);
        $programas = $grupo->plan->programa;
        $perAnioPago = $grupo->periodo->perAnioPago;

        $fechaActual = Carbon::now();

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        $anioSiguiente = (int)$perAnioPago;
        $anioSiguiente = $anioSiguiente + 1;
        $cicloEscolar = "CICLO ". $perAnioPago . " – " . (string)$anioSiguiente;

        $kinderGradoTrimestre = "KINDER ". $gpoGrado . $gpoClave. " - Primer Reporte";
        $nombreAlumno = $persona->perNombre . " ". $persona->perApellido1 . " " . $persona->perApellido2;
        $nombreDocente = $personaDocente->perNombre . " ". $personaDocente->perApellido1 . " " . $personaDocente->perApellido2;

        $nombreArchivo = 'pdf_preescolar_primer_reporte_aprovechamiento';
        if ($programas->progClave == 'PRE')
        {
            $nombreArchivo = 'pdf_preescolar_primer_reporte_aprovechamiento';
            $kinderGradoTrimestre = "KINDER ". $gpoGrado . $gpoClave. " - Primer Reporte";
        }
        if ($programas->progClave == 'MAT')
        {
            $nombreArchivo = 'pdf_maternal_primer_reporte';
            $kinderGradoTrimestre = "MATERNAL ". $gpoGrado . $gpoClave. " - Primer Reporte";
        }

        $curso = Curso::find($inscritos->curso_id);
        $curPreescolarFoto = $curso->curPreescolarFoto;

        $ubicacion = $curso->cgt->plan->programa->escuela->departamento->ubicacion;
        $periodo = $curso->periodo;

        if($ubicacion->id == 1){
            $campus = "preescolarCME";
        }else{
            $campus = "preescolarCVA";
        }

        
        // view('alumnos_info.preescolar.pdf_preescolar_primer_reporte_aprovechamiento');
        $pdf = PDF::loadView('alumnos_info.preescolar.'. $nombreArchivo, [
            "calificaciones" => $calificaciones_collection,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cicloEscolar" => $cicloEscolar,
            "kinderGradoTrimestre" => $kinderGradoTrimestre,
            "nombreAlumno" => $nombreAlumno,
            "nombreDocente" => $nombreDocente,
            "trimestre_faltas" => $trimestre_faltas,
            "trimestre_observaciones" => $trimestre_observaciones,
            "nombreArchivo" => $nombreArchivo,
            "campus" => $campus,
            "perAnioPago" => $periodo->perAnioPago,
            "curPreescolarFoto" => $curPreescolarFoto
        ]);


        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($nombreArchivo . '.pdf');
        return $pdf->download($nombreArchivo  . '.pdf');

    }

    public function reporteSegundoTrimestre($inscrito_id, $personas_id, $gpoGrado, $gpoClave){

        $trimestre_a_evaluar = 2;

        $calificaciones_array = DB::table('preescolar_calificaciones')
            ->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id)
            ->where('preescolar_calificaciones.trimestre2',$trimestre_a_evaluar)
            ->where('preescolar_calificaciones.aplica','SI')
            ->orderBy('preescolar_calificaciones.rubrica_id','asc')
            ->get();

        $calificaciones_collection = collect( $calificaciones_array );

        $persona = Persona::findOrFail($personas_id);
        $inscritos = Preescolar_inscrito::findOrFail($inscrito_id);
        $trimestre_faltas = $inscritos->trimestre2_faltas;
        $trimestre_observaciones = $inscritos->trimestre2_observaciones;
        $grupos = Preescolar_grupo::findOrFail($inscritos->preescolar_grupo_id);
        $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
        $personaDocente = Persona::findOrFail($empleado->persona_id);

        $grupo = Preescolar_grupo::with('preescolar_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')
            ->findOrFail($inscritos->preescolar_grupo_id);
        $programas = $grupo->plan->programa;
        $perAnioPago = $grupo->periodo->perAnioPago;

        $fechaActual = Carbon::now();

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        $anioSiguiente = (int)$perAnioPago;
        $anioSiguiente = $anioSiguiente + 1;
        $cicloEscolar = "CICLO ". $perAnioPago . " – " . (string)$anioSiguiente;

        $kinderGradoTrimestre = "KINDER ". $gpoGrado . $gpoClave. " - Segundo Reporte";
        $nombreAlumno = $persona->perNombre . " ". $persona->perApellido1 . " " . $persona->perApellido2;
        $nombreDocente = $personaDocente->perNombre . " ". $personaDocente->perApellido1 . " " . $personaDocente->perApellido2;


        $nombreArchivo = 'pdf_preescolar_segundo_reporte_aprovechamiento';
        if ($programas->progClave == 'PRE')
        {
            $nombreArchivo = 'pdf_preescolar_segundo_reporte_aprovechamiento';
            $kinderGradoTrimestre = "KINDER ". $gpoGrado . $gpoClave. " - Segundo Reporte";
        }
        if ($programas->progClave == 'MAT')
        {
            $nombreArchivo = 'pdf_maternal_segundo_reporte';
            $kinderGradoTrimestre = "MATERNAL ". $gpoGrado . $gpoClave. " - Segundo Reporte";
        }

        $pdf = PDF::loadView('alumnos_info.preescolar.'. $nombreArchivo, [
            "calificaciones" => $calificaciones_collection,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cicloEscolar" => $cicloEscolar,
            "kinderGradoTrimestre" => $kinderGradoTrimestre,
            "nombreAlumno" => $nombreAlumno,
            "nombreDocente" => $nombreDocente,
            "trimestre_faltas" => $trimestre_faltas,
            "trimestre_observaciones" => $trimestre_observaciones,
            "nombreArchivo" => $nombreArchivo
        ]);


        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($nombreArchivo . '.pdf');
        return $pdf->download($nombreArchivo  . '.pdf');

    }

    public function reporteTercerTrimestre($inscrito_id, $personas_id, $gpoGrado, $gpoClave){

        $trimestre_a_evaluar = 3;

        $calificaciones_array = DB::table('preescolar_calificaciones')
            ->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id)
            ->where('preescolar_calificaciones.trimestre3',$trimestre_a_evaluar)
            ->where('preescolar_calificaciones.aplica','SI')
            ->orderBy('preescolar_calificaciones.rubrica_id','asc')
            ->get();

        $calificaciones_collection = collect( $calificaciones_array );

        $persona = Persona::findOrFail($personas_id);
        $inscritos = Preescolar_inscrito::findOrFail($inscrito_id);
        $trimestre_faltas = $inscritos->trimestre3_faltas;
        $trimestre_observaciones = $inscritos->trimestre3_observaciones;
        $grupos = Preescolar_grupo::findOrFail($inscritos->preescolar_grupo_id);
        $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
        $personaDocente = Persona::findOrFail($empleado->persona_id);

        $grupo = Preescolar_grupo::with('preescolar_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')
            ->findOrFail($inscritos->preescolar_grupo_id);
        $programas = $grupo->plan->programa;
        $perAnioPago = $grupo->periodo->perAnioPago;

        $fechaActual = Carbon::now();

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        $anioSiguiente = (int)$perAnioPago;
        $anioSiguiente = $anioSiguiente + 1;
        $cicloEscolar = "CICLO ". $perAnioPago . " – " . (string)$anioSiguiente;

        $kinderGradoTrimestre = "KINDER ". $gpoGrado . $gpoClave. " - Tercer Reporte";
        $nombreAlumno = $persona->perNombre . " ". $persona->perApellido1 . " " . $persona->perApellido2;
        $nombreDocente = $personaDocente->perNombre . " ". $personaDocente->perApellido1 . " " . $personaDocente->perApellido2;


        $nombreArchivo = 'pdf_preescolar_tercer_reporte_aprovechamiento';
        if ($programas->progClave == 'PRE')
        {
            $nombreArchivo = 'pdf_preescolar_tercer_reporte_aprovechamiento';
            $kinderGradoTrimestre = "KINDER ". $gpoGrado . $gpoClave. " - Tercer Reporte";
        }
        if ($programas->progClave == 'MAT')
        {
            $nombreArchivo = 'pdf_maternal_tercer_reporte';
            $kinderGradoTrimestre = "MATERNAL ". $gpoGrado . $gpoClave. " - Tercer Reporte";
        }

        $pdf = PDF::loadView('alumnos_info.preescolar.'. $nombreArchivo, [
            "calificaciones" => $calificaciones_collection,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cicloEscolar" => $cicloEscolar,
            "kinderGradoTrimestre" => $kinderGradoTrimestre,
            "nombreAlumno" => $nombreAlumno,
            "nombreDocente" => $nombreDocente,
            "trimestre_faltas" => $trimestre_faltas,
            "trimestre_observaciones" => $trimestre_observaciones,
            "nombreArchivo" => $nombreArchivo
        ]);


        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($nombreArchivo . '.pdf');
        return $pdf->download($nombreArchivo  . '.pdf');

    }

    public function destroy($id)
    {

    }


}
