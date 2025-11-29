<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vehicule;
use App\Models\Driver;
use App\Models\MissionOrder;
use App\Models\StockHistorique;
use App\Models\PaymentVoucher;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $vehiculesCount = Vehicule::count();
        $driverCount = Driver::count();
        $missionOrderCount = MissionOrder::count();
        $stockHistoriqueCount = StockHistorique::count();

        $vehicules = Vehicule::latest()->limit(10)->get();
        $historiques = StockHistorique::with('stock')->leftjoin('vehicules', 'vehicules.id', '=','stock_historiques.vehicule_id')->latest()->limit(10)->get(['stock_historiques.*', 'vehicules.brand','vehicules.model','vehicules.matricule']);

        // Get vehicles exceeding max consumption
        $vehiclesExceedingConsumption = $this->getVehiclesExceedingMaxConsumption();
        
        // Get vehicles with expiring insurance (within 30 days)
        $vehiclesExpiringInsurance = $this->getVehiclesExpiringInsurance();
        
        // Get vehicles with expiring technical visits (within 30 days)
        $vehiclesExpiringTechnicalVisit = $this->getVehiclesExpiringTechnicalVisit();
        
        // Get vehicles needing maintenance
        $vehiclesNeedingMaintenance = $this->getVehiclesNeedingMaintenance();
        
        // Get active mission orders
        $activeMissionOrders = MissionOrder::whereNull('done_at')->with(['driver', 'vehicule'])->latest()->limit(10)->get();
        
        // Get total costs statistics
        $totalCosts = $this->getTotalCostsStatistics();
        
        // Get recent payment vouchers
        $recentPaymentVouchers = PaymentVoucher::with('vehicule')->latest()->limit(10)->get();

        return view('dashboard', [
            'vehiculesCount'    =>  $vehiculesCount,
            'driverCount'       =>  $driverCount,
            'missionOrderCount'  =>  $missionOrderCount,
            'vehicules'         =>  $vehicules,
            'historiques'       =>  $historiques,
            'stockHistoriqueCount'  =>  $stockHistoriqueCount,
            'vehiclesExceedingConsumption' => $vehiclesExceedingConsumption,
            'vehiclesExpiringInsurance' => $vehiclesExpiringInsurance,
            'vehiclesExpiringTechnicalVisit' => $vehiclesExpiringTechnicalVisit,
            'vehiclesNeedingMaintenance' => $vehiclesNeedingMaintenance,
            'activeMissionOrders' => $activeMissionOrders,
            'totalCosts' => $totalCosts,
            'recentPaymentVouchers' => $recentPaymentVouchers,
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

    /**
     * Get vehicles with expiring insurance (within 30 days).
     */
    protected function getVehiclesExpiringInsurance()
    {
        $today = Carbon::today();
        $thirtyDaysFromNow = Carbon::today()->addDays(30);
        
        $vehicles = Vehicule::all();
        $expiringVehicles = [];
        
        foreach ($vehicles as $vehicule) {
            // Check from payment vouchers first
            $latestInsurance = PaymentVoucher::where('vehicule_id', $vehicule->getId())
                ->where('category', 'insurance')
                ->whereNotNull('insurance_expiration_date')
                ->orderBy('insurance_expiration_date', 'desc')
                ->first();
            
            $expirationDate = null;
            if ($latestInsurance && $latestInsurance->getInsuranceExpirationDate()) {
                $expirationDate = Carbon::parse($latestInsurance->getInsuranceExpirationDate());
            } elseif ($vehicule->getInssuranceExpiration()) {
                $expirationDate = Carbon::parse($vehicule->getInssuranceExpiration());
            }
            
            if ($expirationDate && $expirationDate->between($today, $thirtyDaysFromNow)) {
                $daysUntilExpiration = $today->diffInDays($expirationDate);
                $expiringVehicles[] = [
                    'vehicule' => $vehicule,
                    'expiration_date' => $expirationDate->format('Y-m-d'),
                    'days_until_expiration' => $daysUntilExpiration,
                    'is_expired' => $expirationDate->isPast(),
                ];
            }
        }
        
        return $expiringVehicles;
    }

    /**
     * Get vehicles with expiring technical visits (within 30 days).
     */
    protected function getVehiclesExpiringTechnicalVisit()
    {
        $today = Carbon::today();
        $thirtyDaysFromNow = Carbon::today()->addDays(30);
        
        $vehicles = Vehicule::all();
        $expiringVehicles = [];
        
        foreach ($vehicles as $vehicule) {
            // Check from payment vouchers first
            $latestTechnicalVisit = PaymentVoucher::where('vehicule_id', $vehicule->getId())
                ->where('category', 'visite_technique')
                ->whereNotNull('technical_visit_expiration_date')
                ->orderBy('technical_visit_expiration_date', 'desc')
                ->first();
            
            $expirationDate = null;
            if ($latestTechnicalVisit && $latestTechnicalVisit->getTechnicalVisitExpirationDate()) {
                $expirationDate = Carbon::parse($latestTechnicalVisit->getTechnicalVisitExpirationDate());
            } elseif ($vehicule->getTechnicalvisiteExpiration()) {
                $expirationDate = Carbon::parse($vehicule->getTechnicalvisiteExpiration());
            }
            
            if ($expirationDate && $expirationDate->between($today, $thirtyDaysFromNow)) {
                $daysUntilExpiration = $today->diffInDays($expirationDate);
                $expiringVehicles[] = [
                    'vehicule' => $vehicule,
                    'expiration_date' => $expirationDate->format('Y-m-d'),
                    'days_until_expiration' => $daysUntilExpiration,
                    'is_expired' => $expirationDate->isPast(),
                ];
            }
        }
        
        return $expiringVehicles;
    }

    /**
     * Get vehicles needing maintenance (vidange, timing chain, tires).
     */
    protected function getVehiclesNeedingMaintenance()
    {
        $vehicles = Vehicule::with(['vidange', 'timing_chaine', 'pneu'])->get();
        $needingMaintenance = [];
        
        foreach ($vehicles as $vehicule) {
            $maintenanceItems = [];
            
            // Check vidange threshold
            if ($vehicule->vidange) {
                $thresholdKm = $vehicule->vidange->getThresholdKm();
                $currentKm = $vehicule->getTotalKm();
                if ($thresholdKm && $currentKm >= $thresholdKm) {
                    $maintenanceItems[] = [
                        'type' => 'vidange',
                        'message' => __('Vidange nécessaire'),
                        'current_km' => $currentKm,
                        'threshold_km' => $thresholdKm,
                    ];
                }
            }
            
            // Check timing chain threshold
            if ($vehicule->timing_chaine) {
                $thresholdKm = $vehicule->timing_chaine->getThresholdKm();
                $currentKm = $vehicule->getTotalKm();
                if ($thresholdKm && $currentKm >= $thresholdKm) {
                    $maintenanceItems[] = [
                        'type' => 'timing_chaine',
                        'message' => __('Chaîne de distribution nécessaire'),
                        'current_km' => $currentKm,
                        'threshold_km' => $thresholdKm,
                    ];
                }
            }
            
            // Check tire thresholds
            foreach ($vehicule->pneu as $tire) {
                $thresholdKm = $tire->getThresholdKm();
                $currentKm = $vehicule->getTotalKm();
                if ($thresholdKm && $currentKm >= $thresholdKm) {
                    $maintenanceItems[] = [
                        'type' => 'pneu',
                        'message' => __('Pneu ' . $tire->getTirePosition() . ' nécessaire'),
                        'current_km' => $currentKm,
                        'threshold_km' => $thresholdKm,
                        'tire_position' => $tire->getTirePosition(),
                    ];
                }
            }
            
            if (!empty($maintenanceItems)) {
                $needingMaintenance[] = [
                    'vehicule' => $vehicule,
                    'maintenance_items' => $maintenanceItems,
                ];
            }
        }
        
        return $needingMaintenance;
    }

    /**
     * Get total costs statistics.
     */
    protected function getTotalCostsStatistics()
    {
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();
        
        $totalAllTime = PaymentVoucher::sum('amount');
        $totalThisMonth = PaymentVoucher::where('invoice_date', '>=', $thisMonth)->sum('amount');
        $totalLastMonth = PaymentVoucher::whereBetween('invoice_date', [$lastMonth, $thisMonth->copy()->subDay()])->sum('amount');
        $totalThisYear = PaymentVoucher::where('invoice_date', '>=', $thisYear)->sum('amount');
        
        // Costs by category
        $costsByCategory = PaymentVoucher::selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get()
            ->pluck('total', 'category');
        
        // Fuel costs
        $fuelCosts = PaymentVoucher::where('category', 'carburant')->sum('amount');
        
        return [
            'total_all_time' => $totalAllTime,
            'total_this_month' => $totalThisMonth,
            'total_last_month' => $totalLastMonth,
            'total_this_year' => $totalThisYear,
            'costs_by_category' => $costsByCategory,
            'fuel_costs' => $fuelCosts,
        ];
    }
}
