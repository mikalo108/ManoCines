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
                'capacity' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
