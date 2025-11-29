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

        if ($drivers->isEmpty() || $categories->isEmpty()) {
            return;
        }

        // Assign permis categories to drivers
        // Driver 1: B, C
        // Driver 2: B
        // Driver 3: B, C, D (Principal driver)
        // Driver 4: B, C
        // Driver 5: B
        
        $driverPermis = [
            1 => ['B', 'C'],  // Mohamed Alaoui
            2 => ['B'],       // Ahmed Bennani
            3 => ['B', 'C', 'D'], // Ali Seddiki (Principal)
            4 => ['B', 'C'],  // Youssef El Maghribi
            5 => ['B'],       // Hassan Zahrani
        ];

        foreach ($drivers as $index => $driver) {
            $driverIndex = $index + 1;
            if (isset($driverPermis[$driverIndex])) {
                foreach ($driverPermis[$driverIndex] as $permisLabel) {
                    $category = $categories->firstWhere('label', $permisLabel);
                    if ($category) {
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
    }
}
