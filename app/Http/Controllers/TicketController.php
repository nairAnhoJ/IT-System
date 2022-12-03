<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index(){
        $userID = auth()->user()->id;
        $userRow = DB::table('users')->where('id', $userID)->get();
        $userDeptID = $userRow[0]->dept_id;
        $userDept = DB::table('departments')->where('id', $userDeptID)->get()[0]->name;

        return view('ticketing.dashboard', compact('userDept'));
    }

    public function create(){
        return view('ticketing.create');
    }
}
