<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Client::first()) {
            $jsonFile = base_path('database/seeders/backup/clients.json');
            $jsonData = json_decode(File::get($jsonFile), true);
            Client::insert($jsonData);
        }
    }
}
