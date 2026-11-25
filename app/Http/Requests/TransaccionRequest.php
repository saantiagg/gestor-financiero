<?php

namespace App\Http\Requests;

use App\Models\Categoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TransaccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cuenta_id' => ['required', 'exists:cuentas,id'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'tipo' => ['required', 'in:ingreso,gasto'],
            'monto' => ['required', 'numeric', 'decimal:0,2', 'gt:0', 'max:999999999999999'],
            'fecha' => ['required', 'date'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }

    
    public function after(): array
    {
        return [
            function (Validator $validator) {
                
                if ($validator->errors()->has('tipo') || $validator->errors()->has('categoria_id')) {
                    return;
                }

                $categoria = Categoria::find($this->input('categoria_id'));

                if ($categoria && $categoria->tipo !== $this->input('tipo')) {
                    $validator->errors()->add(
                        'categoria_id',
                        "La categoría «{$categoria->nombre}» es de tipo {$categoria->tipo} y no se puede usar en un {$this->input('tipo')}."
                    );
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'cuenta_id.required' => 'Debes seleccionar una cuenta.',
            'cuenta_id.exists' => 'La cuenta seleccionada no existe.',
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'tipo.required' => 'Debes seleccionar el tipo de movimiento.',
            'tipo.in' => 'El tipo debe ser ingreso o gasto.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.decimal' => 'El monto admite máximo 2 decimales.',
            'monto.gt' => 'El monto debe ser mayor que cero.',
            'monto.max' => 'El monto es demasiado grande.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
        ];
    }
}