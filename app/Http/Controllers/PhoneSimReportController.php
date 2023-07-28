<?php

namespace App\Http\Controllers;

use App\Exports\PhoneSimReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PhoneSimReportController extends Controller
{
    public function index(){

        return view('inventory.phone-sim-report');
    }

    public function generate(Request $request){
        $formInput = $request->only(['item']);

        return Excel::download(new PhoneSimReport($formInput), 'filename.xlsx');

    }
}
