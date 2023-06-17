<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicule;
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
            'pneu_ag'                       =>  'required',
            'pneu_dg'                       =>  'required',
            'pneu_ad'                       =>  'required',
            'pneu_dd'                       =>  'required',
        ]);

        Alert::success('Congrats', 'You\'ve Successfully Registered');
        return redirect()->back();
        dd($request->all(), isset($request->abs));

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
    }
}
