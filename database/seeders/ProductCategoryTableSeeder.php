<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoryTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products_categories')->insert([
            [
                'name' => 'Pop Corns',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sweets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Drinks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
