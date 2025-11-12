<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            'nombre' => 'Laptop Dell Inspiron',
            'descripcion' => 'Laptop Dell Inspiron 15 con procesador Intel Core i5, 8GB RAM y 512GB SSD.',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Producto::create([
            'nombre' => 'Monitor Samsung 24"',
            'descripcion' => 'Monitor LED Samsung de 24 pulgadas con resolución Full HD y conectores HDMI.',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Producto::create([
            'nombre' => 'Teclado Mecánico Logitech',
            'descripcion' => 'Teclado mecánico Logitech MX Keys con retroiluminación y diseño ergonómico.',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Producto::create([
            'nombre' => 'Mouse Inalámbrico HP',
            'descripcion' => 'Mouse óptico inalámbrico HP con batería recargable y precisión de 1600 DPI.',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Producto::create([
            'nombre' => 'Impresora Multifunción Epson',
            'descripcion' => 'Impresora multifunción Epson EcoTank con impresión, escaneo y copia en color.',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);
    }
}