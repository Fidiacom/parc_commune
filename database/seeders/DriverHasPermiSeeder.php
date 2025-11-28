<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\CategoriePermi;
use Illuminate\Support\Facades\DB;

class DriverHasPermiSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = Driver::all();
        $categories = CategoriePermi::all();

        foreach ($drivers as $driver) {
            // Each driver gets 1-3 permit categories
            $numCategories = rand(1, 3);
            $selectedCategories = $categories->random($numCategories);
            
            foreach ($selectedCategories as $category) {
                DB::table('driver_has_permis')->insert([
                    'driver_id' => $driver->getId(),
                    'permi_id' => $category->getId(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
