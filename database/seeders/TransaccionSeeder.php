<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Services\TransaccionService;
use Illuminate\Database\Seeder;

class TransaccionSeeder extends Seeder
{
    public function run(): void
    {
        $servicio = app(TransaccionService::class);

        $movimientos = [
            ['cuenta' => 'Bancolombia', 'categoria' => 'Salario',            'tipo' => 'ingreso', 'monto' => 150000, 'fecha' => '2026-11-02', 'descripcion' => 'Pago de nómina'],
            ['cuenta' => 'Efectivo',    'categoria' => 'Ventas',             'tipo' => 'ingreso', 'monto' => 80000,  'fecha' => '2026-11-05', 'descripcion' => 'Ventas de la semana'],
            ['cuenta' => 'Bancolombia', 'categoria' => 'Alimentación',       'tipo' => 'gasto',   'monto' => 20000,  'fecha' => '2026-11-08', 'descripcion' => 'Mercado'],
            ['cuenta' => 'Efectivo',    'categoria' => 'Transporte',         'tipo' => 'gasto',   'monto' => 15000,  'fecha' => '2026-11-10', 'descripcion' => 'Pasajes'],
            ['cuenta' => 'Nequi',       'categoria' => 'Servicios públicos', 'tipo' => 'gasto',   'monto' => 30000,  'fecha' => '2026-11-12', 'descripcion' => 'Internet'],
        ];

        foreach ($movimientos as $m) {
            $servicio->crear([
                'cuenta_id'    => Cuenta::where('nombre', $m['cuenta'])->value('id'),
                'categoria_id' => Categoria::where('nombre', $m['categoria'])->value('id'),
                'tipo'         => $m['tipo'],
                'monto'        => $m['monto'],
                'fecha'        => $m['fecha'],
                'descripcion'  => $m['descripcion'],
            ], 'Administrador');
        }
    }
}