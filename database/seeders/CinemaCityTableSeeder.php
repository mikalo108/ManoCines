<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaCityTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cinema_city')->insert([
            [
                'city_id' => 1, // Madrid
                'cinema_id' => 1, // Cine Central
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'city_id' => 2, // Barcelona
                'cinema_id' => 2, // Cine Plaza
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'city_id' => 3, // Valencia
                'cinema_id' => 1, // Cine Central
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
