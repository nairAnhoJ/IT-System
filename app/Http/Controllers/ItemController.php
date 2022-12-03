<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(){

        $types = DB::table('item_types')->orderBy('name', 'asc')->get();
        $items = DB::select('SELECT	item_types.name AS type, items.code, items.brand, items.description, items.serial_no, items.date_purchased, items.status, computers.name AS comp, sites.name AS site FROM (((items INNER JOIN item_types ON items.type_id = item_types.id) INNER JOIN computers ON items.computer_id = computers.id) INNER JOIN sites ON items.site_id = sites.id) ORDER BY items.id DESC');

        return view('inventory.items', compact('types', 'items'));
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
        $itemCode = '';

        $lastItemCode = DB::table('items')->orderBy('id','desc')->take(1)->get();
        if($lastItemCode->count() > 0){
            $lastIC = substr($lastItemCode[0]->code, -6);
            $lastIC++;
            while(mb_strlen($lastIC, "UTF-8") < 6){
                $lastIC = "0{$lastIC}";
            }
            $itemCode = "HII-{$lastIC}";
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
        $item->type_id = $type;
        $item->code = $itemCode;
        $item->brand = strtoupper($brand);
        $item->serial_no = strtoupper($serial_no);
        $item->description = strtoupper($description);
        $item->date_purchased = $date_purchased;
        $item->status = 'SPARE';
        $item->computer_id = '1';
        $item->site_id = '1';
        $item->added_by = strtoupper($user_name);
        $item->edited_by = strtoupper($user_name);
        $item->save();

        return redirect()->route('item.index');
    }
}
