<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentVoucher;
use App\Models\Vehicule;
use App\Models\pneu;
use App\Models\Vidange;
use App\Models\TimingChaine;
use Carbon\Carbon;

class PaymentVoucherSeeder extends Seeder
{
    public function run(): void
    {
        $vehicules = Vehicule::all();
        $voucherNumber = 1000;

        foreach ($vehicules as $vehicule) {
            $currentKm = $vehicule->getTotalKm() - rand(50000, 100000); // Start from lower KM
            $currentHours = $vehicule->getTotalHours() ? ($vehicule->getTotalHours() - rand(500, 2000)) : null;
            $startDate = Carbon::now()->subMonths(12);
            
            // Create fuel vouchers for consumption tracking
            // For some vehicles, create higher consumption to test alerts
            $isHighConsumption = rand(1, 3) === 1; // 33% chance of high consumption vehicle
            
            for ($i = 0; $i < rand(8, 15); $i++) {
                $kmIncrement = rand(500, 2000);
                $currentKm += $kmIncrement;
                if ($currentHours !== null) {
                    $currentHours += rand(10, 50);
                }
                
                $invoiceDate = $startDate->copy()->addDays($i * rand(15, 30));
                
                // Calculate fuel based on consumption
                if ($isHighConsumption && $vehicule->getMaxFuelConsumption100km()) {
                    // Create high consumption (exceeding max)
                    $consumptionRate = $vehicule->getMaxFuelConsumption100km() + rand(2, 5); // Exceed by 2-5 L/100km
                    $fuelLiters = ($kmIncrement / 100) * $consumptionRate;
                } else {
                    // Normal consumption
                    $fuelLiters = rand(30, 80);
                }
                
                $pricePerLiter = rand(1100, 1400) / 100; // 11.00 to 14.00 DH
                $amount = round($fuelLiters * $pricePerLiter, 2);
                
                PaymentVoucher::create([
                    'voucher_number' => 'BP-' . $voucherNumber++,
                    'invoice_number' => 'FAC-' . rand(1000, 9999),
                    'invoice_date' => $invoiceDate->format('Y-m-d'),
                    'amount' => $amount,
                    'vehicule_id' => $vehicule->getId(),
                    'vehicle_km' => $currentKm,
                    'vehicle_hours' => $currentHours,
                    'category' => 'carburant',
                    'fuel_liters' => $fuelLiters,
                    'supplier' => ['Total', 'Shell', 'BP', 'Agip', 'Afriquia'][rand(0, 4)],
                    'additional_info' => 'Plein effectué',
                ]);
            }

            // Create insurance voucher
            $insuranceDate = Carbon::now()->subMonths(rand(1, 6));
            PaymentVoucher::create([
                'voucher_number' => 'BP-' . $voucherNumber++,
                'invoice_number' => 'ASS-' . rand(1000, 9999),
                'invoice_date' => $insuranceDate->format('Y-m-d'),
                'amount' => rand(5000, 12000),
                'vehicule_id' => $vehicule->getId(),
                'vehicle_km' => $currentKm,
                'category' => 'insurance',
                'insurance_expiration_date' => $vehicule->getInssuranceExpiration(),
                'supplier' => ['AXA', 'Wafa Assurance', 'RMA', 'Atlanta'][rand(0, 3)],
                'additional_info' => 'Assurance annuelle',
            ]);

            // Create technical visit voucher
            $techVisitDate = Carbon::now()->subMonths(rand(2, 8));
            PaymentVoucher::create([
                'voucher_number' => 'BP-' . $voucherNumber++,
                'invoice_number' => 'VT-' . rand(1000, 9999),
                'invoice_date' => $techVisitDate->format('Y-m-d'),
                'amount' => rand(300, 800),
                'vehicule_id' => $vehicule->getId(),
                'vehicle_km' => $currentKm,
                'category' => 'visite_technique',
                'technical_visit_expiration_date' => $vehicule->getTechnicalvisiteExpiration(),
                'supplier' => 'Centre de contrôle technique',
                'additional_info' => 'Visite technique annuelle',
            ]);

            // Create maintenance vouchers
            $vidanges = Vidange::where('car_id', $vehicule->getId())->get();
            if ($vidanges->isNotEmpty()) {
                $vidange = $vidanges->first();
                $maintenanceDate = Carbon::now()->subMonths(rand(1, 4));
                PaymentVoucher::create([
                    'voucher_number' => 'BP-' . $voucherNumber++,
                    'invoice_number' => 'ENT-' . rand(1000, 9999),
                    'invoice_date' => $maintenanceDate->format('Y-m-d'),
                    'amount' => rand(400, 800),
                    'vehicule_id' => $vehicule->getId(),
                    'vehicle_km' => $currentKm,
                    'category' => 'entretien',
                    'vidange_id' => $vidange->getId(),
                    'supplier' => 'Garage Auto',
                    'additional_info' => 'Vidange effectuée',
                ]);
            }

            // Create tire change vouchers
            $pneus = pneu::where('car_id', $vehicule->getId())->get();
            if ($pneus->isNotEmpty() && rand(0, 1)) {
                $pneu = $pneus->random();
                $tireDate = Carbon::now()->subMonths(rand(1, 6));
                PaymentVoucher::create([
                    'voucher_number' => 'BP-' . $voucherNumber++,
                    'invoice_number' => 'PNEU-' . rand(1000, 9999),
                    'invoice_date' => $tireDate->format('Y-m-d'),
                    'amount' => rand(600, 1500),
                    'vehicule_id' => $vehicule->getId(),
                    'vehicle_km' => $currentKm,
                    'category' => 'rechange_pneu',
                    'tire_id' => $pneu->getId(),
                    'supplier' => 'Pneus Express',
                    'additional_info' => 'Changement de pneu',
                ]);
            }

            // Create other category vouchers
            for ($i = 0; $i < rand(2, 5); $i++) {
                $categories = ['lavage', 'lubrifiant', 'reparation', 'achat_pieces_recharges', 'frais_immatriculation', 'other'];
                $category = $categories[rand(0, count($categories) - 1)];
                $voucherDate = Carbon::now()->subMonths(rand(1, 10));
                
                $voucherData = [
                    'voucher_number' => 'BP-' . $voucherNumber++,
                    'invoice_number' => 'FAC-' . rand(1000, 9999),
                    'invoice_date' => $voucherDate->format('Y-m-d'),
                    'amount' => rand(200, 2000),
                    'vehicule_id' => $vehicule->getId(),
                    'vehicle_km' => $currentKm - rand(0, 5000),
                    'category' => $category,
                    'supplier' => ['Fournisseur A', 'Fournisseur B', 'Garage Auto', 'Magasin Pièces'][rand(0, 3)],
                ];

                if ($category === 'other') {
                    $voucherData['vehicle_hours'] = $currentHours ? ($currentHours - rand(0, 100)) : null;
                    $voucherData['additional_info'] = 'Autre dépense';
                }

                PaymentVoucher::create($voucherData);
            }
        }
    }
}
