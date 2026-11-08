<?php

namespace App\Http\Middleware;

use App\Models\Stock;
use App\Models\MissionOrder;
use App\Models\Vehicule;
use App\Services\FuelConsumptionService;
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
                $stock->message = $stock->stock_actuel == 0 
                    ? __('Alert | out of stock') 
                    : __('Alert | still only: :quantity', ['quantity' => $stock->stock_actuel]);
                $stockNotif->push($stock);
            }
        }
        return $stockNotif;
    }

    public function chargeNotifications()
    {
        $vehicules = Vehicule::with('vidange.vidange_historique', 'timing_chaine.timingchaine_historique','pneu.pneu_historique')->get();
        $notification = collect();

        // Fuel consumption alerts for all vehicles (latest fill-up, one query)
        $consumptionAlerts = app(FuelConsumptionService::class)->allAlerts();

        foreach ($vehicules as $vehicule)
        {
            // Consumption Notification
            if (isset($consumptionAlerts[$vehicule->id])) {
                $notification->push($this->consumptionNotification($vehicule, $consumptionAlerts[$vehicule->id]));
            }

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
                        'notif'         => __('Vidange'),
                        'message'       => __('Need a drain'),
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
                        'notif'         => __('Timing Chaine'),
                        'message'       => __('Need to change Timing Chaine'),
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
                            'notif'         => __('Pneu'),
                            'message'       => __('Need to change Pneu | Position: :position', ['position' => $pneu->tire_position]),
                        ]);
                    }
                }
            }
        }

        return $notification;
    }

    /**
     * Bell notification for a fuel consumption alert (see FuelConsumptionService::alert()).
     */
    protected function consumptionNotification($vehicule, array $alert): array
    {
        $fmt = fn ($value) => number_format((float) $value, 2, ',', ' ');
        $messages = [];

        if ($alert['exceeds_km']) {
            $messages[] = __('High consumption (KM): :avg L/100km (max: :max L/100km, excess: :excess L/100km)', [
                'avg' => $fmt($alert['average_consumption_km']),
                'max' => $fmt($alert['max_consumption_km']),
                'excess' => $fmt($alert['excess_km']),
            ]);
        }

        if ($alert['below_km']) {
            $messages[] = __('Low consumption (KM): :avg L/100km (min: :min L/100km, deficit: :deficit L/100km)', [
                'avg' => $fmt($alert['average_consumption_km']),
                'min' => $fmt($alert['min_consumption_km']),
                'deficit' => $fmt($alert['deficit_km']),
            ]);
        }

        if ($alert['exceeds_hour']) {
            $messages[] = __('High consumption (Hours): :avg L/H (max: :max L/H, excess: :excess L/H)', [
                'avg' => $fmt($alert['average_consumption_hour']),
                'max' => $fmt($alert['max_consumption_hour']),
                'excess' => $fmt($alert['excess_hour']),
            ]);
        }

        if ($alert['below_hour']) {
            $messages[] = __('Low consumption (Hours): :avg L/H (min: :min L/H, deficit: :deficit L/H)', [
                'avg' => $fmt($alert['average_consumption_hour']),
                'min' => $fmt($alert['min_consumption_hour']),
                'deficit' => $fmt($alert['deficit_hour']),
            ]);
        }

        return [
            'vehicule_id'   => $vehicule->id,
            'vehicule'      => $vehicule->brand.' '.$vehicule->model.'| ('.$vehicule->matricule.')',
            'notif'         => __('Consommation'),
            'message'       => implode(' | ', $messages),
        ];
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
        $chargeNotifications = $this->chargeNotifications();
        $missionOrderNotifications = $this->missionOrder();

        $numberOfNotification =  $chargeNotifications->count() + $missionOrderNotifications->count();

        View::share([
            'chargeNotification'    =>  $chargeNotifications,
            'stockNotification'     =>  [],
            'numberOfNotification'  =>  $numberOfNotification,
            'missionOrders'         =>  $missionOrderNotifications
        ]);
        return $next($request);
    }
}
