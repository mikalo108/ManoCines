<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('times')->insert([
            [
                'film_id' => 1,
                'room_id' => 1,
                'time' => now()->addDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'film_id' => 2,
                'room_id' => 2,
                'time' => now()->addDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
