<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimingChaine;
use App\Models\Vehicule;
use App\Models\TimingChaineHistorique;
use Crypt;
use Alert;

class TiminChaineController extends Controller
{
    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'threshold_km'  =>  'required'
    //     ]);


    //     try {
    //         $id = Crypt::decrypt($id);
    //         $timingChaine = TimingChaine::findOrFail($id);
    //         $timingChaine->threshold_km = $request->threshold_km;
    //         $timingChaine->update();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }


    //     Alert::success('Vehicule Saved Successfully', 'Please fill tires field');
    //     return back();
    // }


    public function update(Request $request, $vehicule_id)
    {
        try {
            //code...
            $id = Crypt::decrypt($vehicule_id);

            $vehicule = Vehicule::with('timing_chaine')->findOrFail($id);

            $validated = $request->validate([
                'km_actuel' =>  'required|numeric|min:'.$vehicule->total_km
            ]);

            $vehicule->total_km = $request->km_actuel;
            $vehicule->update();

            $historique = new TimingChaineHistorique;
            $historique->chaine_id          =   $vehicule->timing_chaine->id;
            $historique->current_km         =   $request->km_actuel;
            $historique->next_km_for_change  =   floatval($request->km_actuel) + floatval($vehicule->vidange->threshold_km);
            $historique->save();

            Alert::success('Vehicule Saved Successfully', 'Please fill tires field');
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
