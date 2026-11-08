<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Safe to run several times: existing rows are kept, nothing is duplicated.
     */
    public function run(): void
    {
        // Base data, always needed
        $this->call([
            RoleSeeder::class,
            UserSeeder::class, // Only admin
            SettingSeeder::class, // Default settings row (needed by login page)
            CategoriePermiSeeder::class,
            UnitieSeeder::class,
        ]);

        // Demo data: run with SEED_DEMO=true (e.g. `SEED_DEMO=true php artisan db:seed`)
        if (config('app.seed_demo')) {
            $this->call([
                VehiculeSeeder::class, // 18 vehicles from the document
                DriverSeeder::class, // 5 drivers
                DriverHasPermiSeeder::class, // Assign permis to drivers
                VidangeSeeder::class,
                PneuSeeder::class,
                TimingChaineSeeder::class,
                StockSeeder::class,
                StockHistoriqueSeeder::class,
                MissionOrderSeeder::class,
                PaymentVoucherSeeder::class,
            ]);
        }
    }
}
