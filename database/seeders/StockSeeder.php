<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Unitie;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $litre = Unitie::where('name', 'Litre')->value('id');
        $piece = Unitie::where('name', 'Pièce')->value('id');

        $stocks = [
            [
                'name' => 'Huile moteur 15W40',
                'min_stock_alert' => 20,
                'stock_actuel' => 45,
                'unitie_id' => $litre,
            ],
            [
                'name' => 'Filtre à huile',
                'min_stock_alert' => 10,
                'stock_actuel' => 25,
                'unitie_id' => $piece,
            ],
            [
                'name' => 'Filtre à air',
                'min_stock_alert' => 8,
                'stock_actuel' => 15,
                'unitie_id' => $piece,
            ],
            [
                'name' => 'Liquide de frein',
                'min_stock_alert' => 5,
                'stock_actuel' => 12,
                'unitie_id' => $litre,
            ],
            [
                'name' => 'Antigel',
                'min_stock_alert' => 10,
                'stock_actuel' => 8, // Below alert
                'unitie_id' => $litre,
            ],
            [
                'name' => 'Pneu 265/70R16',
                'min_stock_alert' => 4,
                'stock_actuel' => 6,
                'unitie_id' => $piece,
            ],
            [
                'name' => 'Batterie 12V',
                'min_stock_alert' => 3,
                'stock_actuel' => 5,
                'unitie_id' => $piece,
            ],
        ];

        foreach ($stocks as $stock) {
            Stock::firstOrCreate(['name' => $stock['name']], $stock);
        }
    }
}
