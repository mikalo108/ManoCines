<?php

namespace Database\Seeders;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaTableSeeder extends Seeder
{
    public function run()
    {
        $cityIds = City::pluck('id', 'name')->toArray();

        DB::table('cinemas')->insert([
            [
                'name' => 'Cine Central',
                'location' => 'Calle Mayor 1, Madrid',
                'description' => 'El cine más céntrico de la ciudad.',
                'city_id' => $cityIds['Madrid'] ?? null,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Gran Vía',
                'location' => 'Gran Vía 45, Madrid',
                'description' => 'Cine moderno en el corazón de Madrid.',
                'city_id' => $cityIds['Madrid'] ?? null,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Diagonal',
                'location' => 'Avenida Diagonal 200, Barcelona',
                'description' => 'Cine con las mejores salas de la ciudad.',
                'city_id' => $cityIds['Barcelona'] ?? null,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Puerto Venecia',
                'location' => 'Puerto Venecia, Zaragoza',
                'description' => 'Cine moderno en el centro comercial Puerto Venecia.',
                'city_id' => $cityIds['Zaragoza'] ?? null,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Gran Casa',
                'location' => 'Centro Comercial Gran Casa, Zaragoza',
                'description' => 'Cine en el centro comercial Gran Casa.',
                'city_id' => $cityIds['Zaragoza'] ?? null,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cine Goya',
                'location' => 'Paseo Independencia 30, Zaragoza',
                'description' => 'Cine histórico de Zaragoza.',
                'city_id' => $cityIds['Zaragoza'] ?? null,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
