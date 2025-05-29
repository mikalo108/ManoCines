<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaRoomTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cinemas_rooms')->insert([
            [
                'cinema_id' => 1,
                'room_id' => 1,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'cinema_id' => 2,
                'room_id' => 2,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
