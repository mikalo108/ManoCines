<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemporalReserveTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('temporal_reserves')->insert([
            [
                'chair_id' => 1,
                'reserve_time' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
