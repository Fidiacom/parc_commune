<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vidange;
use App\Models\Vehicule;

class VidangeSeeder extends Seeder
{
    public function run(): void
    {
        $vehicules = Vehicule::all();

        foreach ($vehicules as $vehicule) {
            // Create vidange with threshold based on vehicle's current KM
            Vidange::firstOrCreate(
                ['car_id' => $vehicule->getId()],
                ['threshold_km' => $vehicule->getTotalKm() + rand(5000, 15000)]
            );
        }
    }
}
