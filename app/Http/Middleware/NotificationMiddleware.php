<?php

namespace App\Http\Middleware;

use App\Models\Stock;
use App\Models\Trip;
use App\Models\Vehicule;
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
        }

        return $notification;
    }




    //Trips
    public function trip()
    {
        $currentDate = date('Y-m-d');
        $expiredTrip = Trip::with('driver','vehicule')->whereNotNull('end')->where('end', '<=', $currentDate)->get();

        
        return $expiredTrip;
    }



    public function handle(Request $request, Closure $next): Response
    {

        
        $stockNotifications = $this->stock();
        $chargeNotifications = $this->chargeNotifications();
        $tripNotifications = $this->trip();

        $numberOfNotification = $stockNotifications->count() + $chargeNotifications->count() + $tripNotifications->count();

        View::share([
            'chargeNotification'    =>  $chargeNotifications,
            'stockNotification'     =>  $stockNotifications,
            'numberOfNotification'  =>  $numberOfNotification,
            'trips'                 =>  $tripNotifications
        ]);
        return $next($request);
    }
}
