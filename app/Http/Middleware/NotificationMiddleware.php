<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Stock;
use App\Models\pneu;
use App\Models\Vehicule;
use App\Models\Trip;
use Illuminate\Http\Request;
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
            if($vehicule->total_km >= $vehicule->vidange->vidange_historique->last()->next_km_for_drain)
            {
                $notification->push([
                    'vehicule_id'   => $vehicule->id,
                    'vehicule'      => $vehicule->brand.' '.$vehicule->model.'| ('.$vehicule->matricule.')',
                    'notif'         => 'vidange',
                    'message'       => 'need a drain',
                ]);

            }

            // Timing Chaine Notification

            if($vehicule->total_km >= $vehicule->timing_chaine->timingchaine_historique->last()->next_km_for_change)
            {
                $notification->push([
                    'vehicule_id'   => $vehicule->id,
                    'vehicule'      => $vehicule->brand.' '.$vehicule->model.'| ('.$vehicule->matricule.')',
                    'notif'         => 'Timing Chaine',
                    'message'       => 'Need to change Timing Chaine',
                ]);
            }

            // Pneu Notification
            foreach ($vehicule->pneu as $pneu)
            {

                if($vehicule->total_km >= $pneu->pneu_historique->last()->next_km_for_change)
                {
                    $notification->push([
                        'vehicule_id'   => $vehicule->id,
                        'vehicule'      => $vehicule->brand.' '.$vehicule->model.'| ('.$vehicule->matricule.')',
                        'notif'         => 'Pneu',
                        'message'       => 'Need to change Pneu | Position:'.$pneu->tire_position,
                    ]);

                }
            }

            return $notification;
        }
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


        $numberOfNotification = $this->stock()->count() + $this->chargeNotifications()->count() + $this->trip()->count();

        \View::share([
            'chargeNotification'    =>  $this->chargeNotifications(),
            'stockNotification'     =>  $this->stock(),
            'numberOfNotification'  =>  $numberOfNotification,
            'trips'                 =>  $this->trip()
        ]);
        return $next($request);
    }
}
