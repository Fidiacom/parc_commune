<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\CategoriePermi;
use App\Services\DriverService;
use RealRashid\SweetAlert\Facades\Alert;

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
            $driver = $this->driverService->getDriverById($id);
            
            if (!$driver) {
                Alert::error('Error', 'Driver not found');
                return redirect(route('admin.drivers'));
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid driver ID');
            return redirect(route('admin.drivers'));
        }

        return view('admin.drivers.edit', ['driver' => $driver, 'permis' => $permis]);
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
}
