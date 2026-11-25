<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $reglas = [
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'moneda' => ['required', 'in:COP,USD,EUR'],
        ];

        // El saldo solo se define al crear la cuenta (saldo inicial).
        if ($this->isMethod('POST')) {
            $reglas['saldo'] = ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999999999999999'];
        }

        return $reglas;
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 150 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
            'moneda.required' => 'Debes seleccionar la moneda.',
            'moneda.in' => 'La moneda debe ser COP, USD o EUR.',
            'saldo.required' => 'El saldo inicial es obligatorio.',
            'saldo.numeric' => 'El saldo debe ser un número.',
            'saldo.decimal' => 'El saldo admite máximo 2 decimales.',
            'saldo.min' => 'El saldo no puede ser negativo.',
            'saldo.max' => 'El saldo es demasiado grande.',
        ];
    }
}