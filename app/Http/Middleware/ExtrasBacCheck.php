<?php

namespace App\Http\Middleware;

use App\Models\Curso;
use App\Models\Portal_configuracion;
use Closure;
use Illuminate\Support\Facades\DB;

class ExtrasBacCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // con este Middleware validamos que no pueda ingresar por medio de la URL cuando
    // el modulo avace este desactivado 
    public function handle($request, Closure $next)
    {
        $results = DB::select(DB::raw("SELECT
        aluClave AS 'clave_pago',
        alumnos.id AS 'alumnos_id',
        alumnos.aluEstado,
        personas.id AS 'persona_id',
        cursos.id as 'cursos_id',
        cursos.curPlanPago,
        cursos.curEstado,
        ubicacion.ubiClave,
        departamentos.depClave,
        departamentos.perAnte,
        departamentos.perActual,
        departamentos.perSig,
        escClave as 'escuela',
        programas.progClave as 'carrera',
        cgt.cgtGradoSemestre as 'semestre',
        cgt.cgtGrupo as 'grupo',
        cgt.id as 'cgt_id',
        periodos.perNumero,
        periodos.perAnio,
        periodos.perAnioPago,
        periodos.id as 'periodo_id'
      FROM
        cursos
        INNER JOIN periodos ON cursos.periodo_id = periodos.id
        AND periodos.deleted_at IS NULL
        INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
        AND alumnos.deleted_at IS NULL
        INNER JOIN personas ON alumnos.persona_id = personas.id
        AND personas.deleted_at IS NULL
        INNER JOIN cgt ON cursos.cgt_id = cgt.id
        AND cgt.deleted_at IS NULL
        INNER JOIN planes ON cgt.plan_id = planes.id
        AND planes.deleted_at IS NULL
        INNER JOIN programas ON planes.programa_id = programas.id
        AND programas.deleted_at IS NULL
        INNER JOIN escuelas ON programas.escuela_id = escuelas.id
        AND escuelas.deleted_at IS NULL
        INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
        AND cursos.periodo_id = departamentos.perActual
        AND departamentos.deleted_at IS NULL
        INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
        AND ubicacion.deleted_at IS NULL
      WHERE
        cursos.deleted_at IS NULL
        AND aluClave = ". auth()->user()->username.
        " AND curEstado in ('R', 'A', 'C', 'P')
        AND periodos.id IN (
        SELECT
          perActual
        FROM
          departamentos
        WHERE
          depClave IN ('SUP', 'POS', 'PRE', 'MAT', 'PRI', 'SEC', 'BAC')
      );"));
      $cursos = collect($results)->first();
      $curso = Curso::with("alumno.persona", "periodo.departamento.ubicacion", "cgt.plan.programa")
               ->where("id", $cursos->cursos_id)->first();
      $ubicacion = $curso ? $curso->periodo->departamento->ubicacion : null;

      if($ubicacion->ubiClave == "CME"){

        $configAvanceBACCME = Portal_configuracion::Where('pcClave', 'VIEW_RECUPERATIVOS_CME')->first();
        $AVANCE_BAC_CME = $configAvanceBACCME->pcEstado == 'A' ? true: false;    
        

        if($AVANCE_BAC_CME){
            return $next($request);
        }else{
            alert()->info("Escuela Modelo", "Por el momento no se encuentra disponible esta opción")->showConfirmButton()->autoclose('5000');
            return redirect('libreta_de_pago');
        }
        
      }else{

        $configAvanceBACCVA = Portal_configuracion::Where('pcClave', 'VIEW_RECUPERATIVOS_CVA')->first();
        $AVANCE_BAC_CVA = $configAvanceBACCVA->pcEstado == 'A' ? true: false;

        if($AVANCE_BAC_CVA){
            return $next($request);
        }else{
            alert()->info("Escuela Modelo", "Por el momento no se encuentra disponible esta opción")->showConfirmButton()->autoclose('5000');
            return redirect('libreta_de_pago');
        }
      }

        
    }
}
