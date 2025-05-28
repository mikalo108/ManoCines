<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'number' => 1,
                'capacity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 2,
                'capacity' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 3,
                'capacity' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 4,
                'capacity' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 5,
                'capacity' => 110,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 6,
                'capacity' => 95,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 7,
                'capacity' => 130,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 8,
                'capacity' => 85,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 9,
                'capacity' => 105,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 10,
                'capacity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 11,
                'capacity' => 115,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 12,
                'capacity' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 13,
                'capacity' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 14,
                'capacity' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'number' => 15,
                'capacity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
