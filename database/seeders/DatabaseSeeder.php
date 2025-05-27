<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        $this->call(ProfileTableSeeder::class);
        $this->call(CinemaTableSeeder::class);
        $this->call(FilmTableSeeder::class);
        $this->call(RoomTableSeeder::class);
        $this->call(ChairTableSeeder::class);
        $this->call(TemporalReserveTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(CinemaRoomTableSeeder::class);
        $this->call(TimeTableSeeder::class);
        $this->call(CinemasProductsSeeder::class);
        $this->call(CinemasProductsSeeder::class);
        $this->call(ProductCategoryTableSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(OrderTicketTableSeeder::class);
        $this->call(OrderProductTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(CinemaCityTableSeeder::class);
    }
}
