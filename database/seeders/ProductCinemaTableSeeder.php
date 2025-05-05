<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCinemaTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products_cinema')->insert([
            [
                'product_id' => 1,
                'cinema_id' => 1,
                'quantity' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'cinema_id' => 2,
                'quantity' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
