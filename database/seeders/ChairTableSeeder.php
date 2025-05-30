<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChairTableSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('chairs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rooms = DB::table('rooms')->pluck('id');

        $columns = range('A', 'J');
        $rows = range(1, 9);

        $chairs = [];

        foreach ($rooms as $room_id) {
            foreach ($rows as $row) {
                foreach ($columns as $column) {
                    $chairs[] = array(
                        'row' => (string)$row,
                        'column' => $column,
                        'state' => 'Available',
                        'price' => 10.00,
                        'room_id' => $room_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    );
                }
            }
        }

        DB::table('chairs')->insert($chairs);
    }
}
