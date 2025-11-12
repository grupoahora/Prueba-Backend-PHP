<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            BodegaSeeder::class,
            ProductoSeeder::class,
            InventarioSeeder::class,
            HistorialeSeeder::class,
        ]);
    }
}
