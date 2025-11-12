<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bodega;

class BodegaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bodega::create([
            'nombre' => 'Bodega Central',
            'id_responsable' => 1,
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Bodega::create([
            'nombre' => 'Bodega Norte',
            'id_responsable' => 2,
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Bodega::create([
            'nombre' => 'Bodega Sur',
            'id_responsable' => 3,
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Bodega::create([
            'nombre' => 'Bodega Este',
            'id_responsable' => 4,
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Bodega::create([
            'nombre' => 'Bodega Oeste',
            'id_responsable' => 5,
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);
    }
}