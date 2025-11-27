<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Vehicule;
use App\Models\Driver;
use App\Models\MissionOrder;
use App\Services\SettingService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;

class MissionOrderController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::latest()->get();
        $drivers   = Driver::latest()->get();


        $missionOrders = MissionOrder::with('driver', 'vehicule')->get();

        return view('admin.mission_order.index', [
                'drivers'   =>  $drivers,
                'vehicules' =>  $vehicules,
                'missionOrders'      =>  $missionOrders
            ]);
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $missionOrder = MissionOrder::with('driver', 'vehicule')->findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }
        $vehicules = Vehicule::latest()->get();
        $drivers   = Driver::latest()->get();

        return view('admin.mission_order.edit', [
            'missionOrder'  =>   $missionOrder,
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

        $missionOrder = new MissionOrder;
        $missionOrder->driver_id    =   $request->driver;
        $missionOrder->vehicule_id  =   $request->vehicule;
        $missionOrder->permanent    =   isset($request->mission_order_type) ? 1 : 0;
        $missionOrder->start        =   $request->start_date;
        $missionOrder->end          =   isset($request->end_date) ? $request->end_date : null;
        $missionOrder->save();


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
            $missionOrder = MissionOrder::findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }



        $missionOrder->driver_id    =   $request->driver;
        $missionOrder->vehicule_id  =   $request->vehicule;
        $missionOrder->permanent    =   isset($request->mission_order_type) ? 1 : 0;
        $missionOrder->start        =   $request->start_date;

        if(isset($request->mission_order_type))
        {
            $missionOrder->end = null;
        }else{
            $missionOrder->end          =   $request->end_date;
        }
        $missionOrder->save();

        Alert::success('Success', 'Saved Correctly');
        return back();
    }

    public function destroy($id)
    {
        $missionOrder = MissionOrder::findOrFail($id);
        $missionOrder->delete();
        Alert::success('Success', 'Deleted');
        return redirect(route('admin.mission_order'));
    }

    public function returnFromMissionOrder(Request $request, $id)
    {
        $validated = $request->validate([
            'return_date'    =>  'required',
            'actual_km'      =>  'required',
        ]);

        $missionOrder = MissionOrder::findOrFail($id);
        $missionOrder->done_at = $request->return_date;
        $missionOrder->update();


        $vehicule = Vehicule::findOrFail($missionOrder->vehicule_id);
        $vehicule->total_km = $request->actual_km;
        $vehicule->update();

        Alert::success('Success', 'Saved Correctly');
        return back();
    }

    public function print($id)
    {
        try {
            $missionOrder = MissionOrder::with('driver', 'vehicule')->findOrFail($id);
        } catch (\Throwable $th) {
            Alert::error('Error', 'Mission order not found');
            return back();
        }

        $settingService = app(SettingService::class);
        $settings = $settingService->getSettings();
        
        $pdf = Pdf::loadView('admin.mission_order.print', [
            'missionOrder' => $missionOrder,
            'settings' => $settings
        ]);
        
        return $pdf->stream('order_de_mission_' . $missionOrder->id . '.pdf');
    }
}

