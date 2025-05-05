<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderProductTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders_products')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'note' => 'Sin azúcar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'quantity' => 1,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
