<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockHistorique;
use App\Models\Stock;
use App\Models\Vehicule;
use Carbon\Carbon;

class StockHistoriqueSeeder extends Seeder
{
    public function run(): void
    {
        $stocks = Stock::all();
        $vehicules = Vehicule::all();

        foreach ($stocks as $stock) {
            // Create some entries
            for ($i = 0; $i < rand(3, 8); $i++) {
                $type = rand(0, 1) ? 'entree' : 'sortie';
                $quantite = rand(1, 10);
                $vehiculeId = $type === 'sortie' && $vehicules->isNotEmpty() ? $vehicules->random()->getId() : null;
                
                StockHistorique::create([
                    'stock_id' => $stock->getId(),
                    'type' => $type,
                    'quantite' => $quantite,
                    'vehicule_id' => $vehiculeId,
                    'suppliername' => $type === 'entree' ? ['Total', 'Shell', 'BP', 'Agip'][rand(0, 3)] : null,
                    'created_at' => Carbon::now()->subDays(rand(1, 90)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 90)),
                ]);
            }
        }
    }
}
