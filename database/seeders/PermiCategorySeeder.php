<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoriePermi;
class PermiCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $a = new CategoriePermi;
        $a->label = 'A';
        $a->save();


        $b = new CategoriePermi;
        $b->label = 'B';
        $b->save();


        $C = new CategoriePermi;
        $C->label = 'C';
        $C->save();

    }
}
