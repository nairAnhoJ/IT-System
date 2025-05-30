<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\ItemType;
use App\Models\PhoneSimRequest;
use App\Models\Site;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    public function index(){
        $types = ItemType::orderBy('name', 'asc')->get();
        $requests = [];

        if(Auth::user()->role == 'user'){
            $item_requests = ItemRequest::with('item')->with('req_by')->with('department')->with('req_site')->where('requested_by_department', Auth::user()->dept_id)->get();
            foreach($item_requests as $item){
                $obj = new stdClass();
                $obj->id = $item->id;
                $obj->item = $item->item->name;
                $obj->requested_by = $item->req_by->name;
                $obj->requested_for = $item->requested_for;
                $obj->site = $item->req_site->name;
                $obj->status = $item->status;
                $obj->attachment = $item->status;
                $requests[] = $obj;
            }

            $ps_requests = PhoneSimRequest::with('req_by')->with('req_site')->where('requested_by_department', Auth::user()->dept_id)->get();
            foreach($ps_requests as $ps){
                $obj = new stdClass();
                $obj->id = $ps->id;
                $obj->item = $ps->item;
                $obj->requested_by = $ps->req_by->name;
                $obj->requested_for = $ps->requested_for;
                $obj->site = $ps->req_site->name;
                $obj->status = $ps->status;
                $obj->attachment = $ps->attachment;
                $requests[] = $obj;
            }
        }

        return view('request.user-request', compact('types', 'requests'));
    }

    public function add(){
        $types = ItemType::get();
        $sites = Site::get();

        return view('request.user-request-add', compact('types', 'sites'));
    }

    public function store(Request $request){
        $request->validate([
            'requested_for' => ['required'],
            'attachment' => ['required'],
        ]);
        $type = $request->type;
        $requested_for = strtoupper($request->requested_for);
        $site = $request->site;
        $now = (new DateTime('now', new DateTimeZone('Asia/Manila')))->format('Y-m-d H:i:s');

        $attachment = $request->attachment;
        if($attachment != null){
            $filename = date('Ymd') . '-' . Str::uuid() . '.' . $request->file('attachment')->getClientOriginalExtension();
            $path = "storage/attachments/requests/";
            $attachment_path = $path . $filename;
            $request->file('attachment')->move(public_path('storage/'.$path), $filename);
        }

        if($type == 'PHONE' || $type == 'SIM'){
            $nReq = new PhoneSimRequest();
            $nReq->item = $type;
            $nReq->requested_by = Auth::user()->id;
            $nReq->requested_by_department = Auth::user()->dept_id;
            $nReq->requested_for = $requested_for;
            $nReq->site = $site;
            $nReq->status = 'PENDING';
            $nReq->date_requested = $now;
            $nReq->attachment = $attachment_path;
            $nReq->save();
        }else{
            $nReq = new ItemRequest();
            $nReq->type_id = $type;
            $nReq->requested_by = Auth::user()->id;
            $nReq->requested_by_department = Auth::user()->dept_id;
            $nReq->requested_for = $requested_for;
            $nReq->site = $site;
            $nReq->status = 'PENDING';
            $nReq->date_requested = $now;
            $nReq->attachment = $attachment_path;
            $nReq->save();
        }

        return redirect()->route('request.index');
    }

    public function cancel(Request $request){
        if($request->item == 'PHONE' || $request->item == 'SIM'){
            $item = PhoneSimRequest::where('id', $request->id)->first();
            $item->status = "CANCELLED";
            $item->save();
        }else{
            $item = ItemRequest::where('id', $request->id)->first();
            $item->status = "CANCELLED";
            $item->save();
        }

        return redirect()->route('request.index');
    }
}
