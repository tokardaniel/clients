<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CarSeeder;
use Database\Seeders\ClientSeeder;
use Database\Seeders\ServiceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clientSeeder = new ClientSeeder();
        $carSeeder = new CarSeeder();
        $serviceSeeder = new ServiceSeeder();

        $clientSeeder->run();
        $carSeeder->run();
        $serviceSeeder->run();
    }
}
