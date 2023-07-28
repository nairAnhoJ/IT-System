<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhoneSimReportController extends Controller
{
    public function index(){

        return view('inventory.phone-sim-report');
    }
}
