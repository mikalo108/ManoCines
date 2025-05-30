<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCinemasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example seed data for cinemas_products pivot table
        $productCinemas = [
            ['cinema_id' => 1, 'product_id' => 1, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 2, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 3, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 4, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 5, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 6, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 7, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 8, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 9, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 10, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 11, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],

            ['cinema_id' => 2, 'product_id' => 1, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 2, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 3, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 3, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 4, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 5, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 6, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 7, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 8, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 9, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 10, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 1, 'product_id' => 11, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],

            ['cinema_id' => 2, 'product_id' => 1, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 2, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 3, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 4, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 5, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 6, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 7, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 8, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 9, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 10, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 2, 'product_id' => 11, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],

            ['cinema_id' => 3, 'product_id' => 1, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 2, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 3, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 4, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 5, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 6, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 7, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 8, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 9, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 10, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 3, 'product_id' => 11, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],

            ['cinema_id' => 4, 'product_id' => 1, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 2, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 3, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 4, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 5, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 6, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 7, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 8, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 9, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 10, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 4, 'product_id' => 11, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],

            ['cinema_id' => 5, 'product_id' => 1, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 2, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 3, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 4, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 5, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 6, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 7, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 8, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 9, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 10, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 5, 'product_id' => 11, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],

            ['cinema_id' => 6, 'product_id' => 1, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 2, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 3, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 4, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 5, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 6, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 7, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 8, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 9, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 10, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
            ['cinema_id' => 6, 'product_id' => 11, 'quantity' => 200, 'created_at'=>now()->format('Y-m-d H:i:s'), 'updated_at'=>now()->format('Y-m-d H:i:s'),],
        ];

        DB::table('product_cinemas')->insert($productCinemas);
    }
}
