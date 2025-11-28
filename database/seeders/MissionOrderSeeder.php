<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MissionOrder;
use App\Models\Driver;
use App\Models\Vehicule;
use Carbon\Carbon;

class MissionOrderSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = Driver::all();
        $vehicules = Vehicule::all();

        if ($drivers->isEmpty() || $vehicules->isEmpty()) {
            return;
        }

        $missions = [
            [
                'mission_fr' => 'Livraison de marchandises à Casablanca',
                'mission_ar' => 'تسليم البضائع إلى الدار البيضاء',
                'place_togo_fr' => 'Casablanca',
                'place_togo_ar' => 'الدار البيضاء',
            ],
            [
                'mission_fr' => 'Transport de personnel vers Rabat',
                'mission_ar' => 'نقل الموظفين إلى الرباط',
                'place_togo_fr' => 'Rabat',
                'place_togo_ar' => 'الرباط',
            ],
            [
                'mission_fr' => 'Livraison urgente à Marrakech',
                'mission_ar' => 'تسليم عاجل إلى مراكش',
                'place_togo_fr' => 'Marrakech',
                'place_togo_ar' => 'مراكش',
            ],
            [
                'mission_fr' => 'Maintenance véhicule',
                'mission_ar' => 'صيانة المركبة',
                'place_togo_fr' => 'Garage',
                'place_togo_ar' => 'الكراج',
            ],
            [
                'mission_fr' => 'Réunion client à Tanger',
                'mission_ar' => 'اجتماع مع العميل في طنجة',
                'place_togo_fr' => 'Tanger',
                'place_togo_ar' => 'طنجة',
            ],
            [
                'mission_fr' => 'Collecte de documents',
                'mission_ar' => 'جمع الوثائق',
                'place_togo_fr' => 'Bureau',
                'place_togo_ar' => 'المكتب',
            ],
        ];

        // Create past missions
        for ($i = 0; $i < 30; $i++) {
            $mission = $missions[rand(0, count($missions) - 1)];
            $startDate = Carbon::now()->subDays(rand(1, 90));
            $endDate = $startDate->copy()->addHours(rand(2, 8));
            $doneAt = $endDate->copy()->addMinutes(rand(0, 30));
            
            MissionOrder::create([
                'driver_id' => $drivers->random()->getId(),
                'vehicule_id' => $vehicules->random()->getId(),
                'permanent' => rand(0, 1) === 0,
                'start' => $startDate->format('Y-m-d H:i:s'),
                'end' => $endDate->format('Y-m-d H:i:s'),
                'done_at' => $doneAt->format('Y-m-d H:i:s'),
                'mission_fr' => $mission['mission_fr'],
                'mission_ar' => $mission['mission_ar'],
                'registration_datetime' => $startDate->copy()->subHours(rand(1, 24))->format('Y-m-d H:i:s'),
                'place_togo_fr' => $mission['place_togo_fr'],
                'place_togo_ar' => $mission['place_togo_ar'],
            ]);
        }

        // Create some active/permanent missions
        for ($i = 0; $i < 5; $i++) {
            $mission = $missions[rand(0, count($missions) - 1)];
            $startDate = Carbon::now()->subDays(rand(1, 7));
            
            MissionOrder::create([
                'driver_id' => $drivers->random()->getId(),
                'vehicule_id' => $vehicules->random()->getId(),
                'permanent' => true,
                'start' => $startDate->format('Y-m-d H:i:s'),
                'end' => null,
                'done_at' => null,
                'mission_fr' => $mission['mission_fr'],
                'mission_ar' => $mission['mission_ar'],
                'registration_datetime' => $startDate->copy()->subHours(rand(1, 24))->format('Y-m-d H:i:s'),
                'place_togo_fr' => $mission['place_togo_fr'],
                'place_togo_ar' => $mission['place_togo_ar'],
            ]);
        }
    }
}
