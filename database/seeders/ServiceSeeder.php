<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Service::first()) {
            $jsonFile = base_path('database/seeders/backup/services.json');
            $jsonData = json_decode(File::get($jsonFile), true);
            Service::insert($jsonData);
        }
    }
}
