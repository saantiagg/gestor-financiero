<?php

namespace Database\Seeders;

use App\Models\Cuenta;
use Illuminate\Database\Seeder;

class CuentaSeeder extends Seeder
{
    public function run(): void
    {
        $cuentas = [
            ['nombre' => 'Bancolombia', 'descripcion' => 'Cuenta de ahorros principal', 'saldo' => 200000, 'moneda' => 'COP'],
            ['nombre' => 'Efectivo',    'descripcion' => 'Dinero en mano',              'saldo' => 50000,  'moneda' => 'COP'],
            ['nombre' => 'Nequi',       'descripcion' => 'Billetera digital',           'saldo' => 100000, 'moneda' => 'COP'],
        ];

        foreach ($cuentas as $cuenta) {
            Cuenta::create($cuenta);
        }
    }
}