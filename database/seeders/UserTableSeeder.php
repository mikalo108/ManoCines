<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@manocines.com',
                'password' => Hash::make('admin'),
                'role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@manocines.com',
                'password' => Hash::make('password'),
                'role' => 'Client',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'miguel@manocines.com',
                'password' => Hash::make('miguel'),
                'role' => 'Client',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
