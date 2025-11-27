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
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;
use App\Services\DriverService;
use App\Services\VehiculeService;
use App\Services\MissionOrderService;
class MissionOrderController extends Controller
{
    protected DriverService $driverService;
    protected VehiculeService $vehiculeService;
    protected MissionOrderService $missionOrderService;
    protected SettingService $settingService;
    
    public function __construct(DriverService $driverService, VehiculeService $vehiculeService, MissionOrderService $missionOrderService, SettingService $settingService)
    {
        $this->driverService = $driverService;
        $this->vehiculeService = $vehiculeService;
        $this->missionOrderService = $missionOrderService;
        $this->settingService = $settingService;
    }

    public function index()
    {
        $vehicules = $this->vehiculeService->getAllVehicules();
        $drivers   = $this->driverService->getAllDrivers();

        $missionOrders = $this->missionOrderService->getAllMissionOrders();

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
            $missionOrder = $this->missionOrderService->getMissionOrderById($id);
            
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

        return view('admin.mission_order.edit', [
            'missionOrder'  =>   $missionOrder,
            'drivers'   =>  $drivers,
            'vehicules' =>  $vehicules,
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
        ]);

        try {
            $this->missionOrderService->createMissionOrder($request);
            Alert::success('Success', 'Saved Correctly');
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
        ]);

        try {
            $id = Crypt::decrypt($id);
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
            $id = Crypt::decrypt($id);
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

    public function print($id)
    {
        try {
            $missionOrder = $this->missionOrderService->getMissionOrderById($id, ['driver', 'vehicule']);
            
            if (!$missionOrder) {
                Alert::error('Error', 'Mission order not found');
                return back();
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Mission order not found');
            return back();
        }

        $settings = $this->settingService->getSettings();
        
        // Determine which view to use
        $viewName = $missionOrder->isPermanent() 
            ? 'admin.mission_order.print_permanent' 
            : 'admin.mission_order.print_single';
        
        // Render the view to HTML
        $html = View::make($viewName, [
            'missionOrder' => $missionOrder,
            'settings' => $settings
        ])->render();
        
        // Configure mPDF for Arabic support
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 0,
            'margin_bottom' => 15,
            'margin_header' => 0,
            'margin_footer' => 9,
            'tempDir' => storage_path('app/temp'),
        ]);
        
        // Set default font for Arabic support
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        
        // Write HTML content
        $mpdf->WriteHTML($html);
        
        // Output the PDF as a response
        return response()->make($mpdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="order_de_mission_' . $missionOrder->getId() . '.pdf"',
        ]);
    }
}

