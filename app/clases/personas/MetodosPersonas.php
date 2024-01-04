<?php
namespace App\clases\personas;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\Alumno;
use App\Models\Empleado;

class MetodosPersonas
{

    public static function existeAlumno($request) {
        $alumno = Alumno::with('persona')
        ->whereHas('persona', static function ($query) use ($request) {
            if($request->perNombre) {
                $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
            }
            if($request->perApellido1) {
                $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
            }
            if($request->perApellido2) {
                $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
            }
            if($request->perCurp) {
                $query->where('perCurp', $request->perCurp);
            }
        })->first();

        return $alumno;
    }//existeAlumno.

    public static function existeEmpleado($request) {
        $empleado = Empleado::with('persona')
        ->whereHas('persona', static function ($query) use ($request) {
            if($request->perNombre) {
                $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
            }
            if($request->perApellido1) {
                $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
            }
            if($request->perApellido2) {
                $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
            }
            if($request->perCurp) {
                $query->where('perCurp', $request->perCurp);
            }
        })->first();

        return $empleado;
    }//existeEmpleado.

    public static function nombreCompleto($persona, $invertido = false) {
        $nombre = $persona->perNombre;
        $apellidos = $persona->perApellido1.' '.$persona->perApellido2;
        return $invertido ? $apellidos.' '.$nombre : $nombre.' '.$apellidos;
    }//nombreCompleto.

    



}//MetodosPersonas.