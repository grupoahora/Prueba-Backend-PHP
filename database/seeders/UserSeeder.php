<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre' => 'Juan Pérez',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=Juan%20P%C3%A9rez&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'María García',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=Mar%C3%ADa%20Garc%C3%ADa&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'Carlos Rodríguez',
            'foto' => 'https://via.placeholder.com/150/00FF00/FFFFFF?text=Carlos+Rodriguez',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'Ana López',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=Ana%20L%C3%B3pez&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'Pedro Martínez',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=Pedro%20Mart%C3%ADnez&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'Laura Sánchez',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=Laura%20S%C3%A1nchez&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'Miguel Fernández',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=Miguel%20Fern%C3%A1ndez&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'Isabel Jiménez',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=Isabel%20Jim%C3%A9nez&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'David Moreno',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=David%20Moreno&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'nombre' => 'Elena Ruiz',
            'foto' => 'https://placehold.co/512x512/f0f0f0/0a54ff.webp?text=Elena%20Ruiz&font=lato',
            'estado' => 1,
            'created_by' => null,
            'updated_by' => null,
        ]);
    }
}