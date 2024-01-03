<?php

namespace App\Http\Controllers;

use URL;
use Illuminate\Support\Facades\Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\User;
//use App\Models\Alumno;
use App\Models\Departamento;
use App\Models\Curso;
use App\Http\Helpers\Utils;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Portal_configuracion;

class LoginController extends Controller
{

    public function index(){
        return view('auth.login');
    }

    /**
     * Esta funciona es creada para validar el usuario y contraseña.
     *
     * @param \Illuminate\Http\Request $request
     *
     */
    public function auth(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'required|string',
                'password' => 'required|string',
            ]
        );


        $configMantenimiento = Portal_configuracion::Where('pcClave', 'EN_MANTENIMIENTO')->first();
        $configPagos = Portal_configuracion::Where('pcClave', 'MODULO_PAGOS_ACTIVO')->first();
        $configPagosMATBAC = Portal_configuracion::Where('pcClave', 'MODULO_PAGOS_MAT_BAC_ACTIVO')->first();

        $configAcademicaMAT = Portal_configuracion::Where('pcClave', 'OPCIONES_ACADEMICAS_MAT')->first();
        $configAcademicaPRE = Portal_configuracion::Where('pcClave', 'OPCIONES_ACADEMICAS_PRE')->first();
        $configAcademicaPRI = Portal_configuracion::Where('pcClave', 'OPCIONES_ACADEMICAS_PRI')->first();
        $configAcademicaSEC = Portal_configuracion::Where('pcClave', 'OPCIONES_ACADEMICAS_SEC')->first();
        $configAcademicaBAC = Portal_configuracion::Where('pcClave', 'OPCIONES_ACADEMICAS_BAC')->first();

        $configBoletaBACCME = Portal_configuracion::Where('pcClave', 'BOLETA_BAC_MONTEJO')->first();
        $configBoletaBACCVA = Portal_configuracion::Where('pcClave', 'BOLETA_BAC_CVA')->first();

        $configAvanceBACCME = Portal_configuracion::Where('pcClave', 'AVANCE_BAC_CME')->first();
        $configAvanceBACCVA = Portal_configuracion::Where('pcClave', 'AVANCE_BAC_CVA')->first();

        $configHorarioBACCME = Portal_configuracion::Where('pcClave', 'VIEW_HORARIOS_CME')->first();
        $configHorarioBACCVA = Portal_configuracion::Where('pcClave', 'VIEW_HORARIOS_CVA')->first();

        
        $configExtraBACCME = Portal_configuracion::Where('pcClave', 'VIEW_RECUPERATIVOS_CME')->first();
        $configExtraBACCVA = Portal_configuracion::Where('pcClave', 'VIEW_RECUPERATIVOS_CVA')->first();

        $mantenimientoActivo = $configMantenimiento->pcEstado == 'A' ? true: false;
        $pagoActivo = $configPagos->pcEstado == 'A' ? true: false;

        $pagoActivoMATBAC = $configPagosMATBAC ->pcEstado == 'A' ? true: false;

        $academicaMAT = $configAcademicaMAT ->pcEstado == 'A' ? true: false;
        $academicaPRE = $configAcademicaPRE ->pcEstado == 'A' ? true: false;
        $academicaPRI = $configAcademicaPRI ->pcEstado == 'A' ? true: false;
        $academicaSEC = $configAcademicaSEC ->pcEstado == 'A' ? true: false;
        $academicaBAC = $configAcademicaBAC ->pcEstado == 'A' ? true: false;

        $boletaBACCME = $configBoletaBACCME ->pcEstado == 'A' ? true: false;
        $boletaBACCVA = $configBoletaBACCVA ->pcEstado == 'A' ? true: false;

        $avanceBACCME = $configAvanceBACCME ->pcEstado == 'A' ? true: false;
        $avanceBACCVA = $configAvanceBACCVA ->pcEstado == 'A' ? true: false;

        $horarioBACCME = $configHorarioBACCME ->pcEstado == 'A' ? true: false;
        $horarioBACCVA = $configHorarioBACCVA ->pcEstado == 'A' ? true: false;

        $extraBACCME = $configExtraBACCME ->pcEstado == 'A' ? true: false;
        $extraBACCVA = $configExtraBACCVA ->pcEstado == 'A' ? true: false;

        $EN_MANTENIMIENTO = $mantenimientoActivo;
        $MODULO_PAGOS_ACTIVO = $pagoActivo;

        $MODULO_PAGOS_MAT_BAC_ACTIVO = $pagoActivoMATBAC;
        $OPCIONES_ACADEMICAS_MAT = $academicaMAT;
        $OPCIONES_ACADEMICAS_PRE = $academicaPRE;
        $OPCIONES_ACADEMICAS_PRI = $academicaPRI;
        $OPCIONES_ACADEMICAS_SEC = $academicaSEC;
        $OPCIONES_ACADEMICAS_BAC = $academicaBAC;

        $BOLETA_BAC_MONTEJO = $boletaBACCME;
        $BOLETA_BAC_CVA = $boletaBACCVA;

        $AVANCE_BAC_CME = $avanceBACCME;
        $AVANCE_BAC_CVA = $avanceBACCVA;

        $VIEW_HORARIOS_CME = $horarioBACCME;
        $VIEW_HORARIOS_CVA = $horarioBACCVA;

        $VIEW_RECUPERATIVOS_CME = $extraBACCME;
        $VIEW_RECUPERATIVOS_CVA = $extraBACCVA;

        if($EN_MANTENIMIENTO)
        {
            alert()
                ->error('Escuela Modelo', 'Estamos en labores de mantenimiento. Para cualquier solicitud, favor de comunicarse a las oficinas de Escuela Modelo.')
                ->autoClose(15000);
            return redirect()->route('login')->withInput();
        }


        if ($user = User::where("username", "=", $request->username)->where("password", "=", $request->password)->where("restringido", "=", "0")->first()) {

            $procVerificaSiEsRegular = DB::select("call procPortalAlumnosInscritos(" . $request->username . ")");
            if ($procVerificaSiEsRegular)
            {
                $procActualizaSuDepClave = DB::select("call procPortalAlumnosActualizarUnInscrito(" . $request->username . ")");

                Auth::login($user);
                if(Auth::user()->depClave == "MAT")
                {
                    if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                    {
                        return redirect()->route('libretapago');
                    }
                    else
                    {
                        return redirect('alumno_pagos/' . Auth::user()->username);
                    }
                }
                if(Auth::user()->depClave == "PRE")
                {
                    if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                    {
                        return redirect()->route('libretapago');
                    }
                    else
                    {
                        return redirect('alumno_pagos/' . Auth::user()->username);
                    }
                }
                if(Auth::user()->depClave == "PRI")
                {
                    if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                    {
                        return redirect()->route('libretapago');
                    }
                    else
                    {
                        return redirect('alumno_pagos/' . Auth::user()->username);
                    }
                }

                if(Auth::user()->depClave == "SEC")
                {
                    if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                    {
                        return redirect()->route('libretapago');
                    }
                    else
                    {
                        return redirect('alumno_pagos/' . Auth::user()->username);
                    }
                }

                if(Auth::user()->depClave == "BAC")
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

                    if($MODULO_PAGOS_MAT_BAC_ACTIVO)
                    {
                        return redirect()->route('libretapago');
                    }
                    else
                    {
                        /*
                        if ($curso->curEstado == 'R') {
                            return redirect('bachiller_horario_alumno/');
                        } else {
                            alert()
                            ->error('Escuela Modelo', 'Importante: Pronto estará disponible la libreta de pago.')
                            ->autoClose(15000);
                            return redirect()->route('login')->withInput();
                        }
                        */
                        return redirect('alumno_pagos/' . Auth::user()->username);
                    }
                }

                if(Auth::user()->depClave == "SUP")
                {
                    /*
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $temporary_table_name = "__palum00_". substr(str_shuffle($permitted_chars), 0, 15);
                    $pagos = DB::select("call procDeudasAlumnoParaPagoDeEnero("
                        ."1"
                        .",".$request->username
                        .","."'I'"
                        .",'".$temporary_table_name."')");
                    $pago = DB::table($temporary_table_name)->where("cve_fila", "=", "TL$")->first();
                    DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );
                    if ((float) $pago->importe_adeudado > 0)
                    {
                        alert()
                            ->error('Universidad Modelo', 'Actualmente, presenta irregularidades en sus pagos de colegiaturas.
                                            Favor de comunicarse a la brevedad a los teléfonos 9999-301900 ext. 1151, ó a los correos
                                            flopezh@modelo.edu.mx y mcuevas@modelo.edu.mx')
                            ->autoClose(15000);
                        return redirect()->route('login')->withInput();
                    }
                    */

                    if($MODULO_PAGOS_ACTIVO)
                    {
                        return redirect()->route('libretapago');
                    }
                    else
                    {
                        return redirect('alumno_pagos/' . Auth::user()->username);
                    }

                }
                if(Auth::user()->depClave == "POS")
                {
                    if($MODULO_PAGOS_ACTIVO)
                    {
                        return redirect()->route('libretapago');
                    }
                    else
                    {
                        return redirect('alumno_pagos/' . Auth::user()->username);
                    }

                    //
                }

            }
            else
            {
                alert()
                    ->error('Escuela Modelo', 'Actualmente no se encuentra registrado como alumno inscrito del curso; por favor, regularízate. Solicita la ficha de inscripción en tu dirección ó coordinación correspondiente. 
                                            En caso de tener adeudo del curso anterior comunícate a el teléfono 9999 30 19 00 ext. 1151, ó al correo coordinacion.administrativa@modelo.edu.mx.

                                            Si eres egresado (a) y requieres algún documento de carácter académico, favor de dirigirse a la Dirección de Control Escolar (Secretaría Administrativa) 
                                            constancias@modelo.edu.mx
                                            Tel.: 9999 30 19 00 Ext. 1130-1134')
                    ->autoClose(15000);
                return redirect()->route('login')->withInput();
            }


            /*
            alert()
                 ->error('Universidad Modelo', 'Estimado Alumno(a): Por el momento estamos actualizando el portal para ofrecerte un mejor servicio.')
                 ->showConfirmButton()
                 ->autoClose(10000);
            return redirect()->route('login')->withInput();
            */
        }else
        {
            if (is_numeric($request->username)) {

                //SI USUARIO EXISTE
                if ($user = User::where("username", "=", $request->username)->first())
                {
                    alert()
                        ->error('Escuela Modelo', 'Usuario y/o contraseña inválidos')
                        ->showConfirmButton()
                        ->autoClose(5000);
                    return redirect()->route('login')->withInput();
                } else {
                    //SI ES ALUMNO REGULAR PERO AUN NO ES USUARIO
                    $procVerificaSiEsRegular = DB::select("call procPortalAlumnosInscritos(" . $request->username . ")");
                    if ($procVerificaSiEsRegular) {
                        //LO CREAMOS NUEVO
                        $procVerificaSiEsRegular = DB::select("call procPortalAlumnosAgregarInscritos()");
                        $procAgregaNuevos = DB::select("call procPortalAlumnosPlanPago()");

                        alert()
                            ->error('Escuela Modelo', 'Usuario y/o contraseña inválidos. Favor de intentarlo de nuevo.')
                            ->showConfirmButton()
                            ->autoClose(5000);
                        return redirect()->route('login')->withInput();
                    } else {
                        //SI ES UN ESTADO DE CURSO QUE NO SE USE EN EL SP (PUEDE SER QUE SE DESEE RESTRINGIR A LOS PREINSCRITOS)
                        $procVerificaSiEsPreinscrito = DB::select("call procPortalAlumnosPreinscritos(" . $request->username . ")");
                        if ($procVerificaSiEsPreinscrito) {
                            if ($procVerificaSiEsPreinscrito[0]->ubiClave != "CME") {
                                alert()
                                    ->error('Escuela Modelo', 'Actualmente no se encuentra registrado como alumno inscrito del curso;
                                            por favor, regularízate.
                                            Solicita la ficha de inscripción en tu dirección ó coordinación correspondiente.')
                                    ->autoClose(10000);
                                //return redirect()->away('http://modelo.edu.mx/');
                                return redirect()->route('login')->withInput();
                            } else {
                                alert()
                                    ->error('Escuela Modelo', 'Actualmente no se encuentra registrado como alumno inscrito del curso; por favor, regularízate. Solicita la ficha de inscripción en tu dirección ó coordinación correspondiente.
                                            En caso de tener adeudo del curso anterior comunícate a los teléfonos 9999 30 19 00 Ext. 1151, ó al correo coordinacion.administrativa@modelo.edu.mx.
                                            
                                            Si eres egresado (a) y requieres algún documento de carácter académico, favor de dirigirse a la Dirección de Control Escolar (Secretaría Administrativa) 
                                            constancias@modelo.edu.mx
                                            Tel.: 9999 30 19 00 Ext. 1130-1134')
                                    ->autoClose(15000);
                                //return redirect()->away('http://modelo.edu.mx/');
                                return redirect()->route('login')->withInput();
                            }

                        } else {
                            //SI NO EXISTE EL VATO, ES INTENTO DE HACKEO... MANDALO A VOLAR!!!!
                            alert()
                                ->error('Escuela Modelo', 'Usuario y/o contraseña inválidos')
                                ->showConfirmButton()
                                ->autoClose(5000);
                            return redirect()->route('login')->withInput();

                        }


                    }

                }
            }
            else{
                //SI NO EXISTE EL VATO, ES INTENTO DE HACKEO... MANDALO A VOLAR!!!!
                alert()
                    ->error('Escuela Modelo', 'Usuario y/o contraseña inválidos')
                    ->showConfirmButton()
                    ->autoClose(5000);
                return redirect()->route('login')->withInput();
            }
            /*
                        alert()
                        ->error('Ups...', 'Usuario y/o contraseña invalidos')
                        ->showConfirmButton()
                        ->autoClose(5000);
                        return redirect()->route('login')->withInput();
            */
        }

    }

    /**
     * Esta funcion es para salir y eliminar la sesion
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

}
