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

use App\Models\Grupo;
use App\Models\Curso;
use App\Models\Cgt;
use App\Models\Aula;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\Horario;
use App\Models\Periodo;
use App\Models\Programa;
use App\Models\Plan;
use App\Models\Materia;
use App\Models\Optativa;
use App\Models\Preescolar\Preescolar_calendario_calificaciones;
use App\Models\Preescolar_grupo;
use App\Models\Preescolar_inscrito;
use App\Models\Preescolar_materia;
use App\Models\Preescolar_calificacion;

class PreescolarGrupoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:preescolar_grupo', ['except' => ['index', 'list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*
        $aluClave = Auth::user()->username;
        $cursoID =  DB::select("call procPortalAlumnosInscritos("
            .$aluClave
            .")");

        $cursos = Curso::select('cursos.id as curso_id',
            'alumnos.aluClave', 'alumnos.id as alumno_id','personas.perNombre', 'personas.id as personas_id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('cursos.id',$cursoID[0]->id)
            ->get();

        dd($cursos[0]->personas_id);
        */

        /*
        $grupoID = DB::table('preescolar_inscritos')
            ->where('curso_id',$cursoID[0]->id)
            ->get();

        $grupo = Preescolar_grupo::with( 'preescolar_materia','periodo','plan.programa.escuela.departamento.ubicacion')
            ->select('preescolar_grupos.*')
            ->join('preescolar_inscritos', 'preescolar_grupos.id', '=', 'preescolar_inscritos.preescolar_grupo_id')
            ->where('preescolar_inscritos.curso_id',$cursoID[0]->id)
        ->get();

        dd($grupo);
        */


        return View('alumnos_info.preescolar.show-list-preescolar');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $aluClave = Auth::user()->username;
        $cursoID =  DB::select("call procPortalAlumnosInscritos("
            . $aluClave
            . ")");

        $grupo = Preescolar_grupo::with('preescolar_materia', 'periodo', 'plan.programa.escuela.departamento.ubicacion')
            ->select('preescolar_grupos.*', 'preescolar_inscritos.id as inscrito_id')
            ->join('preescolar_inscritos', 'preescolar_grupos.id', '=', 'preescolar_inscritos.preescolar_grupo_id')
            ->where('preescolar_inscritos.curso_id', $cursoID[0]->id);

        $cursos = Curso::select(
            'cursos.id as curso_id',
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'personas.perNombre',
            'personas.id as personas_id'
        )
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('cursos.id', $cursoID[0]->id)
            ->get();


        return Datatables::of($grupo)
            ->addColumn('action', function ($grupo) use ($cursos) {

                $fechaActual = Carbon::now();

                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');

                $preescolar_calendario_calificaciones = Preescolar_calendario_calificaciones::where('plan_id', $grupo->plan_id)
                    ->where('periodo_id', $grupo->periodo_id)
                    ->first();

                //PRIMER REPORTE

                if ($preescolar_calendario_calificaciones != "") {

                    //PRIMER REPORTE 
                    if ($preescolar_calendario_calificaciones->trimestre1_alumnos_publicacion <= $fechaActual->format('Y-m-d')) {
                        $acciones = '<div class="row">
                        <a href="calificaciones/primerreporte/' . $grupo->inscrito_id . '/' . $cursos[0]->personas_id . '/'
                            . $grupo->gpoGrado . '/' . $grupo->gpoClave . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="1er Trimestre" >
                            <i class="material-icons">picture_as_pdf</i>
                        </a>
                        </div>';
                    } else {
                        $acciones = "";
                    }


                    //SEGUNDO REPORTE   
                    if ($preescolar_calendario_calificaciones->trimestre2_alumnos_publicacion <= $fechaActual->format('Y-m-d')) {

                        $acciones = '<div class="row">
                        <a href="calificaciones/primerreporte/' . $grupo->inscrito_id . '/' . $cursos[0]->personas_id . '/'
                            . $grupo->gpoGrado . '/' . $grupo->gpoClave . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="1er Trimestre" >
                            <i class="material-icons">picture_as_pdf</i>
                        </a>
                        <a href="calificaciones/segundoreporte/' . $grupo->inscrito_id . '/' . $cursos[0]->personas_id . '/'
                            . $grupo->gpoGrado . '/' . $grupo->gpoClave . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="2do Trimestre" >
                            <i class="material-icons">picture_as_pdf</i>
                        </a>
                        </div>';
                    } 

                    //TERCER REPORTE
                    if ($preescolar_calendario_calificaciones->trimestre3_alumnos_publicacion <= $fechaActual->format('Y-m-d')) {

                        $acciones = '<div class="row">
                            <a href="calificaciones/primerreporte/' . $grupo->inscrito_id . '/' . $cursos[0]->personas_id . '/'
                            . $grupo->gpoGrado . '/' . $grupo->gpoClave . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="1er Trimestre" >
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            <a href="calificaciones/segundoreporte/' . $grupo->inscrito_id . '/' . $cursos[0]->personas_id . '/'
                            . $grupo->gpoGrado . '/' . $grupo->gpoClave . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="2do Trimestre" >
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            <a href="calificaciones/tercerreporte/' . $grupo->inscrito_id . '/' . $cursos[0]->personas_id . '/'
                            . $grupo->gpoGrado . '/' . $grupo->gpoClave . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="3er Trimestre" >
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </div>';
                    }
                    
                } else {
                    $acciones = "";
                }


                return $acciones;
            })
            ->make(true);
    }


    public function create()
    {
    }

    public function destroy($id)
    {
    }
}
