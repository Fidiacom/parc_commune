<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        return view('admin.drivers.index');
    }

    public function create()
    {
        return view('admin.drivers.create');
    }
}
