<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DriverHasPermi;
use App\Models\Driver;
use App\Models\CategoriePermi;

class DriverHasPermiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = Driver::all();
        $permisCategories = CategoriePermi::all();

        if ($drivers->isEmpty() || $permisCategories->isEmpty()) {
            $this->command->warn('No drivers or permis categories found. Please run DriverSeeder and PermiCategorySeeder first.');
            return;
        }

        // Assign random permits to drivers
        foreach ($drivers as $driver) {
            // Get a random permit category
            $randomPermi = $permisCategories->random();
            
            // Check if this association already exists
            $exists = DriverHasPermi::where(DriverHasPermi::DRIVER_ID_COLUMN, $driver->getId())
                ->where(DriverHasPermi::PERMI_ID_COLUMN, $randomPermi->getId())
                ->exists();

            if (!$exists) {
                $driverHasPermi = new DriverHasPermi();
                $driverHasPermi->setAttribute(DriverHasPermi::DRIVER_ID_COLUMN, $driver->getId());
                $driverHasPermi->setAttribute(DriverHasPermi::PERMI_ID_COLUMN, $randomPermi->getId());
                $driverHasPermi->save();
            }
        }
    }
}

