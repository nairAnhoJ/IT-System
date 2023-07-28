<?php

namespace App\Http\Controllers;

use App\Exports\PhoneSimReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PhoneSimReportController extends Controller
{
    public function index(){
        $sites = DB::table('sites')->get();
        $departments = DB::table('departments')->where('id', '!=', 1)->get();

        return view('inventory.phone-sim-report', compact('sites', 'departments'));
    }

    public function generate(Request $request){
        $formInput = $request->only(['item', 'sites', 'departments']);

        return Excel::download(new PhoneSimReport($formInput), 'filename.xlsx');

    }
}
