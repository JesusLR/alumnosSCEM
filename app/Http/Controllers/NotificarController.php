<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\PreinscritoExtraordinario_notificar;
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

use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\Cuota;
use App\Http\Models\ConceptoPago;
use App\Http\Models\Ficha;


use App\Http\Helpers\GenerarReferencia;
use App\Http\Helpers\Referencia;
use Codedge\Fpdf\Fpdf\Fpdf;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;


class NotificarController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
      // $this->middleware('permisos:pago',['except' => ['index','show','list']]);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return view('notificar.create');
  }


  public function enviar(Request $request)
  {

    $user = Auth::user();
    // dd($user);

    $userInfo = DB::select("call procAlumnoSeguimientoExtras('"
      . $user->username  . "','" . $user->password . "')");



    $validator = Validator::make($request->all(),
        [
            'image' => 'mimes:jpeg,jpg,png,pdf|file|max:10000',
            'reciboPago' => 'required',
            'email' => 'required',
            'celular' => 'required',
            'conceptoPago' => 'required|max:255',
        ],
        [
            'image.mimes' => "El archivo solo puede ser de tipo jpeg, jpg, png y pdf",
            'image.max'   => "El archivo no debe de pesar más de 10 Megas",

            'reciboPago.required'  => "El recibo de pago es requerido",
            'email.required' => "El correo electrónico es requerido",
            'celular.required' => "El celular es requerido",

            'conceptoPago.required' => "El concepto de pago es requerido",
            'conceptoPago.max' => "El concepto de pago tiene un límite de 255 dígitos",

        ]
    );

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }


    $to_name  = "";
    $to_email = "";
    $cc_name =  "";
    $cc_email = "";
    $bcc_name  = "";
    $bcc_email = "";

    if ($request->reciboPago == "COLEGIATURAS") {
        $to_email = "pago.transferencia@modelo.edu.m";
        $to_name  = "Coordinación Administrativa";

      //CORREO COLEGIATURAS
      // $username_email = "colegiaturas@modelo.edu.mx";
      // $password_email = "ZVB8z7DYKf";


      // colegiaturas@unimodelo.com
      // Tok47343
      

      $username_email = "colegiaturas@modelo.edu.mx";
      $password_email = "Nr5S9vj5yQ";

    }

    if ($request->reciboPago == "EXTRAORDINARIOS") {

      if (count($userInfo) > 0) {
            $to_name  = "Coordinador de Carrera";
            $to_email = $userInfo[0]->carrera_correo;
      }
      if (count($userInfo) > 1) {
          $cc_name =  "Coordinador de Carrera";
          $cc_email = $userInfo[1]->carrera_correo;
      }

      //CORREO EXTRAORDINARIOS
      // $username_email = "extraordinarios@modelo.edu.mx";
      // $password_email = "qtXYJ9w3e8";
      
      $username_email = "extraordinarios@unimodelo.com";
      $password_email = "Vox40316";
    }


    $elalumno = Alumno::where('aluClave', $user->username)->first();
    $persona = $elalumno->persona;
    $elnombre = $persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2;


    $mail = new PHPMailer(true);
    // Server settings
    $mail->CharSet = "UTF-8";
    $mail->Encoding = 'base64';

    $mail->SMTPDebug = 0;                            // Enable verbose debug output
    $mail->isSMTP();                                // Set mailer to use SMTP

    // viejo

    if ($request->reciboPago == "EXTRAORDINARIOS") {
      $mail->Host = 'mail.unimodelo.com';             // Specify main and backup SMTP servers
    }else{
      $mail->Host = 'smtp.office365.com';
    }
     
    
    $mail->SMTPAuth = true;                         // Enable SMTP authentication
    $mail->Username = $username_email; // SMTP username
    $mail->Password = $password_email;                   // SMTP password

    if ($request->reciboPago == "EXTRAORDINARIOS") {
      $mail->SMTPSecure = 'ssl';                      // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                        // TCP port to connect to
    }else{
      $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;        
    }
    
    
    $mail->setFrom($username_email, 'Universidad Modelo');





    $mail->addAddress($to_email, $to_name);

    if ($cc_email != "")
    {
        $mail->addCC($cc_email);
    }

    //dd($to_email, $cc_email, $cc_email != "", count($userInfo));
    if ($request->image) $mail->AddAttachment($request->image->getRealPath(),"recibo." . $request->image->getClientOriginalExtension());

    $mail->isHTML(true);                          // Set email format to HTML
    $mail->Subject = "Recibo de pago, Clave de Alumno: " . $user->username;


    $body = "
    <p>Recibo de pago: " . $request->reciboPago . "</p>
    <p>Clave pago alumno: " . $user->username . "</p>
    <p>Nombre del alumno: " . $elnombre . "</p>
    <p>Correo electrónico del alumno: " .$request->email  ."</p>
    <p>Teléfono del alumno: ".  $request->celular ."</p>
    <p>Referencia de ficha del pago: " . $request->conceptoPago . "</p>".
    "<p><b><i>Este es un correo automatizado, favor de no responder a esta cuenta de correo electrónico.</i></b></p>";

    $mail->Body  = $body;

      try {
          $enviado = $mail->send();
      } catch (MailerException $e) {
          alert()->error('Falló envío de Notificación', 'Es posible que su archivo adjunto sea mayor a 10 MB o existe algún problema con su conexión a internet. Verifique e intente nuevamente.')->showConfirmButton();
          return back()->withInput();
      }


    if ($enviado)
    {
        alert('Escuela Modelo', 'Muchas gracias, Se ha enviado la notificación de pago al correo: ' . $to_email .
            '. Es importante que realices el seguimiento de tu pago para que se aplique a la brevedad.', 'success')->showConfirmButton();

        try {
            $preinscrito_notificar = PreinscritoExtraordinario_notificar::create([
                'aluClave' => $user->username,
                'aluCorreo' => $request->email,
                'aluCelular' => $request->celular,
                'usuario_at' =>  1
            ]);

            return redirect()->back()->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }
    } else
        {
          alert('Escuela Modelo', 'hubo un error al enviar el correo. Favor de notificar o enviar más tarde', 'error')->showConfirmButton();
          return redirect()->back()->withInput();
    }
    
  }
}
