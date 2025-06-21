<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Car::first()) {
            $jsonFile = base_path('database/seeders/backup/cars.json');
            $jsonData = json_decode(File::get($jsonFile), true);
            Car::insert($jsonData);
        }
    }
}
