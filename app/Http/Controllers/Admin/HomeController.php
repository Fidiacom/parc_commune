<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vehicule;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\StockHistorique;

class HomeController extends Controller
{
    public function index()
    {
        $vehiculesCount = Vehicule::count();
        $driverCount = Driver::count();
        $tripCount = Trip::count();
        $stockHistoriqueCount = StockHistorique::count();



        $vehicules = Vehicule::latest()->get();
        $historiques =   StockHistorique::with('stock')->leftjoin('vehicules', 'vehicules.id', '=','stock_historiques.vehicule_id')->latest()->get(['stock_historiques.*', 'vehicules.brand','vehicules.model','vehicules.matricule']);



        return view('dashboard', [
            'vehiculesCount'    =>  $vehiculesCount,
            'driverCount'       =>  $driverCount,
            'tripCount'         =>  $tripCount,
            'vehicules'         =>  $vehicules,
            'historiques'       =>  $historiques,
            'stockHistoriqueCount'  =>  $stockHistoriqueCount
        ]);
    }
}
