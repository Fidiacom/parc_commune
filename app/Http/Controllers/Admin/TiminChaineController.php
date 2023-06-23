<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimingChaine;
use Crypt;
use Alert;

class TiminChaineController extends Controller
{
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'threshold_km'  =>  'required'
        ]);


        try {
            $id = Crypt::decrypt($id);
            $timingChaine = TimingChaine::findOrFail($id);
            $timingChaine->threshold_km = $request->threshold_km;
            $timingChaine->update();
        } catch (\Throwable $th) {
            throw $th;
        }


        Alert::success('Vehicule Saved Successfully', 'Please fill tires field');
        return back();
    }
}
