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
use App\Models\Attachment;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;





class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::withCount('attachments')->latest()->get();

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
            'technical_visit_expiration'    =>  'nullable|date',
            'numOfTires'                    =>  'required',
            'circulation_date'              =>  'nullable|date',
            'images.*'                      =>  'nullable|image|max:5120', // 5MB max per image
            'files.*'                       =>  'nullable|file|max:10240', // 10MB max per file

        ]);


        $vehicule                   =   new Vehicule;
        $vehicule->brand            =   $request->brand;
        
        // Handle multiple images - store first one as main image
        if ($request->hasFile('images') && count($request->file('images')) > 0) {
            $firstImage = $request->file('images')[0];
            $vehicule->image = uploadFile($firstImage, 'vehicules');
        } else {
            $vehicule->image = null;
        }
        $vehicule->model            =   $request->model;
        $vehicule->matricule        =   $request->matricule;
        $vehicule->num_chassis      =   $request->chassis;
        $vehicule->circulation_date =   $request->circulation_date;
        $vehicule->total_km         =   intval(str_replace('.','',$request->km_actuel));
        $vehicule->horses           =   intval(str_replace('.','',$request->horses));
        $vehicule->fuel_type        =   $request->fuel_type;
        $vehicule->airbag           =   isset($request->airbag) ? 1 : 0;
        $vehicule->abs              =   isset($request->abs) ? 1 : 0;
        $vehicule->permis_id        =   $request->category;
        $vehicule->inssurance_expiration              =   $request->inssurance_expiration;
        $vehicule->technicalvisite_expiration         =   $request->technical_visit_expiration ?? null;
        $vehicule->number_of_tires         =   $request->numOfTires;
        $vehicule->tire_size               =   $request->tire_size;
        $vehicule->save();

        // Handle multiple images - store all as attachments
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filePath = uploadFile($image, 'vehicules/attachments');
                
                $attachment = new Attachment();
                $attachment->file_path = $filePath;
                $vehicule->attachments()->save($attachment);
            }
        }

        // Handle other file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = uploadFile($file, 'vehicules/attachments');
                
                $attachment = new Attachment();
                $attachment->file_path = $filePath;
                $vehicule->attachments()->save($attachment);
            }
        }

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
            $vehicule = Vehicule::with('vidange', 'timing_chaine', 'attachments')->findOrFail($id);
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
            'technical_visit_expiration'    =>  'nullable|date',
            'numOfTires'                    =>  'required',
            'circulation_date'              =>  'nullable|date',
            'images.*'                      =>  'nullable|image|max:5120', // 5MB max per image
        ]);


        try {

            $id = Crypt::decrypt($request->vehicule_id);
            $vehicule                   =   Vehicule::findOrFail($id);
        } catch (\Throwable $th) {
            return view('admin.vehicule.404');
        }


        $vehicule->brand            =   $request->brand;
        
        // Handle multiple images - update main image if new images are uploaded
        if ($request->hasFile('images') && count($request->file('images')) > 0) {
            $firstImage = $request->file('images')[0];
            $vehicule->image = uploadFile($firstImage, 'vehicules');
        }
        // Keep existing image if no new images uploaded
        $vehicule->model            =   $request->model;
        $vehicule->matricule        =   $request->matricule;
        $vehicule->num_chassis      =   $request->chassis;
        $vehicule->circulation_date =   $request->circulation_date;
        $vehicule->total_km         =   intval(str_replace('.','',$request->km_actuel));
        $vehicule->horses           =   intval(str_replace('.','',$request->horses));
        $vehicule->fuel_type        =   $request->fuel_type;
        $vehicule->airbag           =   isset($request->airbag) ? 1 : 0;
        $vehicule->abs              =   isset($request->abs) ? 1 : 0;
        $vehicule->inssurance_expiration              =   $request->inssurance_expiration;
        $vehicule->technicalvisite_expiration         =   $request->technical_visit_expiration ?? null;
        $vehicule->number_of_tires         =   $request->numOfTires;
        $vehicule->tire_size               =   $request->tire_size;
        $vehicule->save();

        // Handle multiple images - store all as attachments
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filePath = uploadFile($image, 'vehicules/attachments');
                
                $attachment = new Attachment();
                $attachment->file_path = $filePath;
                $vehicule->attachments()->save($attachment);
            }
        }

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

        $historiquePneu = pneu::where('pneus.car_id', '=', $vehicule->getId())
                ->rightJoin('pneu_historiques', 'pneus.id', '=', 'pneu_historiques.pneu_id')
                ->latest()
                ->get(['pneus.tire_position', 'pneu_historiques.current_km', 'pneu_historiques.next_km_for_change', 'pneu_historiques.created_at']);
        //dd($historique);

        return view('admin.vehicule.dtt', ['vehicule' => $vehicule, 'historiquePneu'    =>  $historiquePneu]);
    }

    public function uploadFiles(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required',
            'files.*' => 'required|file|max:10240', // 10MB max per file
        ]);

        try {
            $id = Crypt::decrypt($request->vehicule_id);
            $vehicule = Vehicule::findOrFail($id);
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid vehicle ID');
            return back();
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = uploadFile($file, 'vehicules/attachments');
                
                $attachment = new Attachment();
                $attachment->file_path = $filePath;
                $vehicule->attachments()->save($attachment);
            }
        }

        Alert::success('Success', 'Files uploaded successfully');
        return back();
    }

    public function deleteFile($id)
    {
        try {
            $attachmentId = Crypt::decrypt($id);
            $attachment = Attachment::findOrFail($attachmentId);
            
            // Delete physical file
            $filePath = str_replace('storage/', 'public/', $attachment->getFilePath());
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            
            $attachment->delete();
            
            Alert::success('Success', 'File deleted successfully');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Failed to delete file');
        }
        
        return back();
    }
}
