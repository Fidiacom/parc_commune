<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenence;
use App\Models\Vehicule;
use App\Models\Stock;
use App\Models\StockHistorique;
use Crypt;
use Alert;
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
        
        $validated = $request->validate([
            'stock' => 'required|not_in:0',
            'qte'   =>  'required',
            'vehicule_id'   =>  'required'
        ]);


        $stockJson = json_decode($request->stock);
        //dd($stockJson->id, $request->qte);
        try {
            $stock = Stock::findOrFail($stockJson->id);
            $stock->stock_actuel = $stock->stock_actuel - floatval($request->qte);
            $stock->update();


            $stockHostorique = new StockHistorique;
            $stockHostorique->stock_id      =   $stock->id;
            $stockHostorique->type          =   'sortie';
            $stockHostorique->quantite      =   $request->qte;
            $stockHostorique->vehicule_id   =   $request->vehicule_id;
            $stockHostorique->document      =   $request->vignette ? uploadFile($request->vignette, 'vignette') : null;
            $stockHostorique->suppliername  =   $request->suppliername;
            $stockHostorique->save();

        } catch (\Throwable $th) {
            //throw $th;
        }


        Alert::success('Saved', 'Saved');
        return redirect(route('admin.vehicule.edit', $request->vehicule_id));
    }
}
