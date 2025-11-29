<?php

namespace App\Http\Middleware;

use App\Models\Stock;
use App\Models\MissionOrder;
use App\Models\Vehicule;
use App\Models\PaymentVoucher;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class NotificationMiddleware
{

    // Stocks
    public function stock()
    {
        $stocks = Stock::all();

        $stockNotif = collect();
        foreach ($stocks as $stock)
        {
            if($stock->min_stock_alert >= $stock->stock_actuel)
            {
                $stock->message = $stock->stock_actuel == 0 ? 'Alert | out of stock' : 'Alert | still only: '.$stock->stock_actuel ;
                $stockNotif->push($stock);
            }
        }
        return $stockNotif;
    }

    public function chargeNotifications()
    {
        $vehicules = Vehicule::with('vidange.vidange_historique', 'timing_chaine.timingchaine_historique','pneu.pneu_historique')->get();
        $notification = collect();
        foreach ($vehicules as $vehicule)
        {

            // Vidange Notification
            $vidangeHistorique = optional($vehicule->vidange)->vidange_historique;
            if($vidangeHistorique instanceof Collection && $vidangeHistorique->isNotEmpty())
            {
                $nextDrain = $vidangeHistorique->last()->next_km_for_drain ?? null;
                if(!is_null($nextDrain) && $vehicule->total_km >= $nextDrain)
                {
                    $notification->push([
                        'vehicule_id'   => $vehicule->id,
                        'vehicule'      => $vehicule->brand.' '.$vehicule->model.'| ('.$vehicule->matricule.')',
                        'notif'         => 'vidange',
                        'message'       => 'need a drain',
                    ]);
                }
            }

            // Timing Chaine Notification

            $timingHistorique = optional($vehicule->timing_chaine)->timingchaine_historique;
            if($timingHistorique instanceof Collection && $timingHistorique->isNotEmpty())
            {
                $nextTimingChange = $timingHistorique->last()->next_km_for_change ?? null;
                if(!is_null($nextTimingChange) && $vehicule->total_km >= $nextTimingChange)
                {
                    $notification->push([
                        'vehicule_id'   => $vehicule->id,
                        'vehicule'      => $vehicule->brand.' '.$vehicule->model.'| ('.$vehicule->matricule.')',
                        'notif'         => 'Timing Chaine',
                        'message'       => 'Need to change Timing Chaine',
                    ]);
                }
            }

            // Pneu Notification
            $pneus = $vehicule->pneu;
            if(!($pneus instanceof Collection))
            {
                continue;
            }

            foreach ($pneus as $pneu)
            {
                $pneuHistorique = optional($pneu->pneu_historique);
                if($pneuHistorique instanceof Collection && $pneuHistorique->isNotEmpty())
                {
                    $nextPneuChange = $pneuHistorique->last()->next_km_for_change ?? null;
                    if(!is_null($nextPneuChange) && $vehicule->total_km >= $nextPneuChange)
                    {
                        $notification->push([
                            'vehicule_id'   => $vehicule->id,
                            'vehicule'      => $vehicule->brand.' '.$vehicule->model.'| ('.$vehicule->matricule.')',
                            'notif'         => 'Pneu',
                            'message'       => 'Need to change Pneu | Position:'.$pneu->tire_position,
                        ]);
                    }
                }
            }

            // Consumption Notification
            $consumptionAlert = $this->checkConsumptionAlert($vehicule);
            if ($consumptionAlert) {
                $notification->push($consumptionAlert);
            }
        }

        return $notification;
    }

    /**
     * Check if vehicle consumption exceeds limits (both km and hour based).
     */
    protected function checkConsumptionAlert($vehicule)
    {
        // Get fuel vouchers for consumption calculation
        $fuelVouchers = PaymentVoucher::where('vehicule_id', $vehicule->getId())
            ->where('category', 'carburant')
            ->whereNotNull('fuel_liters')
            ->orderBy('invoice_date', 'asc')
            ->get();

        if ($fuelVouchers->count() < 2) {
            return null;
        }

        $firstVoucher = $fuelVouchers->first();
        $lastVoucher = $fuelVouchers->last();
        $totalKm = $lastVoucher->getVehicleKm() - $firstVoucher->getVehicleKm();
        $totalHours = null;
        if ($lastVoucher->getVehicleHours() && $firstVoucher->getVehicleHours()) {
            $totalHours = $lastVoucher->getVehicleHours() - $firstVoucher->getVehicleHours();
        }
        $totalFuelLiters = $fuelVouchers->sum(function($v) { return $v->getFuelLiters() ?? 0; });

        $messages = [];
        $alertType = null;

        // Check km-based consumption
        if ($totalKm > 0 && $totalFuelLiters > 0) {
            $averageConsumptionKm = ($totalFuelLiters / $totalKm) * 100;
            
            if ($vehicule->getMaxFuelConsumption100km() && $averageConsumptionKm > $vehicule->getMaxFuelConsumption100km()) {
                $excess = $averageConsumptionKm - $vehicule->getMaxFuelConsumption100km();
                $messages[] = 'Consommation élevée (KM): ' . number_format($averageConsumptionKm, 2, ',', ' ') . ' L/100km (max: ' . number_format($vehicule->getMaxFuelConsumption100km(), 2, ',', ' ') . ' L/100km, excès: ' . number_format($excess, 2, ',', ' ') . ' L/100km)';
                $alertType = 'consumption_km';
            }
        }

        // Check hour-based consumption
        if ($totalHours > 0 && $totalFuelLiters > 0) {
            $averageConsumptionHour = $totalFuelLiters / $totalHours;
            
            if ($vehicule->getMaxFuelConsumptionHour() && $averageConsumptionHour > $vehicule->getMaxFuelConsumptionHour()) {
                $excess = $averageConsumptionHour - $vehicule->getMaxFuelConsumptionHour();
                $messages[] = 'Consommation élevée (Heures): ' . number_format($averageConsumptionHour, 2, ',', ' ') . ' L/H (max: ' . number_format($vehicule->getMaxFuelConsumptionHour(), 2, ',', ' ') . ' L/H, excès: ' . number_format($excess, 2, ',', ' ') . ' L/H)';
                $alertType = $alertType ? 'consumption_both' : 'consumption_hour';
            }

            // Check if below min hour consumption
            if ($vehicule->getMinFuelConsumptionHour() && $averageConsumptionHour < $vehicule->getMinFuelConsumptionHour()) {
                $deficit = $vehicule->getMinFuelConsumptionHour() - $averageConsumptionHour;
                $messages[] = 'Consommation faible (Heures): ' . number_format($averageConsumptionHour, 2, ',', ' ') . ' L/H (min: ' . number_format($vehicule->getMinFuelConsumptionHour(), 2, ',', ' ') . ' L/H, déficit: ' . number_format($deficit, 2, ',', ' ') . ' L/H)';
                $alertType = $alertType ? 'consumption_both' : 'consumption_hour_low';
            }
        }

        if (!empty($messages)) {
            return [
                'vehicule_id'   => $vehicule->id,
                'vehicule'      => $vehicule->brand.' '.$vehicule->model.'| ('.$vehicule->matricule.')',
                'notif'         => 'Consommation',
                'message'       => implode(' | ', $messages),
            ];
        }

        return null;
    }




    //Mission Orders
    public function missionOrder()
    {
        $currentDate = date('Y-m-d');
        $expiredMissionOrder = MissionOrder::with('driver','vehicule')->whereNotNull('end')->where('end', '<=', $currentDate)->get();

        
        return $expiredMissionOrder;
    }



    public function handle(Request $request, Closure $next): Response
    {

        
        $stockNotifications = $this->stock();
        $chargeNotifications = $this->chargeNotifications();
        $missionOrderNotifications = $this->missionOrder();

        $numberOfNotification = $stockNotifications->count() + $chargeNotifications->count() + $missionOrderNotifications->count();

        View::share([
            'chargeNotification'    =>  $chargeNotifications,
            'stockNotification'     =>  $stockNotifications,
            'numberOfNotification'  =>  $numberOfNotification,
            'missionOrders'         =>  $missionOrderNotifications
        ]);
        return $next($request);
    }
}
