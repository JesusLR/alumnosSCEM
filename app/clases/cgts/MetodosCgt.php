<?php

namespace App\clases\cgts;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Http\Models\Cgt;
use App\Http\Models\Periodo;

class MetodosCgt
{
    public static function semestreALetras($grado,$case = null){
    	/*
    	* 1er. parámetro: cgtGradoSemestre.
    	* 2do. parámetro: case - estilo de escritura (opcional) 
    	*   -> Por defecto se utiliza uppercase.
    	*/
    	$r = null;
    	switch ($grado) {
    		case 1:
    			$r = 'PRIMER';
    			break;
    		case 2:
    			$r = 'SEGUNDO';
    			break;
    		case 3:
    			$r = 'TERCER';
    			break;
    		case 4:
    			$r = 'CUARTO';
    			break;
    		case 5:
    			$r = 'QUINTO';
    			break;
    		case 6:
    			$r = 'SEXTO';
    			break;
    		case 7:
    			$r = 'SÉPTIMO';
    			break;
    		case 8:
    			$r = 'OCTAVO';
    			break;
    		case 9:
    			$r = 'NOVENO';
    			break;
    		case 10:
    			$r = 'DÉCIMO';
    			break;
    		case 11:
    			$r = 'UNDÉCIMO';
    			break;
    		case 12:
    			$r = 'DÉCIMOSEGUNDO';
    			break;
    		default:
    			$r = 'INDEFINIDO';
    			break;
    	}

    	if($case != null){
    		if($case == 'ucfirst'){
    			ucfirst($r);
    		}elseif ($case == 'ucwords') {
    			ucwords($r);
    		}elseif($case == 'lowercase'){
    			strtolower($r);
    		}
    	}

    	return $r;

    }# semestreALetras.


    public static function cgt_siguiente($cgt) {
        $cgtGrado = $cgt->cgtGradoSemestre;
        $cgtGrupo = $cgt->cgtGrupo;
        $periodo = $cgt->periodo;
        $departamento = $periodo->departamento;
        $cgt_siguiente = null;

        $periodoSiguiente = Periodo::where('departamento_id', $departamento->id)
            ->where('perEstado', $periodo->perEstado)
            ->whereDate('perFechaInicial','>', $periodo->perFechaInicial)
            ->first();

        if(!$periodoSiguiente) {
            $periodoSiguiente = $departamento->periodoSiguiente;
        }

        $siguientesCgts = Cgt::where('plan_id', $cgt->plan_id)
            ->where('periodo_id', $periodoSiguiente->id)
            ->where('cgtGradoSemestre',$cgtGrado + 1)->get();
        if($siguientesCgts) {
            $cgt_siguiente = $siguientesCgts->where('cgtGrupo', $cgtGrupo)->first();
            if(!$cgt_siguiente) {
                $cgt_siguiente = $siguientesCgts->sortBy('cgtGrupo')->first();
            }
        }
        return $cgt_siguiente;
    } //cgt_siguiente.

}# Class