<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vidange;
use App\Models\Vehicule;
use App\Models\VidangeHistorique;
use Crypt;
use Alert;

class VidangeController extends Controller
{
    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'threshold_km'  =>  'required'
    //     ]);

    //     try {
    //         $id = Crypt::decrypt($id);
    //         $vidange = Vidange::findOrFail($id);
    //         $vidange->threshold_km = $request->threshold_km;
    //         $vidange->update();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }



    //     Alert::success('Vehicule Saved Successfully', 'Please fill tires field');
    //     return back();
    // }


    public function update(Request $request, $vehicule_id)
    {
        //dump($request->all(), $vehicule_id);
        try {
            $id = Crypt::decrypt($vehicule_id);
            $vehicule = Vehicule::with('vidange')->findOrFail($id);

            $validated = $request->validate([
                'km_actuel_vidange' =>  'required|numeric|min:'.$vehicule->total_km
            ]);

            $vehicule->total_km = $request->km_actuel_vidange;

            $vehicule->update();

            $historique = new VidangeHistorique;
            $historique->vidange_id         =   $vehicule->vidange->id;
            $historique->current_km         =   $request->km_actuel_vidange;
            $historique->next_km_for_drain  =   floatval($request->km_actuel_vidange) + floatval($vehicule->vidange->threshold_km);
            $historique->save();


            Alert::success('Vehicule Saved Successfully', 'Please fill tires field');
            return back();

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
