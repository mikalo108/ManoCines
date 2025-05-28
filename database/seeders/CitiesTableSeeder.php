<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->insert([
            [
            'name' => 'Madrid',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Barcelona',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Valencia',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Sevilla',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Zaragoza',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Málaga',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Murcia',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Palma',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Las Palmas',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Bilbao',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Alicante',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Córdoba',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Valladolid',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Vigo',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Gijón',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'L\'Hospitalet de Llobregat',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'A Coruña',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Vitoria-Gasteiz',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Granada',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Elche',
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);
    }
}
