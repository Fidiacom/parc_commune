<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            'threshold_vidange'             =>  'required',
            'threshold_timing_chaine'       =>  'required',
            'inssurance_expiration'         =>  'required',
            'technical_visit_expiration'    =>  'required',
            'pneu_ag'                       =>  'required',
            'pneu_dg'                       =>  'required',
            'pneu_ad'                       =>  'required',
            'pneu_dd'                       =>  'required',
        ]);


        

    }
}
