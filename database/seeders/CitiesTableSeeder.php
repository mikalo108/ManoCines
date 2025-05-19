<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->insert([
            [
                'name' => 'Madrid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barcelona',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Valencia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
