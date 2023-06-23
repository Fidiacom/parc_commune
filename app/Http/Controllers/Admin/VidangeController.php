<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vidange;
use Crypt;
use Alert;

class VidangeController extends Controller
{
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'threshold_km'  =>  'required'
        ]);

        try {
            $id = Crypt::decrypt($id);
            $vidange = Vidange::findOrFail($id);
            $vidange->threshold_km = $request->threshold_km;
            $vidange->update();
        } catch (\Throwable $th) {
            throw $th;
        }



        Alert::success('Vehicule Saved Successfully', 'Please fill tires field');
        return back();
    }
}
