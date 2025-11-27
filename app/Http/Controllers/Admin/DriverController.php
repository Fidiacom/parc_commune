<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\CategoriePermi;
use App\Services\DriverService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;

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
            $id = Crypt::decrypt($id);
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
            $id = Crypt::decrypt($id);
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
            $id = Crypt::decrypt($id);
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
}
