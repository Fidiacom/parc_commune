<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unitie;

class UnitieSeeder extends Seeder
{
    public function run(): void
    {
        $unities = [
            ['name' => 'Litre'],
            ['name' => 'Kilogramme'],
            ['name' => 'Pièce'],
            ['name' => 'Mètre'],
            ['name' => 'Boîte'],
        ];

        foreach ($unities as $unity) {
            Unitie::create($unity);
        }
    }
}
