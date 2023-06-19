<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Vidange;
use App\Models\TimingChaine;


use Alert;
class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::latest()->get();

        return view('admin.vehicule.index', ['vehicules' => $vehicules]);
    }

    public function create()
    {
        return view('admin.vehicule.create');
    }


    public function store(Request $request)
    {
        //dd($request->all(), floatval(intval(str_replace('.','',$request->km_actuel))));
        $validated = $request->validate([
            'brand'                         =>  'required',
            'model'                         =>  'required',
            'matricule'                     =>  'required',
            'chassis'                       =>  'required',
            'km_actuel'                     =>  'required',
            'horses'                        =>  'required',
            'fuel_type'                     =>  'required|not_in:0',
            'threshold_vidange'             =>  'required',
            'threshold_timing_chaine'       =>  'required',
            'inssurance_expiration'         =>  'required',
            'technical_visit_expiration'    =>  'required',
            'numOfTires'                    =>  'required',
        ]);


        $vehicule                   =   new Vehicule;
        $vehicule->brand            =   $request->brand;
        $vehicule->image            =   isset($request->image) ? uploadFile($request->image, 'vehicules') : null;
        $vehicule->model            =   $request->model;
        $vehicule->matricule        =   $request->matricule;
        $vehicule->num_chassis      =   $request->chassis;
        $vehicule->total_km         =   intval(str_replace('.','',$request->km_actuel));
        $vehicule->horses           =   intval(str_replace('.','',$request->horses));
        $vehicule->fuel_type        =   $request->fuel_type;
        $vehicule->airbag           =   isset($request->airbag) ? 1 : 0;
        $vehicule->abs              =   isset($request->abs) ? 1 : 0;
        $vehicule->inssurance_expiration              =   $request->inssurance_expiration;
        $vehicule->technicalvisite_expiration         =   $request->technical_visit_expiration;
        $vehicule->number_of_tires         =   $request->numOfTires;
        $vehicule->save();


        $vidange =  new Vidange;
        $vidange->car_id            =   $vehicule->id;
        $vidange->current_km        =   intval(str_replace('.','',$request->km_actuel));
        $vidange->next_km_for_drain =   intval(str_replace('.','',$request->km_actuel)) + intval($request->threshold_vidange);
        $vidange->threshold_km      =   intval(str_replace('.','',$request->threshold_vidange));
        $vidange->save();


        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $vehicule->id;
        $timingChaine->current_km   =   intval(str_replace('.','',$request->km_actuel));
        $timingChaine->next_km_for_change   =   intval(str_replace('.','',$request->km_actuel)) + intval(str_replace('.','',$request->threshold_timing_chaine));
        $timingChaine->threshold_km     =   intval(str_replace('.','',$request->threshold_timing_chaine));
        $timingChaine->save();



        Alert::success('Vehicule Saved Successfully', 'Please fill tires field');
        return redirect(route('admin.tire.create', $vehicule->id));
    }
}
