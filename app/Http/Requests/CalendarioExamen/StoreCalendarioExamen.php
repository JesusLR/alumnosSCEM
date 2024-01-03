<?php

namespace App\Http\Requests\CalendarioExamen;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalendarioExamen extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            //
            'ubicacion_id' => 'required',
            'departamento_id' => 'required',
            'periodo_id' => 'required|unique:calendarioexamen,periodo_id',
            'calexInicioParcial1' => 'nullable|date|required_with:calexFinParcial1|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexInicioParcial2' => 'nullable|date|required_with:calexFinParcial2|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexInicioParcial3' => 'nullable|date|required_with:calexFinParcial3|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexInicioOrdinario' => 'nullable|date|required_with:calexFinOrdinario|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinParcial1' => 'nullable|date|after:calexInicioParcial1|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinParcial2' => 'nullable|date|after:calexInicioParcial2|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinParcial3' => 'nullable|date|after:calexInicioParcial3|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal',
            'calexFinOrdinario' => 'nullable|date|after:calexInicioOrdinario|after_or_equal:perFechaInicial|before_or_equal:perFechaFinal'
        ];
    }

    public function messages() {

        return [
            'ubicacion_id.required' => 'Se requiere especificar una ubicación.',
            'departamento_id.required' => 'Se requiere especificar un departamento.',
            'periodo_id.required' => 'Se requiere especificar un periodo.',
            'periodo_id.unique' => 'Ya existe un calendario para este periodo.',
            'calexInicioParcial1.required_with' => '1er Parcial. Si ingresa fecha final, debe especificar fecha inicial.',
            'calexInicioParcial2.required_with' => '2do Parcial. Si ingresa fecha final, debe especificar fecha inicial.',
            'calexInicioParcial3.required_with' => '3er Parcial. Si ingresa fecha final, debe especificar fecha inicial.',
            'calexInicioOrdinario.required_with' => 'Ordinario. Si ingresa Fin ordinario, debe especificar Inicio ordinario.',
            'calexFinParcial1.after' => '1er Parcial, fecha final debe ser posterior a fecha inicial.',
            'calexFinParcial2.after' => '2do Parcial, fecha final debe ser posterior a fecha inicial.',
            'calexFinParcial3.after' => '3er Parcial, fecha final debe ser posterior a fecha inicial.',
            'calexFinOrdinario.after' => 'Ordinario, fecha final debe ser posterior a fecha inicial.',
            'calexInicioParcial1.afteroOreEqual' => '1er Parcial. La fecha inicial debe ser igual o posterior de la fecha de Inicio del Periodo.',
            'calexInicioParcial2.after_or_equal' => '2do Parcial. La fecha inicial debe ser igual o posterior de la fecha de Inicio del Periodo.',
            'calexInicioParcial3.after_or_equal' => '3er Parcial. La fecha inicial debe ser igual o posterior de la fecha de Inicio del Periodo.',
            'calexInicioOrdinario.after_or_equal' => 'Ordinario. La fecha inicial debe ser igual o posterior de la fecha de Inicio del Periodo.',
            'calexFinParcial1.before_or_equal' => '1er Parcial. La fecha final no debe ser posterior a la fecha final del Periodo.',
            'calexFinParcial2.before_or_equal' => '2do Parcial. La fecha final no debe ser posterior a la fecha final del Periodo.',
            'calexFinParcial3.before_or_equal' => '3er Parcial. La fecha final no debe ser posterior a la fecha final del Periodo.',
            'calexFinOrdinario.before_or_equal' => 'Ordinario. La fecha final no debe ser posterior a la fecha final del Periodo.'
        ];
    }

}
