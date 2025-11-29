<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vehicule;
use App\Models\Driver;
use App\Models\MissionOrder;
use App\Models\StockHistorique;
use App\Models\PaymentVoucher;

class HomeController extends Controller
{
    public function index()
    {
        $vehiculesCount = Vehicule::count();
        $driverCount = Driver::count();
        $missionOrderCount = MissionOrder::count();
        $stockHistoriqueCount = StockHistorique::count();

        $vehicules = Vehicule::latest()->get();
        $historiques = StockHistorique::with('stock')->leftjoin('vehicules', 'vehicules.id', '=','stock_historiques.vehicule_id')->latest()->get(['stock_historiques.*', 'vehicules.brand','vehicules.model','vehicules.matricule']);

        // Get vehicles exceeding max consumption
        $vehiclesExceedingConsumption = $this->getVehiclesExceedingMaxConsumption();

        return view('dashboard', [
            'vehiculesCount'    =>  $vehiculesCount,
            'driverCount'       =>  $driverCount,
            'missionOrderCount'  =>  $missionOrderCount,
            'vehicules'         =>  $vehicules,
            'historiques'       =>  $historiques,
            'stockHistoriqueCount'  =>  $stockHistoriqueCount,
            'vehiclesExceedingConsumption' => $vehiclesExceedingConsumption
        ]);
    }

    /**
     * Get vehicles that exceed max fuel consumption (both km and hour based).
     */
    protected function getVehiclesExceedingMaxConsumption()
    {
        // Get vehicles with either km or hour consumption limits
        $vehicles = Vehicule::where(function($query) {
            $query->whereNotNull('max_fuel_consumption_100km')
                  ->orWhereNotNull('max_fuel_consumption_hour');
        })->get();
        
        $exceedingVehicles = [];

        foreach ($vehicles as $vehicule) {
            $fuelVouchers = PaymentVoucher::where('vehicule_id', $vehicule->getId())
                ->where('category', 'carburant')
                ->whereNotNull('fuel_liters')
                ->orderBy('invoice_date', 'asc')
                ->get();

            if ($fuelVouchers->count() < 2) {
                continue;
            }

            $firstVoucher = $fuelVouchers->first();
            $lastVoucher = $fuelVouchers->last();
            $totalKm = $lastVoucher->getVehicleKm() - $firstVoucher->getVehicleKm();
            $totalHours = null;
            if ($lastVoucher->getVehicleHours() && $firstVoucher->getVehicleHours()) {
                $totalHours = $lastVoucher->getVehicleHours() - $firstVoucher->getVehicleHours();
            }
            $totalFuelLiters = $fuelVouchers->sum(function($v) { return $v->getFuelLiters() ?? 0; });

            $exceedsKm = false;
            $exceedsHour = false;
            $averageConsumptionKm = null;
            $averageConsumptionHour = null;

            // Check km-based consumption
            if ($totalKm > 0 && $totalFuelLiters > 0 && $vehicule->getMaxFuelConsumption100km()) {
                $averageConsumptionKm = ($totalFuelLiters / $totalKm) * 100;
                $exceedsKm = $averageConsumptionKm > $vehicule->getMaxFuelConsumption100km();
            }

            // Check hour-based consumption
            if ($totalHours > 0 && $totalFuelLiters > 0 && $vehicule->getMaxFuelConsumptionHour()) {
                $averageConsumptionHour = $totalFuelLiters / $totalHours;
                $exceedsHour = $averageConsumptionHour > $vehicule->getMaxFuelConsumptionHour();
            }

            if ($exceedsKm || $exceedsHour) {
                $exceedingVehicles[] = [
                    'vehicule' => $vehicule,
                    'average_consumption_km' => $averageConsumptionKm,
                    'average_consumption_hour' => $averageConsumptionHour,
                    'max_consumption_km' => $vehicule->getMaxFuelConsumption100km(),
                    'max_consumption_hour' => $vehicule->getMaxFuelConsumptionHour(),
                    'exceeds_km' => $exceedsKm,
                    'exceeds_hour' => $exceedsHour,
                    'excess_km' => $exceedsKm ? ($averageConsumptionKm - $vehicule->getMaxFuelConsumption100km()) : null,
                    'excess_hour' => $exceedsHour ? ($averageConsumptionHour - $vehicule->getMaxFuelConsumptionHour()) : null,
                ];
            }
        }

        return $exceedingVehicles;
    }
}
