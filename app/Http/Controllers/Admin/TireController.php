<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\pneu;
use Validator;
use Alert;
class TireController extends Controller
{
    public function create($carId)
    {
        try {
            $vehicule = Vehicule::findOrFail($carId);

        } catch (\Throwable $th) {
            dd('Vehicule Not found');
        }


        return view('admin.tires.create', ['tires'  =>  $vehicule->number_of_tires, 'carId' =>  $carId]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'positions.*'     =>  'required',
            'thresholds.*'    =>  'required',
            'nextKMs.*'       =>  'required',
            'carId'           =>    'required'
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
                $pneu->current_km   =   intval($vehicule->total_km);
                $pneu->next_km_for_change   =   intval($request->nextKMs[$num]);
                $pneu->threshold_km     =   intval($request->thresholds[$num]);
                $pneu->tire_position    =   $request->positions[$num];
                $pneu->save();
            }


            Alert::success('Saved', 'Saved');
            return redirect(route('admin.vehicule'));
        } catch (\Throwable $th) {
            dd('Vehicule Not found', $th);
        }


    }
}
