<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriePermi;
use App\Models\Driver;
use App\Models\DriverHasPermi;
use Illuminate\Http\Request;
use Alert;
use Crypt;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('permis')->latest()->get();
        return view('admin.drivers.index', ['drivers'   =>  $drivers]);
    }

    public function create()
    {
        $permis = CategoriePermi::all();
        return view('admin.drivers.create', ['permis'   =>  $permis]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'         =>  'nullable|image',
            'full_name'     =>  'required',
            'cin'           =>  'required',
            'permisType.*'  =>  'required',
            'permisType'    =>  'required',
            'phone'         =>  'required',
        ]);


        $driver = new Driver;
        $driver->image =   isset($request->image) ? uploadFile($request->image, 'drivers') : null;
        $driver->full_name  =   $request->full_name;
        $driver->cin    =   $request->cin;
        $driver->phone  =   $request->phone;
        $driver->save();

        foreach($request->permisType as $p)
        {
            $hasPermis = new DriverHasPermi;
            $hasPermis->driver_id   =   $driver->id;
            $hasPermis->permi_id    =   $p;
            $hasPermis->save();
        }

        Alert::success('Driver Saved Successfully', 'Please fill tires field');
        return redirect(route('admin.drivers'));


    }

    public function edit($id)
    {
        $permis = CategoriePermi::all();


        try {
            $id = Crypt::decrypt($id);
            $driver = Driver::with('permis')->findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }

        return view('admin.drivers.edit', ['driver' =>  $driver, 'permis'   =>  $permis]);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'image'         =>  'nullable|image',
            'full_name'     =>  'required',
            'cin'           =>  'required',
            'permisType.*'  =>  'required',
            'permisType'    =>  'required',
            'phone'         =>  'required',
        ]);

        try {
            //code...
            $id = Crypt::decrypt($id);
            $driver = Driver::findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }




        $driver->image =   isset($request->image) ? uploadFile($request->image, 'drivers') : $driver->image;
        $driver->full_name  =   $request->full_name;
        $driver->cin    =   $request->cin;
        $driver->phone  =   $request->phone;
        $driver->update();


        $driver->permis()->detach();
        $driver->permis()->attach($request->permisType);




        Alert::success('Driver Saved Successfully', 'Please fill tires field');
        return redirect(route('admin.drivers'));
    }
}
