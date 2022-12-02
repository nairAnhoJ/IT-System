<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComputerController extends Controller
{
    public function index(){

        $sites = DB::table('sites')->get();

        return view('inventory.computer', compact('sites'));
    }
}
