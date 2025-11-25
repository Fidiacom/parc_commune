<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\CategoriePermi;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(0, 10) as $item) {
            $driver = new Driver();
            $driver->setAttribute(Driver::FULL_NAME_COLUMN, 'Driver ' . $item);
            $driver->setAttribute(Driver::CIN_COLUMN, 'XXXXXX' . $item);
            $driver->setAttribute(Driver::PHONE_COLUMN, '+212 600 00 00 0' . $item);
            $driver->save();
        }
    }
}
