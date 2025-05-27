<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChairTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('chairs')->insert([
            [
                'row' => 'A',
                'column' => '1',
                'state' => 'available',
                'price' => 10.00,
                'room_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'row' => 'A',
                'column' => '2',
                'state' => 'available',
                'price' => 10.00,
                'room_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
