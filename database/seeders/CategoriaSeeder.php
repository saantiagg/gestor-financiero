<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Salario',            'tipo' => 'ingreso', 'descripcion' => 'Pago mensual de nómina'],
            ['nombre' => 'Ventas',             'tipo' => 'ingreso', 'descripcion' => 'Ingresos por ventas del negocio'],
            ['nombre' => 'Alimentación',       'tipo' => 'gasto',   'descripcion' => 'Mercado y comidas'],
            ['nombre' => 'Transporte',         'tipo' => 'gasto',   'descripcion' => 'Bus, taxi y gasolina'],
            ['nombre' => 'Servicios públicos', 'tipo' => 'gasto',   'descripcion' => 'Agua, luz e internet'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}