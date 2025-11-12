<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventario;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bodegas = [1, 2, 3, 4, 5];
        $productos = [1, 2, 3, 4, 5];

        foreach ($bodegas as $bodega) {
            
          
            foreach ($productos as $producto) {
                Inventario::create([
                    'id_bodega' => $bodega,
                    'id_producto' => $producto,
                    'cantidad' => rand(10, 100),
                    'created_by' => null,
                    'updated_by' => null,
                ]);
            }
        }
    }
}