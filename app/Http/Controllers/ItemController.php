<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(){
        $items = DB::select('SELECT	items.id, item_types.name AS type, items.code, items.brand, items.description, items.is_Defective, items.serial_no, items.invoice_no, items.date_purchased, items.status, items.is_Defective, computers.code AS comp, sites.name AS site FROM (((items INNER JOIN item_types ON items.type_id = item_types.id) INNER JOIN computers ON items.computer_id = computers.id) INNER JOIN sites ON items.site_id = sites.id) WHERE items.is_Defective = 0 ORDER BY items.id DESC');
        return view('inventory.items', compact('items'));
    }

    public function add(){

        $types = DB::table('item_types')->orderBy('name', 'asc')->get();

        $ItemType = "";
        $Brand = "";
        $SerialNo = "";
        $Description = "";
        $DatePurchased = date('m-d-Y');
        $Action = "add";
        $ItemID = '';
        $InvoiceNo = '';

        return view('inventory.item-add-edit', compact('types', 'ItemType', 'Brand', 'SerialNo', 'Description', 'DatePurchased', 'Action', 'ItemID', 'InvoiceNo'));
    }

    public function store(Request $request){
        $user_name = auth()->user()->name;
        $type = $request->type;
        $brand = $request->brand;
        $serial_no = $request->serial_no;
        $description = $request->description;
        $date_purchased = $request->date_purchased;
        $InvoiceNo = $request->invoice;
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
            'invoice' => 'required',
            'description' => 'required',
            'date_purchased' => 'required',
        ]);

        $invoicePath = null;
        $newDate_del = date("mdY", strtotime($date_purchased));
        $invoicePath = $request->file('invoice')->storeAs('invoice/item/'.date('mY'), $itemCode.'-'.$newDate_del.'.'.$request->file('invoice')->getClientOriginalExtension(), 'public');

        $item = new Item();
        $item->type_id = $type;
        $item->code = $itemCode;
        $item->brand = strtoupper($brand);
        $item->serial_no = strtoupper($serial_no);
        $item->invoice_no = $invoicePath;
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

    public function edit($id){
        $item = Item::find($id);
        
        $types = DB::table('item_types')->orderBy('name', 'asc')->get();

        $ItemID = $item->id;
        $ItemType = $item->type_id;
        $Brand = $item->brand;
        $SerialNo = $item->serial_no;
        $Description = $item->description;
        $DatePurchased = $item->date_purchased;
        $Action = "edit";

        return view('inventory.item-add-edit', compact('types', 'ItemType', 'Brand', 'SerialNo', 'Description', 'DatePurchased', 'Action', 'ItemID'));
    }

    public function update(Request $request){
        $user_name = strtoupper(auth()->user()->name);
        $type = $request->type;
        $brand = $request->brand;
        $serial_no = $request->serial_no;
        $description = $request->description;
        $date_purchased = $request->date_purchased;
        $ItemID = $request->itemID;
        
        if(isset($request->invoice)){
            $oldInvoice = (DB::table('items')->where('id', $ItemID)->first())->invoice_no;
            unlink(storage_path('app/public/'.$oldInvoice));

            $ItemCode = (DB::table('items')->orderBy('id','desc')->first())->code;
            
            $invoicePath = null;
            $newDate_del = date("mdY", strtotime($date_purchased));
            $invoicePath = $request->file('invoice')->storeAs('invoice/item/'.date('mY'), $ItemCode.'-'.$newDate_del.'.'.$request->file('invoice')->getClientOriginalExtension(), 'public');

            DB::update('UPDATE items SET type_id=?, brand=?, serial_no=?, description=?, invoice_no=?, date_purchased=?, edited_by=?, updated_at=? WHERE id=?', [$type, $brand, $serial_no, $description, $invoicePath, $date_purchased, $user_name, date('Y-m-d H:m:s'), $ItemID]);
        }else{
            DB::update('UPDATE items SET type_id=?, brand=?, serial_no=?, description=?, date_purchased=?, edited_by=?, updated_at=? WHERE id=?', [$type, $brand, $serial_no, $description, $date_purchased, $user_name, date('Y-m-d H:m:s'), $ItemID]);
        }

        return redirect()->route('item.index');
    }

    public function download($id){
        $invoice = DB::table('items')->where('id', $id)->first();
        $inv_path = $invoice->invoice_no;
        $filepath = storage_path("app/public/{$inv_path}");
        return Storage::download("public/{$inv_path}");
    }

    public function delete(Request $request){
        $oldInvoice = (DB::table('items')->where('id', $request->deleteID)->first())->invoice_no;
        unlink(storage_path('app/public/'.$oldInvoice));
        DB::delete('DELETE FROM items WHERE items.id=?', [$request->deleteID]);
        return redirect()->route('item.index');
    }

    public function defective(Request $request){
        $defectiveID = $request->defectiveID;
        $old_desc = (DB::table('items')->where('id', $defectiveID)->first())->description;
        $new_desc = preg_replace("/\(([^()]*+|(?R))*\)/","", $old_desc);
        DB::update("UPDATE items SET description=?, is_Defective=1, computer_id=1, status='DEFECTIVE', edited_by=?  WHERE id=?", [$new_desc, auth()->user()->name, $defectiveID]);
        return redirect()->route('item.index');
    }

    public function status(Request $request){
        $statusID = $request->statusID;
        $thisStatus = $request->thisStatus;

        if($thisStatus == 'SPARE'){
            $remarks = strtoupper($request->remarks);
            $old_desc = (DB::table('items')->where('id', $statusID)->first())->description;
            DB::update("UPDATE items SET description=?, computer_id=1, status='USED', edited_by=?  WHERE id=?", [$old_desc.' ('.$remarks.')', auth()->user()->name, $statusID]);
        }else if($thisStatus == 'USED'){
            $old_desc = (DB::table('items')->where('id', $statusID)->first())->description;
            $new_desc = preg_replace("/\(([^()]*+|(?R))*\)/","", $old_desc);
            DB::update("UPDATE items SET description=?, computer_id=1, status='SPARE', edited_by=?  WHERE id=?", [$new_desc, auth()->user()->name, $statusID]);
        }
        return redirect()->route('item.index');
    }

    // public function spare(Request $request){
    //     $usedID = $request->usedID;
    //     $old_desc = (DB::table('items')->where('id', $usedID)->first())->description;
    //     $new_desc = preg_replace("/\(([^()]*+|(?R))*\)/","", $old_desc);
    //     DB::update("UPDATE items SET description=?, computer_id=1, status='USED', edited_by=?  WHERE id=?", [$new_desc, auth()->user()->name, $usedID]);
    //     return redirect()->route('item.index');
    // }
    
    public function defectiveIndex(){
        $items = DB::select('SELECT	items.id, item_types.name AS type, items.code, items.brand, items.description, items.serial_no, items.invoice_no, items.date_purchased, items.status, items.is_Defective, computers.code AS comp, sites.name AS site FROM (((items INNER JOIN item_types ON items.type_id = item_types.id) INNER JOIN computers ON items.computer_id = computers.id) INNER JOIN sites ON items.site_id = sites.id) WHERE items.is_Defective = 1 ORDER BY items.id DESC');
        return view('inventory.defective-items', compact('items'));
    }

    public function defectiveRestore(Request $request){
        $defectiveID = $request->defectiveID;
        DB::update("UPDATE items SET is_Defective=0, computer_id=1, status='SPARE', edited_by=?  WHERE id=?", [auth()->user()->name, $defectiveID]);
        return redirect()->route('defectiveIndex.index');
    }
}
