<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unitie;
use App\Models\StockHistorique;
use App\Models\Stock;
use Alert;

class StockController extends Controller
{
    public function index()
    {
        $unities = Unitie::all();
        $stocks = Stock::with('unitie')->latest()->get();
        
        return view('admin.stock.index', [
                'unities' => $unities,
                'stocks'  =>  $stocks
            ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          =>  'required',
            'alert'         =>  'required',
            'stockActuel'   =>  'required',
            'unitie'        =>  'required|not_in:0|exists:unities,id',
        ]);


        try {
            //code...
            $stock = new Stock;
            $stock->name  = $request->name;
            $stock->min_stock_alert  = $request->alert;
            $stock->stock_actuel  = $request->stockActuel;
            $stock->unitie_id  = $request->unitie;
            $stock->save();

            $stockHostorique = new StockHistorique;
            $stockHostorique->stock_id  =   $stock->id;
            $stockHostorique->type      =   'sortie';
            $stockHostorique->quantite  =   $request->stockActuel;
            $stockHostorique->save();


            Alert::success('Saved', 'Saved');
            return back();
        } catch (\Throwable $th) {
            //throw $th;
            dd('erro', $th);
        }
    }
}
