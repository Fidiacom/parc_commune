<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockHistorique;

class HistoriqueStockController extends Controller
{
    public function index()
    {

        $historiques =   StockHistorique::with('stock')->leftjoin('vehicules', 'vehicules.id', '=','stock_historiques.vehicule_id')->latest()->get(['stock_historiques.*', 'vehicules.brand','vehicules.model','vehicules.matricule']);
        //dd($historiques);
        return view('admin.stock.historique', ['historiques' => $historiques]);
    }
}
