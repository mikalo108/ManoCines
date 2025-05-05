<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cinemas')->insert([
            [
                'name' => 'Cine Central',
                'location' => 'Calle Mayor 1, Madrid',
                'description' => 'El cine más céntrico de la ciudad.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cine Plaza',
                'location' => 'Plaza Mayor 5, Barcelona',
                'description' => 'Cine con las mejores salas y sonido.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
