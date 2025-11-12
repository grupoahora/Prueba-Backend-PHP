<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Historiale;

class HistorialeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener IDs de inventarios existentes
        $inventarioIds = DB::table('inventarios')->pluck('id');

        // Simular transferencias entre bodegas
        // Asumiendo inventarios existentes: bodegas 1-5, productos 1-5

        // Transferencia de Bodega Central (1) a Bodega Norte (2): 20 unidades de producto 1
        Historiale::create([
            'cantidad' => 20,
            'id_bodega_origen' => 1,
            'id_bodega_destino' => 2,
            'id_inventario' => $inventarioIds->random(),
            'created_by' => null,
            'updated_by' => null,
        ]);

        // Transferencia de Bodega Norte (2) a Bodega Sur (3): 15 unidades de producto 2
        Historiale::create([
            'cantidad' => 15,
            'id_bodega_origen' => 2,
            'id_bodega_destino' => 3,
            'id_inventario' => $inventarioIds->random(),
            'created_by' => null,
            'updated_by' => null,
        ]);

        // Transferencia de Bodega Este (4) a Bodega Oeste (5): 30 unidades de producto 3
        Historiale::create([
            'cantidad' => 30,
            'id_bodega_origen' => 4,
            'id_bodega_destino' => 5,
            'id_inventario' => $inventarioIds->random(),
            'created_by' => null,
            'updated_by' => null,
        ]);

        // Entrada a Bodega Central (sin origen): 50 unidades de producto 4
        Historiale::create([
            'cantidad' => 50,
            'id_bodega_origen' => null,
            'id_bodega_destino' => 1,
            'id_inventario' => $inventarioIds->random(),
            'created_by' => null,
            'updated_by' => null,
        ]);

        // Salida de Bodega Sur (sin destino): 10 unidades de producto 5
        Historiale::create([
            'cantidad' => 10,
            'id_bodega_origen' => 3,
            'id_bodega_destino' => null,
            'id_inventario' => $inventarioIds->random(),
            'created_by' => null,
            'updated_by' => null,
        ]);

        // Otra transferencia: Bodega Oeste (5) a Bodega Central (1): 25 unidades de producto 1
        Historiale::create([
            'cantidad' => 25,
            'id_bodega_origen' => 5,
            'id_bodega_destino' => 1,
            'id_inventario' => $inventarioIds->random(),
            'created_by' => null,
            'updated_by' => null,
        ]);
    }
}