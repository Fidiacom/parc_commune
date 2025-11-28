<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimingChaine;
use App\Models\Vehicule;

class TimingChaineSeeder extends Seeder
{
    public function run(): void
    {
        $vehicules = Vehicule::all();

        foreach ($vehicules as $vehicule) {
            // Only create timing chaine for some vehicles (not all need it)
            if (rand(1, 3) <= 2) { // 66% chance
                $thresholdKm = $vehicule->getTotalKm() + rand(50000, 100000);
                
                TimingChaine::create([
                    'car_id' => $vehicule->getId(),
                    'threshold_km' => $thresholdKm,
                ]);
            }
        }
    }
}
