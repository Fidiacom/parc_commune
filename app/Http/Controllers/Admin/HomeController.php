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
     * Get vehicles that exceed max fuel consumption.
     */
    protected function getVehiclesExceedingMaxConsumption()
    {
        $vehicles = Vehicule::whereNotNull('max_fuel_consumption_100km')->get();
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
            $totalFuelLiters = $fuelVouchers->sum(function($v) { return $v->getFuelLiters() ?? 0; });

            if ($totalKm > 0 && $totalFuelLiters > 0) {
                $averageConsumption = ($totalFuelLiters / $totalKm) * 100;
                
                if ($averageConsumption > $vehicule->getMaxFuelConsumption100km()) {
                    $exceedingVehicles[] = [
                        'vehicule' => $vehicule,
                        'average_consumption' => $averageConsumption,
                        'max_consumption' => $vehicule->getMaxFuelConsumption100km(),
                        'excess' => $averageConsumption - $vehicule->getMaxFuelConsumption100km()
                    ];
                }
            }
        }

        return $exceedingVehicles;
    }
}
