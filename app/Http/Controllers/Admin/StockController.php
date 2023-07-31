<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unitie;
use App\Models\StockHistorique;
use App\Models\Stock;
use Alert;
use Crypt;

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
            $stockHostorique->type      =   'entre';
            $stockHostorique->quantite  =   $request->stockActuel;
            $stockHostorique->save();


            Alert::success('Saved', 'Saved');
            return back();
        } catch (\Throwable $th) {
            //throw $th;
            dd('erro', $th);
        }
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'nameUpdate'          =>  'required',
            'stock_actuelUpdate'   =>  'required',
            'min_stock_alertUpdate'         =>  'required',
            'unitieUpdate'        =>  'required|not_in:0|exists:unities,id',
        ]);

        $isStockChanged = false;
        try {
            $id = Crypt::decrypt($id);
            $stock = Stock::findOrfail($id);
            $stock->name  = $request->nameUpdate;
            $stock->min_stock_alert  = $request->min_stock_alertUpdate;
            $stock->unitie_id  = $request->unitieUpdate;

            $stock->update();


            Alert::success('Saved', 'Saved');
            return back();
        } catch (\Throwable $th) {
            //throw $th;
            dd('error', $th, $request->all());
        }

    }

    public function create_stock()
    {
        $stockNames = Stock::get(['name', 'id']);

        return view('admin.stock.stock_entry', [
            'stockNames'    =>  $stockNames
        ]);
    }

    public function destroy(Request $request)
    {

        try {
            $stock = Stock::findOrFail($request->stockId);
            $stock->delete();

            Alert::success('Deleted', 'Deleted');
            return back();
        } catch (\Throwable $th) {
            //throw $th;
            dd('error');
        }
    }

}
