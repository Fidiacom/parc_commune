<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = [
            [
                'first_name_ar' => 'محمد',
                'first_name_fr' => 'Mohamed',
                'last_name_ar' => 'العلوي',
                'last_name_fr' => 'Alaoui',
                'role_ar' => 'سائق',
                'role_fr' => 'Chauffeur',
                'cin' => 'AB123456',
                'phone' => '0612345678',
            ],
            [
                'first_name_ar' => 'أحمد',
                'first_name_fr' => 'Ahmed',
                'last_name_ar' => 'بناني',
                'last_name_fr' => 'Bennani',
                'role_ar' => 'سائق',
                'role_fr' => 'Chauffeur',
                'cin' => 'CD789012',
                'phone' => '0623456789',
            ],
            [
                'first_name_ar' => 'علي',
                'first_name_fr' => 'Ali',
                'last_name_ar' => 'الصديقي',
                'last_name_fr' => 'Seddiki',
                'role_ar' => 'سائق رئيسي',
                'role_fr' => 'Chauffeur Principal',
                'cin' => 'EF345678',
                'phone' => '0634567890',
            ],
            [
                'first_name_ar' => 'يوسف',
                'first_name_fr' => 'Youssef',
                'last_name_ar' => 'المغربي',
                'last_name_fr' => 'El Maghribi',
                'role_ar' => 'سائق',
                'role_fr' => 'Chauffeur',
                'cin' => 'GH901234',
                'phone' => '0645678901',
            ],
            [
                'first_name_ar' => 'حسن',
                'first_name_fr' => 'Hassan',
                'last_name_ar' => 'الزهراني',
                'last_name_fr' => 'Zahrani',
                'role_ar' => 'سائق',
                'role_fr' => 'Chauffeur',
                'cin' => 'IJ567890',
                'phone' => '0656789012',
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}
