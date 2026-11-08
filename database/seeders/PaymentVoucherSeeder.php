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
        // Demo vouchers are only created once
        if (PaymentVoucher::query()->exists()) {
            return;
        }

        $vehicules = Vehicule::all();
        $voucherNumber = 1000;

        foreach ($vehicules as $vehicule) {
            $startDate = Carbon::now()->subMonths(12);

            // Create fuel vouchers for consumption tracking
            // For some vehicles, create higher consumption to test alerts
            $isHighConsumption = rand(1, 3) === 1; // 33% chance of high consumption vehicle

            // Consumption rate: inside the vehicle's min-max range, or 2-5 above max for "high" vehicles
            $rate = function (?float $min, ?float $max, float $defaultMin, float $defaultMax, bool $high): float {
                $min = $min ?: $defaultMin;
                $max = $max ?: max($min + 2, $defaultMax);

                return $high ? $max + rand(2, 5) : $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
            };

            // Machines with hour limits burn fuel per hour, other vehicles per km
            $usesHours = $vehicule->getTotalHours()
                && ($vehicule->getMinFuelConsumptionHour() || $vehicule->getMaxFuelConsumptionHour());
            $hasKmLimits = $vehicule->getMinFuelConsumption100km() || $vehicule->getMaxFuelConsumption100km();

            // Fill-ups are drawn first so the last one ends at the vehicle's current km / hours:
            // the next real voucher then continues from there.
            $fuelCount = rand(8, 15);
            $fills = [];
            for ($i = 0; $i < $fuelCount; $i++) {
                $hourIncrement = rand(10, 50);
                if ($usesHours) {
                    $liters = round($hourIncrement * $rate($vehicule->getMinFuelConsumptionHour(), $vehicule->getMaxFuelConsumptionHour(), 3, 6, $isHighConsumption), 2);
                    // km driven during those hours, consistent with the km limits when there are any
                    $kmIncrement = $hasKmLimits
                        ? (int) round($liters / $rate($vehicule->getMinFuelConsumption100km(), $vehicule->getMaxFuelConsumption100km(), 6, 9, false) * 100)
                        : rand(50, 300);
                } else {
                    $kmIncrement = rand(500, 2000);
                    $liters = round(($kmIncrement / 100) * $rate($vehicule->getMinFuelConsumption100km(), $vehicule->getMaxFuelConsumption100km(), 6, 9, $isHighConsumption), 2);
                }
                $fills[] = ['km' => $kmIncrement, 'hours' => $hourIncrement, 'liters' => $liters];
            }

            $currentKm = max(0, $vehicule->getTotalKm() - array_sum(array_column($fills, 'km')));
            $currentHours = $vehicule->getTotalHours()
                ? max(0, $vehicule->getTotalHours() - array_sum(array_column($fills, 'hours')))
                : null;

            $daysBetween = intdiv(360, $fuelCount); // keeps every date within the last 12 months
            foreach ($fills as $i => $fill) {
                $currentKm += $fill['km'];
                if ($currentHours !== null) {
                    $currentHours += $fill['hours'];
                }
                $fuelLiters = $fill['liters'];

                $invoiceDate = $startDate->copy()->addDays($i * $daysBetween + rand(0, 5));

                $pricePerLiter = rand(1100, 1400) / 100; // 11.00 to 14.00 DH
                $amount = round($fuelLiters * $pricePerLiter, 2);
                
                PaymentVoucher::create([
                    'voucher_number' => 'BP-' . $voucherNumber++,
                    'voucher_date' => $invoiceDate->format('Y-m-d'),
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
                'voucher_date' => $insuranceDate->format('Y-m-d'),
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
                'voucher_date' => $techVisitDate->format('Y-m-d'),
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
                    'voucher_date' => $maintenanceDate->format('Y-m-d'),
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
                    'voucher_date' => $tireDate->format('Y-m-d'),
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
            $categories = ['lavage', 'lubrifiant', 'reparation', 'achat_pieces_recharges', 'frais_immatriculation', 'other'];
            $otherCount = rand(2, 5);
            for ($i = 0; $i < $otherCount; $i++) {
                $category = $categories[rand(0, count($categories) - 1)];
                $voucherDate = Carbon::now()->subMonths(rand(1, 10));
                
                $voucherData = [
                    'voucher_number' => 'BP-' . $voucherNumber++,
                    'voucher_date' => $voucherDate->format('Y-m-d'),
                    'invoice_number' => 'FAC-' . rand(1000, 9999),
                    'invoice_date' => $voucherDate->format('Y-m-d'),
                    'amount' => rand(200, 2000),
                    'vehicule_id' => $vehicule->getId(),
                    'vehicle_km' => max(0, $currentKm - rand(0, 5000)),
                    'category' => $category,
                    'supplier' => ['Fournisseur A', 'Fournisseur B', 'Garage Auto', 'Magasin Pièces'][rand(0, 3)],
                ];

                if ($category === 'other') {
                    $voucherData['vehicle_hours'] = $currentHours ? max(0, $currentHours - rand(0, 100)) : null;
                    $voucherData['additional_info'] = 'Autre dépense';
                }

                PaymentVoucher::create($voucherData);
            }
        }
    }
}
