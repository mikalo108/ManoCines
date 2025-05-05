<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTicketTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders_tickets')->insert([
            [
                'order_id' => 1,
                'chair_id' => 1,
                'time_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'chair_id' => 2,
                'time_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
