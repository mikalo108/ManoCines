<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChairTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('chairs')->insert([
            ['row' => '1', 'column' => 'A', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'B', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'C', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'D', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'E', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'F', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'G', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'H', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'I', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'J', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'K', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'L', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'M', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'N', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'O', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'P', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'Q', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'R', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'S', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'T', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'U', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'V', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'W', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'X', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'Y', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'Z', 'state' => 'Available', 'price' => 10.00, 'room_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'A', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'B', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'C', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'D', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'E', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'F', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'G', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'H', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'I', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'J', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'K', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'L', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'M', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'N', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'O', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'P', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'Q', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'R', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'S', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'T', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'U', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'V', 'state' => 'Occupied', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'W', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'X', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'Y', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['row' => '1', 'column' => 'Z', 'state' => 'Available', 'price' => 10.00, 'room_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
}
}
