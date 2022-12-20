<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeptInChargeController extends Controller
{
    public function update(Request $request){
        $newDept = $request->dept_id;
        DB::update('UPDATE dept_in_charges SET dept_id = ? WHERE id = 1', [$newDept]);
        DB::table('ticket_categories')->truncate();

        return redirect()->back();
    }
}
