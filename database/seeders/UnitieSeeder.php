<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unitie;


class UnitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unity = new Unitie;
        $unity->name = 'kg';
        $unity->save();


        $unity1 = new Unitie;
        $unity1->name = 'L';
        $unity1->save();


        $unity2 = new Unitie;
        $unity2->name = 'M';
        $unity2->save();

        $unity3 = new Unitie;
        $unity3->name = 'pcs';
        $unity3->save();


    }
}
