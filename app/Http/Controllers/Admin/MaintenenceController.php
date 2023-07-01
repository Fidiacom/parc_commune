<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenence;
use App\Models\Vehicule;
use App\Models\Stock;
use Crypt;

class MaintenenceController extends Controller
{

    public function create($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $vehicule = Vehicule::findOrFail($id);
            $stocks = Stock::with('unitie')->get();

        } catch (\Throwable $th) {
            //throw $th;
        }

        return view('admin.maintenence.create', [
            'vehicule'  =>  $vehicule,
            'stocks'     =>  $stocks
        ]);
    }


    public function store(Request $request)
    {
        dd($request->all());
    }
}
