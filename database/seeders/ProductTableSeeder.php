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
                'name' => 'Palomitas XXL Saladas',
                'description' => 'Cubo de palomitas de maíz tamaño XXL saladas',
                'image' => 'palomitas.webp',
                'price' => 15.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Palomitas XXL Caramelo',
                'description' => 'Cubo de palomitas de maíz tamaño XXL de sabor caramelo',
                'image' => 'palomitas.webp',
                'price' => 15.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Palomitas XXL Dulces',
                'description' => 'Cubo de palomitas de maíz tamaño XXL dulces',
                'image' => 'palomitas.webp',
                'price' => 15.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Palomitas L Saladas',
                'description' => 'Cubo de palomitas de maíz tamaño XXL saladas',
                'image' => 'palomitas.webp',
                'price' => 13.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Palomitas L Caramelo',
                'description' => 'Cubo de palomitas de maíz tamaño L de sabor caramelo',
                'image' => 'palomitas.webp',
                'price' => 13.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Palomitas L Dulces',
                'description' => 'Cubo de palomitas de maíz tamaño L dulces',
                'image' => 'palomitas.webp',
                'price' => 13.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Palomitas S Saladas',
                'description' => 'Cubo de palomitas de maíz tamaño S saladas',
                'image' => 'palomitas.webp',
                'price' => 12.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Palomitas S Caramelo',
                'description' => 'Cubo de palomitas de maíz tamaño S de sabor caramelo',
                'image' => 'palomitas.webp',
                'price' => 12.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Palomitas S Dulces',
                'description' => 'Cubo de palomitas de maíz tamaño S dulces',
                'image' => 'palomitas.webp',
                'price' => 12.99,
                'product_category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
