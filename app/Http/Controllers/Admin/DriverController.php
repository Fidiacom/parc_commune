<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\CategoriePermi;
use App\Services\DriverService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    protected DriverService $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    public function index()
    {
        $drivers = $this->driverService->getAllDrivers();
        return view('admin.drivers.index', ['drivers' => $drivers]);
    }

    public function create()
    {
        $permis = CategoriePermi::all();
        return view('admin.drivers.create', ['permis' => $permis]);
    }

    public function store(StoreDriverRequest $request)
    {
        $this->driverService->createDriver($request);

        Alert::success('Driver Saved Successfully', 'Please fill tires field');
        return redirect(route('admin.drivers'));
    }

    public function edit($id)
    {
        $permis = CategoriePermi::all();

        try {
            $driver = $this->driverService->getDriverById($id, ['permis', 'missionOrders']);
            
            if (!$driver) {
                Alert::error('Error', 'Driver not found');
                return redirect(route('admin.drivers'));
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid driver ID');
            return redirect(route('admin.drivers'));
        }

        // Get active mission orders (not completed)
        $activeMissionOrders = \App\Models\MissionOrder::where('driver_id', $driver->getId())
            ->whereNull('done_at')
            ->with('vehicule')
            ->orderBy('start', 'asc')
            ->get();

        // Get upcoming mission orders (future dates)
        $upcomingMissionOrders = \App\Models\MissionOrder::where('driver_id', $driver->getId())
            ->whereNull('done_at')
            ->where('start', '>=', now()->toDateString())
            ->with('vehicule')
            ->orderBy('start', 'asc')
            ->get();

        return view('admin.drivers.edit', [
            'driver' => $driver, 
            'permis' => $permis,
            'activeMissionOrders' => $activeMissionOrders,
            'upcomingMissionOrders' => $upcomingMissionOrders,
        ]);
    }

    public function update(UpdateDriverRequest $request, $id)
    {
        try {
            $driver = $this->driverService->getDriverById($id);
            
            if (!$driver) {
                Alert::error('Error', 'Driver not found');
                return redirect(route('admin.drivers'));
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid driver ID');
            return redirect(route('admin.drivers'));
        }

        $this->driverService->updateDriver($driver, $request);

        Alert::success('Driver Saved Successfully', 'Please fill tires field');
        return redirect(route('admin.drivers'));
    }

    public function destroy($id)
    {
        try {
            $driver = $this->driverService->getDriverById($id);
            
            if (!$driver) {
                Alert::error('Error', 'Driver not found');
                return redirect(route('admin.drivers'));
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid driver ID');
            return redirect(route('admin.drivers'));
        }

        $this->driverService->deleteDriver($driver);

        Alert::success('Driver Deleted Successfully', 'The driver has been soft deleted');
        return redirect(route('admin.drivers'));
    }

    public function dashboard($id)
    {
        try {
            $driver = $this->driverService->getDriverById($id);
            
            if (!$driver) {
                Alert::error('Error', 'Driver not found');
                return redirect(route('admin.drivers'));
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid driver ID');
            return redirect(route('admin.drivers'));
        }

        // Get all mission orders for this driver
        $allMissionOrders = \App\Models\MissionOrder::where('driver_id', $driver->getId())
            ->with('vehicule')
            ->latest()
            ->get();

        // Get active mission orders
        $activeMissionOrders = $allMissionOrders->whereNull('done_at');

        // Get completed mission orders
        $completedMissionOrders = $allMissionOrders->whereNotNull('done_at')->take(10);

        // Get statistics
        $totalMissions = $allMissionOrders->count();
        $activeMissionsCount = $activeMissionOrders->count();
        $completedMissionsCount = $allMissionOrders->whereNotNull('done_at')->count();

        // Get vehicles used by this driver
        $vehiclesUsed = $allMissionOrders->pluck('vehicule')->unique('id')->filter();

        // Get recent activity (last 10 mission orders)
        $recentMissionOrders = $allMissionOrders->take(10);

        return view('admin.drivers.dashboard', [
            'driver' => $driver,
            'allMissionOrders' => $allMissionOrders,
            'activeMissionOrders' => $activeMissionOrders,
            'completedMissionOrders' => $completedMissionOrders,
            'totalMissions' => $totalMissions,
            'activeMissionsCount' => $activeMissionsCount,
            'completedMissionsCount' => $completedMissionsCount,
            'vehiclesUsed' => $vehiclesUsed,
            'recentMissionOrders' => $recentMissionOrders,
        ]);
    }

    /**
     * Show availability check page.
     */
    public function checkAvailability()
    {
        return view('admin.drivers.check_availability');
    }

    /**
     * Get available drivers for a given period.
     */
    public function getAvailableDrivers(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $availableDrivers = $this->driverService->getAvailableDrivers(
            $request->start_date,
            $request->end_date
        );

        return response()->json([
            'success' => true,
            'drivers' => $availableDrivers->map(function ($driver) {
                return [
                    'id' => $driver->getId(),
                    'first_name_fr' => $driver->getFirstNameFr(),
                    'last_name_fr' => $driver->getLastNameFr(),
                    'first_name_ar' => $driver->getFirstNameAr(),
                    'last_name_ar' => $driver->getLastNameAr(),
                    'cin' => $driver->getCin(),
                    'phone' => $driver->getPhone(),
                    'role_fr' => $driver->getRoleFr(),
                    'role_ar' => $driver->getRoleAr(),
                ];
            }),
        ]);
    }
}
