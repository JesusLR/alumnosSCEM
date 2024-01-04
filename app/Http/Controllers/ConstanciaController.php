<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pago;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Yajra\DataTables\Facades\DataTables;
use App\Models\Portal_configuracion;
use App\clases\PortalAlumno\Mailer;

class ConstanciaController extends Controller
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
    public function index()
    {
        return view('constancias.create');
    }

    public function solicitar(Request $request)
    {
        // alumnos@unimodelo.com
        // YYxow691
        try {
            $mail = new Mailer([
                'username_email' => "alumnoSCEM@modelo.edu.mx",
                'password_email' =>  "YYxow691",
                'to_email' => 'constancias@modelo.edu.mx', // 'iran.canul@modelo.edu.mx',
                'to_name' => '',
                'cc_email' => '',
                'subject' => 'Importante! Alumno ha solicitado constancia desde el portal alumnos.',
                'body' => $this->armarMensaje($request),
            ]);
    
            $mail->enviar();
        } catch(MailerException $e) {
            alert()->error('Falló envío de correo', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }

        alert(
            'Solicitud enviada', 
            'Estimado(a) alumno(a) a partir de 24 hrs. 
            de la solicitud, podrá pasar por su 
            constancia a la Dirección de Control 
            Escolar (Secretaría Administrativa)
            en el caso de que la constancia que 
            requiere no se encuentre en las opciones 
            o tiene alguna duda, mandar un correo 
            especificando el requerimiento a: 
            constancias@modelo.edu.mx 
            Dirección de Control Escolar 
            Tel.: 9999301900 ext. 1130-1134', 
            'success'
        )->showConfirmButton();
        return redirect('constancias');
    }

    public function armarMensaje($request)
	{
        $constancia = $request->tipo_constancia != 8 ? $request->tipo_constancia : $request->comentarios;
        $claveAlumno = (Auth::user()->username);
        $alumno = Alumno::where("aluClave", "=",$claveAlumno)->first();
        $persona = $alumno->persona;
        $nombreAlumno = $persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2;
		return "
		<h3><b>Alumno: </b> </h3>
		<p><b>Clave de pago: </b> {$claveAlumno}</p>
		<p><b>Alumno: </b> {$nombreAlumno}</p>
		<br>
		<h3><b>Alumno ha solicitado constancia de {$constancia} </b> </h3>
		<br>
		<p>Favor de no responder a este correo automatizado.</p>
		";
	}
}