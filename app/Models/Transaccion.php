<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaccion extends Model
{
    protected $table = 'transacciones';

    protected $fillable = [
        'cuenta_id',
        'categoria_id',
        'tipo',
        'monto',
        'fecha',
        'descripcion',
        'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'fecha' => 'date',
        ];
    }

    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}