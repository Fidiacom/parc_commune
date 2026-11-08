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
        $categories = CategoriePermi::all();

        if ($categories->isEmpty()) {
            return;
        }

        // Licence categories per driver, matched by CIN (see DriverSeeder)
        $driverPermis = [
            'AB123456' => ['B', 'C'],      // Mohamed Alaoui
            'CD789012' => ['B'],           // Ahmed Bennani
            'EF345678' => ['B', 'C', 'D'], // Ali Seddiki (Principal)
            'GH901234' => ['B', 'C'],      // Youssef El Maghribi
            'IJ567890' => ['B'],           // Hassan Zahrani
        ];

        foreach ($driverPermis as $cin => $labels) {
            $driver = Driver::where('cin', $cin)->first();
            if (!$driver) {
                continue;
            }

            foreach ($labels as $label) {
                $category = $categories->firstWhere('label', $label);
                if (!$category) {
                    continue;
                }

                $pair = ['driver_id' => $driver->getId(), 'permi_id' => $category->getId()];
                if (!DB::table('driver_has_permis')->where($pair)->exists()) {
                    DB::table('driver_has_permis')->insert($pair + ['created_at' => now(), 'updated_at' => now()]);
                }
            }
        }
    }
}
