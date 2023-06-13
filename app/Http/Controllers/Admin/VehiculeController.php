<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        dd('haha');
    }

    public function create()
    {
        return view('admin.vehicule.create');
    }
}
