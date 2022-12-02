<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(){

        $types = DB::table('item_types')->orderBy('name', 'asc')->get();

        return view('inventory.items', compact('types'));
    }

    public function add(){

        $types = DB::table('item_types')->orderBy('name', 'asc')->get();

        return view('inventory.item-add', compact('types'));
    }

    public function store(Request $request){
        $user_name = auth()->user()->name;
        $type = $request->type;
        $brand = $request->brand;
        $serial_no = $request->serial_no;
        $description = $request->description;
        $date_purchased = $request->date_purchased;

        $lastItemCode = DB::table('items')->orderBy('id','desc')->take(1)->first();
        if($lastItemCode->count() > 0){
            $lastIC = substr($lastItemCode->code, -6);
            // $itemCode = 'HII-'
        }else{
            $itemCode = 'HII-000001';
        }

        $request->validate([
            'type' => 'required',
            'brand' => 'required',
            'serial_no' => 'required',
            'description' => 'required',
            'date_purchased' => 'required',
        ]);

        $item = new Item();
        $item->type = $type;
        $item->brand = strtoupper($brand);
        $item->serial_no = strtoupper($serial_no);
        $item->description = strtoupper($description);
        $item->date_purchased = $date_purchased;
        $item->status = 'SPARE';
        $item->computer_id = 'N/A';
        $item->site = 'N/A';
        $item->added_by = strtoupper($user_name);
        $item->edited_by = strtoupper($user_name);

        // $mrf = new mrf();
        // $mrf->area = $area;
        // $mrf->customer_name = $cus_name;
        // $mrf->customer_address = $cus_add;
        // $mrf->fleet_no = $fleet_no;
        // $mrf->brand_id = $brand;
        // $mrf->model_id = $model;
        // $mrf->serial_no = $serial_no;
        // $mrf->fsrr_no = $fsrr_no;
        // $mrf->delivery_type = $delivery_type;
        // $mrf->remarks = $remarks;
        // $mrf->supervisor = 'Pending';
        // $mrf->requester = auth()->user()->name;
        // $mrf->request_for = $request_for;
        // $mrf->order_type = $order_type;
        // $mrf->date_needed = $date_needed;
        // $mrf->save();
    }
}
