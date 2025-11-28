<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriePermi;

class CategoriePermiSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['label' => 'A'],
            ['label' => 'B'],
            ['label' => 'C'],
            ['label' => 'D'],
            ['label' => 'E'],
        ];

        foreach ($categories as $category) {
            CategoriePermi::create($category);
        }
    }
}
