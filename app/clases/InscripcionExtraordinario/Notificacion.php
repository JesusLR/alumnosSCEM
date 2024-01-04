<?php
namespace App\clases\InscripcionExtraordinario;

use Illuminate\Support\Collection;
use App\Models\Curso;
use App\clases\PortalAlumno\Mailer;
use Exception;
use DB;

class Notificacion
{
	protected $mail;
	protected $curso;
	protected $alumno;
	protected $persona;
	protected $cgt;
	protected $plan;
	protected $programa;
	protected $escuela;
	protected $departamento;
	protected $ubicacion;
	protected $periodo;

	public function __construct(Curso $curso)
	{
		$this->curso = $curso;
		$this->alumno = $this->curso->alumno;
		$this->persona = $this->alumno->persona;
		$this->cgt = $this->curso->cgt;
		$this->plan = $this->cgt->plan;
		$this->programa = $this->plan->programa;
		$this->escuela = $this->programa->escuela;
		$this->departamento = $this->escuela->departamento;
		$this->ubicacion = $this->departamento->ubicacion;
		$this->periodo = $this->curso->periodo;
	}

	/**
	* Recibe una Collection que almacena el resultado del procReprobadasAlumno()
	*
	* @param Illuminate\Support\Collection $reprobadas;
	*/
	public function reprobadasSinExtraordinario(Collection $reprobadas)
	{
		// antiguo 
		// 'username_email' => "extraordinarios@modelo.edu.mx",
		// 'password_email' =>  "qtXYJ9w3e8",


		// extraordinarios@unimodelo.com
		// Vox40316

		$this->mail = new Mailer([
			'username_email' => "extraordinarios@modelo.edu.mx",
			'password_email' =>  "qtXYJ9w3e8",
			'to_email' => 'luislara@modelo.edu.mx',
			'to_name' => '',
			'cc_email' => '',
			'subject' => 'Importante! Alumno ha solicitado extraordinarios que no se han agendado.',
			'body' => $this->armarMensajeReprobadasSinExtraordinario($reprobadas),
		]);

		// $this->mail->agregar_destinatario('jmanuel.lopez@modelo.edu.mx'); # TEST
		$this->mail->agregar_destinatario('eail@modelo.edu.mx');

		if($this->escuela->empleado && $this->escuela->empleado->empCorreo1) {
			$this->mail->agregar_destinatario($this->escuela->empleado->empCorreo1);
		}
		if($this->programa->empleado && $this->programa->empleado->empCorreo1) {
			$this->mail->agregar_destinatario($this->programa->empleado->empCorreo1);
		}

		$empleadosSeguimiento = $this->obtenerCorreosDeSeguimiento();
		if($empleadosSeguimiento->isNotEmpty()) {
		    $empleadosSeguimiento->each(function($empleado) {
		        $this->mail->agregar_destinatario($empleado->empCorreo1);
		    });
		}

		$this->mail->enviar();
	}

	/**
	* @param App\Models\Collection $reprobadas
	*/
	public function armarMensajeReprobadasSinExtraordinario(Collection $reprobadas)
	{
		$nombre_alumno = $this->persona->nombreCompleto();
		$materias_lista = "";
		foreach($reprobadas as $reprobada) {
			$urgente = $reprobada->maxSemestre - $reprobada->matSemestre > 1 ? "(urgente aprobar)" : "";
			$materias_lista .= "<li>{$reprobada->matClave} - {$reprobada->matNombre} {$urgente}</li>";
		}

		return "
		<h3><b>Alumno: </b> </h3>
		<p><b>Clave de pago: </b> {$this->alumno->aluClave}</p>
		<p><b>Alumno: </b> {$nombre_alumno}</p>
		<p><b>Campus: </b> {$this->ubicacion->ubiClave} - {$this->ubicacion->ubiNombre}</p>
		<p><b>Periodo y Año: </b> {$this->periodo->perNumero} / {$this->periodo->perAnio}</p>
		<p><b>Escuela: </b> {$this->escuela->escClave} - {$this->escuela->escNombre}</p>
		<p><b>Programa: </b> {$this->programa->progClave} ({$this->plan->planClave}) - {$this->programa->progNombre}</p>
		<p><b>Grupo: </b> {$this->cgt->cgtGradoSemestre} - {$this->cgt->cgtGrupo}</p>
		<br>
		<h3><b>Estas materias no tienen extraordinarios agendados </b> </h3>
		<ul>
		{$materias_lista}
		</ul>
		<br>
		<p>Favor de no responder a este correo automatizado.</p>
		";
	}

	private function obtenerCorreosDeSeguimiento() {
		return DB::table("empleadosseguimiento")
		    ->where("prog_id", "=", $this->programa->id)
		    ->where('modulo', 'EXTRAORDINARIOS')
			->get();
	}
}
