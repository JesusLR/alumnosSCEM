<?php
namespace App\clases\alumnos;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Alumno;
use App\Http\Models\TutorAlumno;

class MetodosAlumnos
{

    /*  
    * Retorna apellidos con y sin tildes (de requerirse)
    * parámetro : Instancia de App\Persona.
    */
    public static function filtrarApellidos ($persona) {
        $conTilde = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'];
        $sinTilde = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];

        $apellido1 = $persona->perApellido1;
        $apellido2 = $persona->perApellido2;

        $nombre1 = str_replace($conTilde, $sinTilde, $apellido1.' '.$apellido2);
        $nombre2 = $apellido1.' '.$apellido2;
        $nombre3 = str_replace($conTilde, $sinTilde, $apellido1).' '.$apellido2;
        $nombre4 = $apellido1.' '.str_replace($conTilde, $sinTilde, $apellido2);

        /* Ejemplo: López Velázquez.
        * -> arr[0] = Lopez Velazquez
        * -> arr[1] = López Velázquez <---- Sin Modificación.
        * -> arr[2] = López Velazquez
        * -> arr[3] = Lopez Velázquez
        */

        $collect = collect([$nombre1, $nombre2, $nombre3, $nombre4]);

        return $collect;
    }//filtrarApellidos.




    /*
    * el parametro debe ser array.
    *
    * Esta función se hizo para trabajar en conjunto con filtrarApellidos().
    */
    public static function posiblesHermanos ($apellidos) {

        $hermanos = Alumno::with('persona')
        ->whereHas('persona', static function ($query) use ($apellidos) {
          $sql = DB::raw("CONCAT(perApellido1,' ',perApellido2)");

            $query->whereIn($sql, $apellidos);

        }); // ->get();
        
        return $hermanos;
    }//posiblesHermanos.


    /*
    * Vincula cada uno de los alumnos al tutor.
    *
    * @param Model Alumno.
    * @param Model Tutor(collection).
    */
    public static function vincularTutores($tutores = null,$alumno) {

        if($tutores) {
            $alumno->tutores()->whereNotIn('tutor_id', $tutores->pluck('id'))->delete();
            
            $tutores->each(function ($item, $key) use ($alumno, $tutores) { 
                $tutorAlumno = $item->alumnos()->where('alumno_id', $alumno->id)->first();
                if(!$tutorAlumno){
                    $tutorAlumno = TutorAlumno::create([
                        'alumno_id' => $alumno->id,
                        'tutor_id' => $item->id
                    ]);
                }
            });
        }
    }//vincularTutores.



}