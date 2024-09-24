<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        Car::insert([
            ['name_car' => 'Tesla Model S', 'dong_dien' => 'DC', 'cong_sac' => 'Type 2'],
            ['name_car' => 'Nissan Leaf', 'dong_dien' => 'DC', 'cong_sac' => 'CHAdeMO'],
            ['name_car' => 'BMW i3', 'dong_dien' => 'AC', 'cong_sac' => 'Type 2'],
            ['name_car' => 'Chevrolet Bolt', 'dong_dien' => 'DC', 'cong_sac' => 'CCS'],
            ['name_car' => 'Hyundai Kona Electric', 'dong_dien' => 'DC', 'cong_sac' => 'CCS'],
            ['name_car' => 'Audi e-tron', 'dong_dien' => 'AC', 'cong_sac' => 'Type 2'],
        ]);
    }
}

