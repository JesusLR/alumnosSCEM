<?php
namespace App\clases\periodos;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Periodo;

class MetodosPeriodos
{
    public static function buscarAnteriores($periodo,$perEstado = null){
        /*
        * Buscar periodos anteriores.
        * -> parámetro: Tipo de semestre (A,S,C,B.). (Opcional)
        */
        $perAnteriores = Periodo::where(function($query) use($periodo,$perEstado){
            $query->where('departamento_id','=',$periodo->departamento_id);
            if($perEstado != null){
                $query->where('perEstado','=',$perEstado);
            }
            $query->where('perFechaInicial','<',$periodo->perFechaInicial);
        })->latest('perFechaInicial');
            return $perAnteriores;
    }
}