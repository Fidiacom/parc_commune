<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class, // Only admin
            CategoriePermiSeeder::class,
            VehiculeSeeder::class, // 18 vehicles from the document
            DriverSeeder::class, // 5 drivers
            DriverHasPermiSeeder::class, // Assign permis to drivers
        ]);
    }
}
