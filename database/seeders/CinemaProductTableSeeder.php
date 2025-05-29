<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaProductTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cinemas_products')->insert([
            [
                'product_id' => 1,
                'cinema_id' => 1,
                'quantity' => 50,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            [
                'product_id' => 2,
                'cinema_id' => 2,
                'quantity' => 30,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
