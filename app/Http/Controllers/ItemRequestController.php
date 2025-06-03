<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\TempAttachment;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ItemRequestController extends Controller
{
    public function index(){
        $types = DB::table('item_types')->orderBy('name', 'asc')->get();
        $requests = ItemRequest::with('item')->with('req_by')->with('department')->with('req_site')->orderBy('date_requested', 'desc')->get();
        // $reqs = DB::select('SELECT item_requests.id, item_requests.pr_no, item_types.name AS type, item_requests.brand, item_requests.description, item_requests.remarks, item_requests.quantity, item_requests.quantity_delivered, item_requests.req_by, sites.name AS site, item_requests.status, item_requests.date_requested, item_requests.date_delivered FROM item_requests INNER JOIN item_types ON item_requests.type_id = item_types.id INNER JOIN sites ON item_requests.site = sites.id ORDER BY item_requests.id DESC');

        // dd($requests);

        return view('request.items', compact('types', 'requests'));
    }

    public function add(){
        $types = DB::table('item_types')->orderBy('name', 'asc')->get();
        $sites = DB::table('sites')->orderBy('name', 'asc')->get();
        $Action = "add";
        $ItemID = '';
        $PRNo = '';
        $ItemType = '';
        $Brand = '';
        $Description = '';
        $Remarks = '';
        $Quantity = '';
        $Req_by = '';
        $Status = '';
        $Site = '';
        $DateRequested = date('m/d/Y');
        $DateDelivered = date('m/d/Y');

        return view('request.item-add-edit', compact('types', 'Action', 'ItemID', 'PRNo', 'ItemType', 'Brand', 'Description', 'Remarks', 'Quantity', 'Req_by', 'Status', 'DateRequested', 'DateDelivered', 'sites', 'Site'));
    }

    public function store(Request $request){
        $pr_no = strtoupper($request->pr_no);
        $type = $request->type;
        $brand = strtoupper($request->brand);
        $description = strtoupper($request->description);
        $remarks = $request->remarks;
        $quantity = $request->quantity;
        $req_by = strtoupper($request->req_by);
        $site = $request->site;
        $status = $request->status;
        $date_req = $request->date_req;
        $date_del = 'N/A';
        if($status == 'DELIVERED'){
            $date_del = $request->date_del;
        }

        $request->validate([
            'pr_no' => 'required',
            'brand' => 'required',
            'description' => 'required',
            'remarks' => 'required',
            'quantity' => 'required',
            'req_by' => 'required',
        ]);

        $req = new ItemRequest();
        $req->pr_no = $pr_no;
        $req->type_id = $type;
        $req->brand = $brand;
        $req->description = $description;
        $req->remarks = $remarks;
        $req->quantity = $quantity;
        $req->quantity_delivered = 'N/A';
        $req->req_by = $req_by;
        $req->site = $site;
        $req->status = $status;
        $req->date_requested = $date_req;
        $req->date_delivered = $date_del;
        $req->save();

        return redirect()->route('reqItem.index');
    }

    public function edit($id){
        $req = ItemRequest::find($id);
        $types = DB::table('item_types')->orderBy('name', 'asc')->get();
        $sites = DB::table('sites')->orderBy('name', 'asc')->get();

        $Action = "edit";
        $ItemID = $req->id;
        $PRNo = $req->pr_no;
        $ItemType = $req->type_id;
        $Brand = $req->brand;
        $Description = $req->description;
        $Remarks = $req->remarks;
        $Quantity = $req->quantity;
        $Req_by = $req->req_by;
        $Site = $req->site;
        $Status = $req->status;
        $DateRequested = $req->date_requested;
        $DateDelivered = $req->date_delivered;

        return view('request.item-add-edit', compact('Action', 'ItemID', 'PRNo', 'ItemType', 'Brand', 'Description', 'Remarks', 'Quantity', 'Req_by', 'Site', 'Status', 'DateRequested', 'DateDelivered', 'types', 'sites'));
    }

    public function update(Request $request){
        $itemID = $request->itemID;
        $pr_no = strtoupper($request->pr_no);
        $type = $request->type;
        $brand = strtoupper($request->brand);
        $description = strtoupper($request->description);
        $remarks = $request->remarks;
        $quantity = $request->quantity;
        $req_by = strtoupper($request->req_by);
        $site = $request->site;
        $date_req = $request->date_req;

        $request->validate([
            'pr_no' => 'required',
            'brand' => 'required',
            'description' => 'required',
            'remarks' => 'required',
            'quantity' => 'required',
            'req_by' => 'required',
        ]);

        DB::update('UPDATE item_requests SET item_requests.pr_no=?, item_requests.type_id=?, item_requests.brand=?, item_requests.description=?, item_requests.remarks=?, item_requests.quantity=?, item_requests.req_by=?, item_requests.site=?, item_requests.date_requested=? WHERE item_requests.id=?', [$pr_no, $type, $brand, $description, $remarks, $quantity, $req_by, $site, $date_req, $itemID]);

        return redirect()->route('reqItem.index');
    }

    public function statusUpdate(Request $request){
        $id = $request->reqID;
        // $req = DB::select('SELECT item_requests.id, item_requests.pr_no, item_requests.type_id, item_types.name AS type, item_requests.brand, item_requests.description, item_requests.remarks, item_requests.quantity, item_requests.req_by, sites.name AS site, item_requests.status, item_requests.date_requested, item_requests.date_delivered FROM item_requests INNER JOIN item_types ON item_requests.type_id = item_types.id INNER JOIN sites ON item_requests.site = sites.id WHERE item_requests.id=?', [$id]);
        $status = $request->updateStatus;
        if($status == 'DELIVERED'){
            // $reqID = $id;
            return redirect( url('/request/items/delivered/'.$id) );
            // return view('request.items-delivered', compact('reqID', 'req'));
        }else if($status == 'DECLINED'){
            DB::update('UPDATE item_requests SET item_requests.status=? WHERE item_requests.id=?', [$status, $id]);
            return redirect()->route('reqItem.index');
        }
    }

    public function statusD($id){
        // dd($id);
        $req = DB::select('SELECT item_requests.id, item_requests.pr_no, item_requests.type_id, item_types.name AS type, item_requests.brand, item_requests.description, item_requests.remarks, item_requests.quantity, item_requests.req_by, sites.name AS site, item_requests.status, item_requests.date_requested, item_requests.date_delivered FROM item_requests INNER JOIN item_types ON item_requests.type_id = item_types.id INNER JOIN sites ON item_requests.site = sites.id WHERE item_requests.id=?', [$id]);

        return view('request.items-delivered', compact('id', 'req'));
    }

    public function done(Request $request){
        $id = $request->doneId;
        // $pr_no = $request->pr_no;
        $brand = $request->brand;
        $description = $request->description;
        $serial_number = $request->serial_number;
        $remarks = $request->remarks;
        $now = (new DateTime('now', new DateTimeZone('Asia/Manila')))->format('Y-m-d H:i:s');

        $lastId = Item::orderBy('id','desc')->first();
        if($lastId != null){
            $newId = $lastId->id + 1;
            while(strlen($newId) < 6){
                $newId = "0{$newId}";
            }
            $itemCode = "HII-{$newId}";
        }else{
            $itemCode = "HII-000001";
        }

        $attachment = $request->invoice;
        if($attachment != null){
            $filename = $itemCode . '.' . $request->file('invoice')->getClientOriginalExtension();
            $path = "attachments/invoice/" . date("mdY") . '/';
            $attachment_path = $path . $filename;
            $request->file('invoice')->move(public_path("storage/".$path), $filename);
        }

        $request = ItemRequest::where('id', $id)->first();
        $request->brand = strtoupper($brand);
        $request->description = $description;
        $request->remarks = $remarks;
        $request->status = "DONE";
        $request->done_date = $now;
        $request->save();
        
        $item = new Item();
        $item->type_id = $request->type_id;
        $item->code = $itemCode;
        $item->brand = strtoupper($brand);
        $item->serial_no = strtoupper($serial_number);
        $item->invoice_no = $attachment_path;
        $item->description = strtoupper($description);
        $item->date_purchased = $now;
        $item->status = 'SPARE';
        $item->computer_id = '1';
        $item->site_id = '1';
        $item->added_by = strtoupper(Auth::user()->name);
        $item->edited_by = strtoupper(Auth::user()->name);
        $item->save();

        return redirect()->route('reqItem.index');
    }

    public function delete(Request $request){
        DB::delete('DELETE FROM item_requests WHERE item_requests.id=?', [$request->deleteID]);
        return redirect()->route('reqItem.index');
    }
}
