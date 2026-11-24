<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:150'],
            'tipo' => ['required', 'in:ingreso,gasto'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 150 caracteres.',
            'tipo.required' => 'Debes seleccionar el tipo de categoría.',
            'tipo.in' => 'El tipo debe ser ingreso o gasto.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
        ];
    }
}