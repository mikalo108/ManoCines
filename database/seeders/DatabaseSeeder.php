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
        $this->call(UserTableSeeder::class); // 000000
        $this->call(ProfileTableSeeder::class); // 000020
        $this->call(CitiesTableSeeder::class); // 000030
        $this->call(CinemaTableSeeder::class); // 000040
        $this->call(RoomTableSeeder::class); // 000050
        $this->call(CinemaRoomTableSeeder::class); // 000060
        $this->call(ChairTableSeeder::class); // 000070
        $this->call(FilmTableSeeder::class); // 000080
        $this->call(TimeTableSeeder::class); // 000090
        $this->call(TemporalReserveTableSeeder::class); // 000100
        $this->call(ProductCategoryTableSeeder::class); // 000110
        $this->call(ProductTableSeeder::class); // 000120
        $this->call(ProductCinemasSeeder::class); // 000130
        $this->call(OrderTableSeeder::class); // 000140
        $this->call(OrderTicketTableSeeder::class); // 000150
        $this->call(OrderProductTableSeeder::class); // 000160
    }
}
