<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(){
        $items = DB::select('SELECT	items.id, item_types.name AS type, items.code, items.brand, items.description, items.is_Defective, items.serial_no, items.invoice_no, items.date_purchased, items.status, items.is_Defective, computers.code AS comp, sites.name AS site FROM (((items INNER JOIN item_types ON items.type_id = item_types.id) INNER JOIN computers ON items.computer_id = computers.id) INNER JOIN sites ON items.site_id = sites.id) WHERE items.is_Defective = 0 ORDER BY items.id DESC');
        $depts = DB::table('departments')->where('id', '!=', 1)->orderBy('name', 'asc')->get();

        return view('inventory.items', compact('items', 'depts'));
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
            $user = strtoupper($request->user);
            $department = $request->department;
            $cost = $request->cost;
            $color = strtoupper($request->color);
            $status = $request->status;
            $remarks = strtoupper($request->remarks);
            $date_issued = $request->date_issued;

            $thisItem = DB::table('items')->where('id', $statusID)->first();
            if($thisItem->type_id == '13'){
                $lastComputerCode = DB::table('computers')->orderBy('id','desc')->first();
                if($lastComputerCode->code != 'N/A'){
                    $lastCC = substr($lastComputerCode->code, -6);
                    $lastCC++;
                    while(mb_strlen($lastCC, "UTF-8") < 6){
                        $lastCC = "0{$lastCC}";
                    }
                    $computerCode = "HII_PC-{$lastCC}";
                }else{
                    $computerCode = 'HII_PC-000001';
                }
    
                $computer = new Computer();
                $computer->code = $computerCode;
                $computer->user = strtoupper($user);
                $computer->site = $thisItem->site_id;
                $computer->ip_add = '0.0.0.0';
                $computer->type = 'LAPTOP';
                $computer->status = 'WORKING';
                $computer->conducted_by = auth()->user()->name;
                $computer->date_conducted = date('m-d-Y');
                $computer->save();

                $com_id = $computer->id;
                // dd($com_id);

                DB::table('items')
                    ->where('id', $statusID)
                    ->update([
                        'i_user' => $user,
                        'i_department' => $department,
                        'i_cost' => $cost,
                        'i_color' => $color,
                        'i_status' => $status,
                        'i_remarks' => $remarks,
                        'i_date_issued' => $date_issued,
                        'computer_id' => $com_id,
                        'status' => 'USED',
                        'edited_by' => auth()->user()->name
                    ]);
            }else{
                DB::table('items')
                    ->where('id', $statusID)
                    ->update(['i_user' => $user,'i_department' => $department, 'i_cost' => $cost, 'i_color' => $color, 'i_status' => $status, 'i_remarks' => $remarks, 'i_date_issued' => $date_issued, 'computer_id' => 1, 'status' => 'USED', 'edited_by' => auth()->user()->name]);
            }


        }else if($thisStatus == 'USED'){

            DB::table('items')
                ->where('id', $statusID)
                ->update(['i_user' => null, 'i_department' => null, 'i_cost' => null, 'i_color' => null, 'i_status' => null, 'i_remarks' => null, 'i_date_issued' => null, 'computer_id' => 1, 'status' => 'SPARE', 'edited_by' => auth()->user()->name]);

        }
        return redirect()->route('item.index');
    }
    
    public function defectiveIndex(){
        $items = DB::select('SELECT	items.id, item_types.name AS type, items.code, items.brand, items.description, items.serial_no, items.invoice_no, items.date_purchased, items.status, items.is_Defective, computers.code AS comp, sites.name AS site FROM (((items INNER JOIN item_types ON items.type_id = item_types.id) INNER JOIN computers ON items.computer_id = computers.id) INNER JOIN sites ON items.site_id = sites.id) WHERE items.is_Defective = 1 ORDER BY items.id DESC');
        return view('inventory.defective-items', compact('items'));
    }

    public function defectiveRestore(Request $request){
        $defectiveID = $request->defectiveID;
        DB::update("UPDATE items SET is_Defective=0, computer_id=1, status='SPARE', edited_by=?  WHERE id=?", [auth()->user()->name, $defectiveID]);
        return redirect()->route('defectiveIndex.index');
    }

    public function issuance($id){
        $item = (DB::select('SELECT items.id, item_types.name AS item_name, items.brand, items.serial_no, items.description, sites.name as site_name, items.i_user, departments.name AS dept_name, items.i_cost, items.i_color, items.i_status, items.i_remarks, items.i_date_issued FROM items INNER JOIN item_types ON items.type_id = item_types.id INNER JOIN sites ON items.site_id = sites.id INNER JOIN departments ON items.i_department = departments.id WHERE items.id = ?', [$id]))[0];

        $item = (object) [
            'user' => $item->i_user,
            'date_issued' => $item->i_date_issued,
            'department' => $item->dept_name,
            'site' => $item->site_name,
            'desc' => $item->brand.' '.$item->description,
            'cost' => $item->i_cost,
            'serial_no' => $item->serial_no,
            'color' => $item->i_color,
            'remarks' => $item->i_remarks,
            'status' => $item->i_status,
            'item' => $item->item_name
        ];

        $settings = (DB::table('settings')->where('id', 1)->first());


        return view('inventory.issuance', compact('item', 'settings'));
    }
}
