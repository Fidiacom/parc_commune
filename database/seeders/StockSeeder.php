<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Unitie;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $unities = Unitie::all();
        
        $stocks = [
            [
                'name' => 'Huile moteur 15W40',
                'min_stock_alert' => 20,
                'stock_actuel' => 45,
                'unitie_id' => 1, // Litre
            ],
            [
                'name' => 'Filtre à huile',
                'min_stock_alert' => 10,
                'stock_actuel' => 25,
                'unitie_id' => 3, // Pièce
            ],
            [
                'name' => 'Filtre à air',
                'min_stock_alert' => 8,
                'stock_actuel' => 15,
                'unitie_id' => 3, // Pièce
            ],
            [
                'name' => 'Liquide de frein',
                'min_stock_alert' => 5,
                'stock_actuel' => 12,
                'unitie_id' => 1, // Litre
            ],
            [
                'name' => 'Antigel',
                'min_stock_alert' => 10,
                'stock_actuel' => 8, // Below alert
                'unitie_id' => 1, // Litre
            ],
            [
                'name' => 'Pneu 265/70R16',
                'min_stock_alert' => 4,
                'stock_actuel' => 6,
                'unitie_id' => 3, // Pièce
            ],
            [
                'name' => 'Batterie 12V',
                'min_stock_alert' => 3,
                'stock_actuel' => 5,
                'unitie_id' => 3, // Pièce
            ],
        ];

        foreach ($stocks as $stock) {
            Stock::create($stock);
        }
    }
}
