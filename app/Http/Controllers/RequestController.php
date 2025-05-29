<?php

namespace App\Http\Controllers;

use App\Models\ItemRequest;
use App\Models\ItemType;
use App\Models\PhoneSimRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class RequestController extends Controller
{
    public function index(){
        $types = ItemType::orderBy('name', 'asc')->get();
        $requests = [];

        if(Auth::user()->role == 'user'){
            $item_requests = ItemRequest::with('item')->with('req_by')->with('department')->with('req_site')->where('requested_by_department', Auth::user()->dept_id)->get();
            foreach($item_requests as $item){
                $obj = new stdClass();
                $obj->item = $item->item->name;
                $obj->requested_by = $item->req_by->name;
                $obj->requested_for = $item->requested_for;
                $obj->site = $item->req_site->name;
                $obj->status = $item->status;
                $requests[] = $obj;
            }

            $ps_requests = PhoneSimRequest::with('req_by')->with('req_site')->where('requested_by_department', Auth::user()->dept_id)->get();
            foreach($ps_requests as $ps){
                $obj = new stdClass();
                $obj->item = $ps->item;
                $obj->requested_by = $ps->req_by->name;
                $obj->requested_for = $ps->requested_for;
                $obj->site = $ps->req_site->name;
                $obj->status = $ps->status;
                $requests[] = $obj;
            }
        }

        return view('request.user-request', compact('types', 'requests'));
    }
}
