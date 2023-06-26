<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Vehicule;
use App\Models\Driver;
use App\Models\Trip;
use Alert;
use Crypt;

class TripController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::latest()->get();
        $drivers   = Driver::latest()->get();


        $trips = Trip::with('driver', 'vehicule')->get();

        return view('admin.trip.index', [
                'drivers'   =>  $drivers,
                'vehicules' =>  $vehicules,
                'trips'      =>  $trips
            ]);
    }


    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $trip = Trip::with('driver', 'vehicule')->findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }
        $vehicules = Vehicule::latest()->get();
        $drivers   = Driver::latest()->get();

        return view('admin.trip.edit', [
            'trip'  =>   $trip,
            'drivers'   =>  $drivers,
            'vehicules' =>  $vehicules,
        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'vehicule'    =>  'required|not_in:0',
            'driver'      =>  'required|not_in:0',
            'start_date'  =>  'required',
            'end_date'    =>  'nullable'
        ]);

        $driver = Driver::with('permis')->find($request->driver);
        $vehicule = Vehicule::join('categorie_permis', 'vehicules.permis_id','=','categorie_permis.id')->find($request->vehicule);



        if(!$driver->permis->pluck('id')->contains($vehicule->permis_id))
        {
            Alert::error('Error', 'Driver Should have: Permis '.$vehicule->label);
            return back();
        }

        $trip = new Trip;
        $trip->driver_id    =   $request->driver;
        $trip->vehicule_id  =   $request->vehicule;
        $trip->permanent    =   isset($request->trip_type) ? 1 : 0;
        $trip->start        =   $request->start_date;
        $trip->end          =   isset($request->end_date) ? $request->end_date : null;
        $trip->save();


        Alert::success('Success', 'Saved Correctly');
        return back();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'vehicule'    =>  'required|not_in:0',
            'driver'      =>  'required|not_in:0',
            'start_date'  =>  'required',
            'end_date'    =>  'nullable'
        ]);

        $driver = Driver::with('permis')->find($request->driver);
        $vehicule = Vehicule::join('categorie_permis', 'vehicules.permis_id','=','categorie_permis.id')->find($request->vehicule);



        if(!$driver->permis->pluck('id')->contains($vehicule->permis_id))
        {
            Alert::error('Error', 'Driver Should have: Permis '.$vehicule->label);
            return back();
        }

        try {
            $id = Crypt::decrypt($id);
            $trip = Trip::findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }



        $trip->driver_id    =   $request->driver;
        $trip->vehicule_id  =   $request->vehicule;
        $trip->permanent    =   isset($request->trip_type) ? 1 : 0;
        $trip->start        =   $request->start_date;

        if(isset($request->trip_type))
        {
            $trip->end = null;
        }else{
            $trip->end          =   $request->end_date;
        }
        $trip->save();

        Alert::success('Success', 'Saved Correctly');
        return back();
    }




}
