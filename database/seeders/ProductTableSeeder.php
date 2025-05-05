<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Palomitas',
                'description' => 'Palomitas de maíz grandes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Refresco',
                'description' => 'Bebida refrescante',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
