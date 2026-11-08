<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Create the default settings row. The login page and layouts need it to exist.
     * Commune names stay empty so the PDF_COMMUNE_* values from .env are used
     * until they are set on the "Paramètres" page.
     */
    public function run(): void
    {
        Setting::firstOrCreate([], [
            'logo' => null,
            'commune_name' => null,
            'commune_name_fr' => null,
            'commune_name_ar' => null,
            'main_color' => null,
            'second_color' => null,
        ]);
    }
}
