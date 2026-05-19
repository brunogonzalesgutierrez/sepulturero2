<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MantenimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'espacio_id'             => 'required|exists:espacios,id',
            'tipo_mantenimiento_id'  => 'required|exists:tipo_mantenimientos,id',
            'descripcion'            => 'required|string|max:500',
            'precio'                 => 'required|numeric|min:0',
            'estado'                 => 'required|in:pendiente,en_proceso,completado',
            'fecha_inicio'           => 'nullable|date',
            'fecha_fin'              => 'nullable|date|after_or_equal:fecha_inicio',
        ];
    }

    public function messages(): array
    {
        return [
            'espacio_id.required'            => 'Seleccione un espacio.',
            'tipo_mantenimiento_id.required' => 'Seleccione un tipo de mantenimiento.',
            'tipo_mantenimiento_id.exists'   => 'El tipo de mantenimiento seleccionado no existe.',
            'fecha_fin.after_or_equal'       => 'La fecha fin debe ser igual o posterior a la fecha inicio.',
        ];
    }
}