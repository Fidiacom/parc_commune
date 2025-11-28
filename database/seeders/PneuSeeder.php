<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\pneu;
use App\Models\Vehicule;

class PneuSeeder extends Seeder
{
    public function run(): void
    {
        $vehicules = Vehicule::all();
        
        $tirePositions = ['Avant Gauche', 'Avant Droit', 'Arrière Gauche', 'Arrière Droit', 'Roue de secours'];

        foreach ($vehicules as $vehicule) {
            $numberOfTires = $vehicule->getNumberOfTires();
            
            for ($i = 0; $i < $numberOfTires; $i++) {
                $position = $tirePositions[$i] ?? "Position " . ($i + 1);
                $thresholdKm = $vehicule->getTotalKm() + rand(10000, 50000);
                
                pneu::create([
                    'car_id' => $vehicule->getId(),
                    'tire_position' => $position,
                    'threshold_km' => $thresholdKm,
                ]);
            }
        }
    }
}
