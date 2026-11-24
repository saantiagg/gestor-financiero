<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuenta extends Model
{
    protected $table = 'cuentas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'saldo',
        'moneda',
    ];

    protected function casts(): array
    {
        return [
            'saldo' => 'decimal:2',
        ];
    }

    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class);
    }
}   