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
            UserSeeder::class,
            CategoriePermiSeeder::class,
            UnitieSeeder::class,
            VehiculeSeeder::class,
            PneuSeeder::class,
            VidangeSeeder::class,
            TimingChaineSeeder::class,
            DriverSeeder::class,
            DriverHasPermiSeeder::class,
            StockSeeder::class,
            StockHistoriqueSeeder::class,
            PaymentVoucherSeeder::class,
            MissionOrderSeeder::class,
        ]);
    }
}

