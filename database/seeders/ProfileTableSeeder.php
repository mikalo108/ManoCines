<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('profiles')->insert([
            [
                'user_id' => 1,
                'name' => 'Admin',
                'surname' => 'User',
                'country' => 'Spain',
                'city' => 'Madrid',
                'phone' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'name' => 'Regular',
                'surname' => 'User',
                'country' => 'Spain',
                'city' => 'Barcelona',
                'phone' => '987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
