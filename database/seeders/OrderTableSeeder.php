<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'subtotal' => 20.00,
                'total' => 24.20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'subtotal' => 15.00,
                'total' => 18.15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
