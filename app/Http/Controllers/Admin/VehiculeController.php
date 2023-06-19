<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Vidange;
use App\Models\pneu;
use App\Models\TimingChaine;


use Alert;
class VehiculeController extends Controller
{
    public function index()
    {
        return view('admin.vehicule.index');
    }

    public function create()
    {
        return view('admin.vehicule.create');
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'brand'                         =>  'required',
            'model'                         =>  'required',
            'matricule'                     =>  'required',
            'chassis'                       =>  'required',
            'carte_grise'                   =>  'required',
            'km_actuel'                     =>  'required',
            'horses'                        =>  'required',
            'fuel_type'                     =>  'required|not_in:0',
            'threshold_vidange'             =>  'required',
            'threshold_timing_chaine'       =>  'required',
            'inssurance_expiration'         =>  'required',
            'technical_visit_expiration'    =>  'required',
            'numOfTires'                    =>  'required',
        ]);

        dd($request->all(), isset($request->abs));
        Alert::success('Congrats', 'You\'ve Successfully Registered');
        return redirect()->back();

        $vehicule                   =   new Vehicule;
        $vehicule->brand            =   $request->brand;
        $vehicule->image            =   isset($request->image) ? uploadFile($request->image, 'vehicules') : null;
        $vehicule->model            =   $request->model;
        $vehicule->matricule        =   $request->matricule;
        $vehicule->num_chassis      =   $request->chassis;
        $vehicule->num_carte_grise  =   $request->carte_grise;
        $vehicule->total_km         =   $request->km_actuel;
        $vehicule->horses           =   $request->horses;
        $vehicule->fuel_type        =   $request->fuel_type;
        $vehicule->airbag           =   isset($request->airbag) ? 1 : 0;
        $vehicule->abs              =   isset($request->abs) ? 1 : 0;;
        $vehicule->save();


        $vidange =  new Vidange;
        $vidange->car_id            =   $vehicule->id;
        $vidange->current_km        =   $request->km_actuel;
        $vidange->next_km_for_drain =   intval($request->km_actuel) + intval($request->threshold_vidange);
        $vidange->threshold_km      =   $request->threshold_vidange;
        $vidange->save();

        $tire = new pneu;
        $tire->car_id               =   $vehicule->id;
        $tire->current_km           =   $request->km_actuel;;
        $tire->next_km_for_change   =   intval($request->km_actuel) + intval($request->pneu_ag);;
        $tire->threshold_km         =   $request->pneu_ag;
        $tire->tire_position        =   'ag';
        $tire->save();


    }
}
