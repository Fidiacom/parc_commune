<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockHistorique;
use App\Models\Stock;
use Alert;

class HistoriqueStockController extends Controller
{
    public function index()
    {
        $historiques =   StockHistorique::with('stock')->leftjoin('vehicules', 'vehicules.id', '=','stock_historiques.vehicule_id')->latest()->get(['stock_historiques.*', 'vehicules.brand','vehicules.model','vehicules.matricule']);
        //dd($historiques);
        return view('admin.stock.historique', ['historiques' => $historiques]);
    }

    public function store(Request $request)
    {


        $validator = $request->validate([
            'stock_id'      =>  'required|exists:stocks,id',
            'qte_entree'    =>  'required|numeric',
            'supplier_name' =>  'required',
        ]);

        $stock = Stock::findOrFail($request->stock_id);
        $stock->stock_actuel = $stock->stock_actuel + $request->qte_entree;
        $stock->update();

        $historiques = new StockHistorique;
        $historiques->stock_id      =   $request->stock_id;
        $historiques->type          =   'Entry';
        $historiques->quantite      =   $request->qte_entree;
        $historiques->suppliername  =   $request->supplier_name;
        $historiques->document      =   $request->document ? uploadFile($request->document, 'AchatPiece') : null;
        $historiques->save();

        Alert::success('Saved', 'Saved');
        return redirect()->back();
    }
}
