<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicule;

use App\Models\Vidange;
use App\Models\VidangeHistorique;

use App\Models\pneu;

use App\Models\TimingChaine;
use App\Models\TimingChaineHistorique;

use App\Models\CategoriePermi;
use Alert;
use Crypt;





class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::latest()->get();

        return view('admin.vehicule.index', ['vehicules' => $vehicules]);
    }

    public function create()
    {
        $categories = CategoriePermi::all();
        return view('admin.vehicule.create', ['categories'  =>  $categories]);
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'brand'                         =>  'required',
            'model'                         =>  'required',
            'matricule'                     =>  'required',
            'chassis'                       =>  'required',
            'km_actuel'                     =>  'required',
            'horses'                        =>  'required',
            'fuel_type'                     =>  'required|not_in:0',
            'category'                      =>  'required|not_in:0',
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
        $vehicule->permis_id        =   $request->category;
        $vehicule->inssurance_expiration              =   $request->inssurance_expiration;
        $vehicule->technicalvisite_expiration         =   $request->technical_visit_expiration;
        $vehicule->number_of_tires         =   $request->numOfTires;
        $vehicule->save();


        $vidange =  new Vidange;
        $vidange->car_id            =   $vehicule->id;
        $vidange->threshold_km      =   intval(str_replace('.','',$request->threshold_vidange));
        $vidange->save();

        // Historique_Vidange
        $vidange_histrorique    =   new VidangeHistorique;
        $vidange_histrorique->vidange_id    =   $vidange->id;
        $vidange_histrorique->current_km    =   intval(str_replace('.','',$request->km_actuel));
        $vidange_histrorique->next_km_for_drain =   intval(str_replace('.','',$request->km_actuel)) + intval($request->threshold_vidange);
        $vidange_histrorique->save();




        $timingChaine = new TimingChaine;
        $timingChaine->car_id   =   $vehicule->id;

        $timingChaine->threshold_km     =   intval(str_replace('.','',$request->threshold_timing_chaine));
        $timingChaine->save();

        // Historique Timing Chaine
        $timingChaine_historique = new TimingChaineHistorique;
        $timingChaine_historique->chaine_id     =   $timingChaine->id;
        $timingChaine_historique->current_km    =   intval(str_replace('.','',$request->km_actuel));
        $timingChaine_historique->next_km_for_change    =   intval(str_replace('.','',$request->km_actuel)) + intval(str_replace('.','',$request->threshold_timing_chaine));;
        $timingChaine_historique->save();



        Alert::success('Vehicule Saved Successfully', 'Please fill tires field');
        return redirect(route('admin.tire.create', $vehicule->id));
    }

    public function edit($id)
    {
        try {
            $vehicule = Vehicule::with('vidange', 'timing_chaine')->findOrFail($id);
        } catch (\Throwable $th) {
            return view('admin.vehicule.404');
        }

        return view('admin.vehicule.edit', [ 'vehicule' =>  $vehicule]);
    }


    public function update(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'brand'                         =>  'required',
            'model'                         =>  'required',
            'matricule'                     =>  'required',
            'chassis'                       =>  'required',
            'km_actuel'                     =>  'required',
            'horses'                        =>  'required',
            'fuel_type'                     =>  'required|not_in:0',
            'inssurance_expiration'         =>  'required',
            'technical_visit_expiration'    =>  'required',
            'numOfTires'                    =>  'required',
        ]);


        try {

            $id = Crypt::decrypt($request->vehicule_id);
            $vehicule                   =   Vehicule::findOrFail($id);
        } catch (\Throwable $th) {
            return view('admin.vehicule.404');
        }


        $vehicule->brand            =   $request->brand;
        $vehicule->image            =   isset($request->image) ? uploadFile($request->image, 'vehicules') : $vehicule->image;
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

        Alert::success('Vehicule Saved Successfully', 'updated');
        return back();

    }

    public function dtt_get($vehicule_id)
    {

        try {
            $id = Crypt::decrypt($vehicule_id);
            $vehicule = Vehicule::with('vidange.vidange_historique', 'timing_chaine.timingchaine_historique', 'pneu.pneu_historique')->findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }

        $historiquePneu = pneu::where('pneus.car_id', '=', $vehicule->id)
                ->rightJoin('pneu_historiques', 'pneus.id', '=', 'pneu_historiques.pneu_id')
                ->latest()
                ->get(['pneus.tire_position', 'pneu_historiques.current_km', 'pneu_historiques.next_km_for_change', 'pneu_historiques.created_at']);
        //dd($historique);

        return view('admin.vehicule.dtt', ['vehicule' => $vehicule, 'historiquePneu'    =>  $historiquePneu]);
    }
}
