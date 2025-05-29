<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cinemas')->insert([
            [
                'name' => 'Cine Central',
                'location' => 'Calle Mayor 1, Madrid',
                'description' => 'El cine más céntrico de la ciudad.',
                'city_id' => 1,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Gran Vía',
                'location' => 'Gran Vía 45, Madrid',
                'description' => 'Cine moderno en el corazón de Madrid.',
                'city_id' => 1,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Rambla',
                'location' => 'La Rambla 100, Barcelona',
                'description' => 'Cine emblemático de Barcelona.',
                'city_id' => 2,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Diagonal',
                'location' => 'Avenida Diagonal 200, Barcelona',
                'description' => 'Cine con las mejores salas de la ciudad.',
                'city_id' => 2,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Alameda',
                'location' => 'Avenida de la Constitución 15, Sevilla',
                'description' => 'Cine clásico en el centro de Sevilla.',
                'city_id' => 3,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Turia',
                'location' => 'Calle Turia 8, Valencia',
                'description' => 'Cine familiar en Valencia.',
                'city_id' => 4,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Nervión',
                'location' => 'Calle Nervión 12, Bilbao',
                'description' => 'Cine moderno en Bilbao.',
                'city_id' => 5,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Goya',
                'location' => 'Paseo Independencia 30, Zaragoza',
                'description' => 'Cine histórico de Zaragoza.',
                'city_id' => 6,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Atlántico',
                'location' => 'Avenida Atlántico 22, A Coruña',
                'description' => 'Cine con vistas al mar.',
                'city_id' => 7,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Puerto Venecia',
                'location' => 'Puerto Venecia, Zaragoza',
                'description' => 'Cine moderno en el centro comercial Puerto Venecia.',
                'city_id' => 6,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Gran Casa',
                'location' => 'Centro Comercial Gran Casa, Zaragoza',
                'description' => 'Cine en el centro comercial Gran Casa.',
                'city_id' => 6,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Goya',
                'location' => 'Paseo Independencia 30, Zaragoza',
                'description' => 'Cine histórico de Zaragoza.',
                'city_id' => 6,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],

        ]);
    }
}
