<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Vehicule;
use App\Models\Driver;

class TripController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::latest()->get();
        $drivers   = Driver::latest()->get();


        return view('admin.trip.index', ['drivers'   =>  $drivers, 'vehicules'   =>  $vehicules]);
    }


    public function create()
    {
        return view('admin.trip.create');
    }

    public function store(Request $request)
    {
        dump($request->all());



        $start = trim(explode('-', $request->dateRange)[0]);
        $start = Carbon::createFromFormat('d/m/Y', $start)->format('Y-m-d');

        $end = trim(explode('-', $request->dateRange)[1]);
        $end = Carbon::createFromFormat('d/m/Y', $end)->format('Y-m-d');
        dd($start, $end);
    }
}
