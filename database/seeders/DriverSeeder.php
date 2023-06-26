<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\DriverHasPermi;
use App\Models\CategoriePermi;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach(range(0,10) as $item)
        {
            $driver = new Driver;

            $driver->full_name  =   'Driver '.$item;
            $driver->cin    =   'XXXXXX'.$item;
            $driver->phone  =   '+212 600 00 00 0'.$item;
            $driver->save();

            $hasPermis = new DriverHasPermi;
            $hasPermis->driver_id   =   $driver->id;
            $hasPermis->permi_id    =   CategoriePermi::where('label','=', 'B')->first()->id;
            $hasPermis->save();
        }
    }
}
