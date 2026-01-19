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
use App\Services\DriverService;
use App\Services\VehiculeService;
use App\Services\MissionOrderService;
use App\Services\MissionCompanionService;
class MissionOrderController extends Controller
{
    protected DriverService $driverService;
    protected VehiculeService $vehiculeService;
    protected MissionOrderService $missionOrderService;
    protected SettingService $settingService;
    protected MissionCompanionService $missionCompanionService;
    
    public function __construct(DriverService $driverService, VehiculeService $vehiculeService, MissionOrderService $missionOrderService, SettingService $settingService, MissionCompanionService $missionCompanionService)
    {
        $this->driverService = $driverService;
        $this->vehiculeService = $vehiculeService;
        $this->missionOrderService = $missionOrderService;
        $this->settingService = $settingService;
        $this->missionCompanionService = $missionCompanionService;
    }

    public function index()
    {
        $missionOrders = $this->missionOrderService->getAllMissionOrders();

        return view('admin.mission_order.index', [
                'missionOrders' => $missionOrders
            ]);
    }

    public function create(Request $request)
    {
        $vehicules = $this->vehiculeService->getAllVehicules();
        $drivers   = $this->driverService->getAllDrivers();
        $companions = $this->missionCompanionService->getAllMissionCompanions();

        // Get pre-filled values from query parameters
        $selectedDriverId = $request->query('driver_id');
        $selectedStartDate = $request->query('start_date');
        $selectedEndDate = $request->query('end_date');

        return view('admin.mission_order.create', [
            'drivers'   => $drivers,
            'vehicules' => $vehicules,
            'companions' => $companions,
            'selectedDriverId' => $selectedDriverId,
            'selectedStartDate' => $selectedStartDate,
            'selectedEndDate' => $selectedEndDate,
        ]);
    }

    public function edit($id)
    {
        try {
            $missionOrder = $this->missionOrderService->getMissionOrderById($id, ['driver', 'vehicule', 'companions']);
            
            if (!$missionOrder) {
                Alert::error('Error', 'Mission order not found');
                return redirect(route('admin.mission_order'));
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid mission order ID');
            return redirect(route('admin.mission_order'));
        }
        
        $vehicules = $this->vehiculeService->getAllVehicules();
        $drivers   = $this->driverService->getAllDrivers();
        $companions = $this->missionCompanionService->getAllMissionCompanions();

        return view('admin.mission_order.edit', [
            'missionOrder'  =>   $missionOrder,
            'drivers'   =>  $drivers,
            'vehicules' =>  $vehicules,
            'companions' => $companions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicule'              =>  'required|not_in:0',
            'driver'                =>  'required|not_in:0',
            'start_date'            =>  'required',
            'end_date'              =>  'nullable',
            'mission_fr'            =>  'nullable|string',
            'mission_ar'            =>  'nullable|string',
            'registration_datetime' =>  'nullable|date',
            'place_togo_fr'         =>  'nullable|string',
            'place_togo_ar'         =>  'nullable|string',
            'companions'            =>  'nullable|array',
            'companions.*'          =>  'exists:mission_companions,id',
        ]);

        try {
            $this->missionOrderService->createMissionOrder($request);
            Alert::success('Success', 'Saved Correctly');
            return redirect()->route('admin.mission_order');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
        }

        return back();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'vehicule'              =>  'required|not_in:0',
            'driver'                =>  'required|not_in:0',
            'start_date'            =>  'required',
            'end_date'              =>  'nullable',
            'mission_fr'            =>  'nullable|string',
            'mission_ar'            =>  'nullable|string',
            'registration_datetime' =>  'nullable|date',
            'place_togo_fr'         =>  'nullable|string',
            'place_togo_ar'         =>  'nullable|string',
            'companions'            =>  'nullable|array',
            'companions.*'          =>  'exists:mission_companions,id',
        ]);

        try {
            $missionOrder = $this->missionOrderService->getMissionOrderById($id);
            
            if (!$missionOrder) {
                Alert::error('Error', 'Mission order not found');
                return back();
            }

            $this->missionOrderService->updateMissionOrder($missionOrder, $request);
            Alert::success('Success', 'Saved Correctly');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid mission order ID');
        }

        return back();
    }

    public function destroy($id)
    {
        try {
            $missionOrder = $this->missionOrderService->getMissionOrderById($id);
            
            if (!$missionOrder) {
                Alert::error('Error', 'Mission order not found');
                return redirect(route('admin.mission_order'));
            }

            $this->missionOrderService->deleteMissionOrder($missionOrder);
            Alert::success('Success', 'Deleted');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid mission order ID');
        }

        return redirect(route('admin.mission_order'));
    }

    public function returnFromMissionOrder(Request $request, $id)
    {
        $validated = $request->validate([
            'return_date'    =>  'required',
            'actual_km'      =>  'required',
        ]);

        try {
            $missionOrder = $this->missionOrderService->getMissionOrderById($id);
            
            if (!$missionOrder) {
                Alert::error('Error', 'Mission order not found');
                return back();
            }

            $this->missionOrderService->returnFromMissionOrder($missionOrder, $request);
            Alert::success('Success', 'Saved Correctly');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
        }

        return back();
    }

    public function print(Request $request, $id)
    {
        try {
            $printData = $this->missionOrderService->getPrintableMissionOrder(
                $id,
                (string) $request->query('person_type', 'driver'),
                $request->filled('person_id') ? (int) $request->query('person_id') : null
            );

            $missionOrder = $printData['missionOrder'];
            $subject = $printData['subject'];

            if (!$missionOrder || !$subject) {
                Alert::error('Error', 'Mission order not found');
                return back();
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Mission order not found');
            return back();
        }

        $settings = $this->settingService->getSettings();
        $pdf = $this->missionOrderService->generateMissionOrderPdf($missionOrder, $subject, $settings);

        return response()->make($pdf['content'], 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $pdf['filename'] . '"',
        ]);
    }
}

