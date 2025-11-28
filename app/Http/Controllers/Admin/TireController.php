<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\pneu;
use App\Models\PneuHistorique;
use Validator;
use Alert;
class TireController extends Controller
{
    public function create($carId)
    {
        try {
            $vehicule = Vehicule::findOrFail($carId);

        } catch (\Throwable $th) {
            return view('admin.vehicule.404');
        }


        return view('admin.tires.create', ['tires'  =>  $vehicule->number_of_tires, 'carId' =>  $carId]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'positions.*'     =>  'required',
            'thresholds.*'    =>  'required',
            'nextKMs.*'       =>  'required',
            'carId'           =>   'required'
        ]);

        if($validator->fails()){
            Alert::error('Error', 'All field are required');
            return back();
        }


        try {
            $vehicule = Vehicule::findOrFail($request->carId);

            foreach(range(0, $vehicule->number_of_tires-1) as $num)
            {

                $pneu = new pneu;
                $pneu->car_id   =   $vehicule->id;
                $pneu->threshold_km     =   intval($request->thresholds[$num]);
                $pneu->tire_position    =   $request->positions[$num];
                $pneu->save();


                $historique = new PneuHistorique;
                $historique->pneu_id    =   $pneu->id;
                $historique->current_km =   intval($vehicule->total_km);
                $historique->next_km_for_change =   intval($request->nextKMs[$num]);
                $historique->save();
            }


            Alert::success('Saved', 'Saved');
            return redirect(route('admin.vehicule'));
        } catch (\Throwable $th) {
            dd('Vehicule Not found', $th);
        }
    }


    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'threshold_km'  =>  'required'
    //     ]);

    //     if($validator->fails()){
    //         Alert::error('Error', 'All field are required');
    //         return back();
    //     }

    //     try {
    //         $id =   Crypt::decrypt($id);

    //         $pneu = pneu::findOrFail($id);
    //         $pneu->threshold_km =   $request->threshold_km;
    //         $pneu->update();

    //         Alert::success('Saved', 'Saved');
    //         return back();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }


    public function update(Request $request, $vehicule_id)
    {
        try {
            $vehicule = Vehicule::with('pneu')->findOrFail($vehicule_id);

            $validated = $request->validate([
                'km_actuel_pneu' =>  'required|numeric|min:'.$vehicule->total_km
            ]);

            $vehicule->total_km = $request->km_actuel_pneu;
            $vehicule->update();


            foreach ($request->positions as $p) {
                $historique =  new PneuHistorique;
                $historique->pneu_id = $p;
                $historique->current_km =   $request->km_actuel_pneu;
                $historique->next_km_for_change =   floatval($request->km_actuel_pneu) + floatval($vehicule->pneu->find($p)->threshold_km);
                $historique->save();
            }

            Alert::success('Pneu updatedSuccesfully', 'done');
            return back();

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
