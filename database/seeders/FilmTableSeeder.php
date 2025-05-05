<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('films')->insert([
            [
                'name' => 'Película 1',
                'image' => 'pelicula1.jpg',
                'overview' => 'Sinopsis de la película 1.',
                'trailer' => 'https://www.youtube.com/watch?v=trailer1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Película 2',
                'image' => 'pelicula2.jpg',
                'overview' => 'Sinopsis de la película 2.',
                'trailer' => 'https://www.youtube.com/watch?v=trailer2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
