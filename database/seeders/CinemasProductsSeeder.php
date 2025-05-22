<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemasProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example seed data for cinemas_products pivot table
        $cinemasProducts = [
            ['cinema_id' => 1, 'product_id' => 1],
            ['cinema_id' => 1, 'product_id' => 2],
            ['cinema_id' => 2, 'product_id' => 1],
            ['cinema_id' => 2, 'product_id' => 3],
        ];

        DB::table('cinemas_products')->insert($cinemasProducts);
    }
}
