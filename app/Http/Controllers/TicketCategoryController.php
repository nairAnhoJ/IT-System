<?php

namespace App\Http\Controllers;

use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketCategoryController extends Controller
{
    public function index(){
        $inCharge = DB::table('dept_in_charges')->first();
        $deptInCharge = $inCharge->dept_id;
        $categories = DB::select('SELECT ticket_categories.id, ticket_categories.name, users.name AS in_charge_name, ticket_categories.in_charge AS in_charge FROM ticket_categories INNER JOIN users ON ticket_categories.in_charge = users.id');
        $dics = DB::table('users')->where('dept_id', $deptInCharge)->orderBy('name', 'asc')->get();
        $depts = DB::table('departments')->orderBy('name', 'asc')->get();

        return view('admin.system-management.ticket-category', compact('categories', 'depts', 'deptInCharge', 'dics'));
    }

    public function add(Request $request){
        $request->validate([
            'name' => 'required',
        ]);

        $name = strtoupper($request->name);
        $inChargeUser = $request->inchargeUser;

        $cat = new TicketCategory();
        $cat->name = $name;
        $cat->in_charge = $inChargeUser;
        $cat->save();

        return redirect()->back();
    }

    public function edit(Request $request){
        dd($request);
        $request->validate([
            'name' => 'required',
        ]);

        $dept_id = $request->id;
        $dept_name = strtoupper($request->name);

    }
}
