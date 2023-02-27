<?php

namespace App\Http\Controllers;

use App\Models\PhoneSim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PhoneSimController extends Controller
{
    public function index(){
        $items = DB::select('SELECT phone_sims.id, phone_sims.item, phone_sims.user, phone_sims.desc, phone_sims.serial_no, phone_sims.remarks, phone_sims.site, sites.name AS site_name, phone_sims.status, phone_sims.invoice, phone_sims.date_del, phone_sims.is_Defective FROM phone_sims INNER JOIN sites ON phone_sims.site = sites.id WHERE phone_sims.is_Defective = 0 ORDER BY phone_sims.id desc');
        return view('inventory.phone-sim', compact('items'));
    }

    // public function download($id){
    //     $invoice = DB::table('phone_sims')->where('id', $id)->first();
    //     $inv_path = $invoice->invoice;
    //     return Storage::download("public/{$inv_path}");
    // }

    public function add(){
        $sites = DB::table('sites')->orderBy('name', 'ASC')->get();

        $Item = "";
        $User = "";
        $SerialNo = "";
        $Description = "";
        $DateDelivered = date('m-d-Y');
        $Action = "add";
        $Remarks = '';
        $Site = '';
        $Status = '';
        $ItemID = '';
        // $Invoice = '';

        return view('inventory.phone-sim-add-edit', compact('Item', 'sites', 'User', 'SerialNo', 'Description', 'DateDelivered', 'Action', 'ItemID', 'Remarks', 'Site', 'Status'));
    }

    public function store(Request $request){
        $item = $request->item;
        $user = $request->user;
        $description = $request->description;
        $serial_no = $request->serial_no;
        $remarks = $request->remarks;
        $site = $request->site;
        $status = $request->status;
        $date_del = $request->date_del;

        $request->validate([
            'user' => 'required',
            'description' => 'required',
            'serial_no' => 'required',
            'remarks' => 'required',
            'status' => 'required',
            // 'invoice' => 'required',
        ]);

        $invoicePath = 'N/A';
        // $newDate_del = date("mdY", strtotime($date_del));
        // $newID = (DB::table('phone_sims')->orderByDesc('id')->first())->id + 1;
        // $invoicePath = $request->file('invoice')->storeAs('invoice/phone-sim/'.date('mY'), $newID.'-'.$newDate_del.'.'.$request->file('invoice')->getClientOriginalExtension(), 'public');

        $PhoneSim = new PhoneSim();
        $PhoneSim->item = $item;
        $PhoneSim->user = strtoupper($user);
        $PhoneSim->desc = $description;
        $PhoneSim->serial_no = strtoupper($serial_no);
        $PhoneSim->remarks = $remarks;
        $PhoneSim->site = $site;
        $PhoneSim->status = $status;
        $PhoneSim->invoice = $invoicePath;
        $PhoneSim->date_del = $date_del;
        $PhoneSim->save();

        return redirect()->route('phoneSim.index');
    }

    public function edit($id){
        $item = PhoneSim::find($id);
        $sites = DB::table('sites')->orderBy('name', 'ASC')->get();
        
        $ItemID = $item->id;
        $Item = $item->item;
        $User = $item->user;
        $Description = $item->desc;
        $SerialNo = $item->serial_no;
        $Remarks = $item->remarks;
        $Site = $item->site;
        $Status = $item->status;
        $DateDelivered = $item->date_del;
        $Action = "edit";

        return view('inventory.phone-sim-add-edit', compact('sites', 'ItemID', 'Item', 'User', 'Description', 'SerialNo', 'Remarks', 'Site', 'Status', 'DateDelivered', 'Action'));
    }

    public function update(Request $request){
        $ItemID = $request->itemID;
        $user = strtoupper($request->user);
        $description = $request->description;
        $serial_no = strtoupper($request->serial_no);
        $remarks = $request->remarks;
        $site = $request->site;
        $status = $request->status;
        $date_del = $request->date_del;

        // if(isset($request->invoice)){
        //     $oldInvoice = (DB::table('phone_sims')->where('id', $ItemID)->first())->invoice;
        //     unlink(storage_path('app/public/'.$oldInvoice));
            
        //     $invoicePath = null;
        //     $newDate_del = date("mdY", strtotime($date_del));
        //     $invoicePath = $request->file('invoice')->storeAs('invoice/phone-sim/'.date('mY'), $ItemID.'-'.$newDate_del.'.'.$request->file('invoice')->getClientOriginalExtension(), 'public');

        //     $invoice = $request->invoice;
        //     DB::update('UPDATE phone_sims SET phone_sims.user=?, phone_sims.desc=?, phone_sims.serial_no=?, phone_sims.remarks=?, phone_sims.site=?, phone_sims.status=?, phone_sims.invoice=?, phone_sims.date_del=? WHERE phone_sims.id=?', [$user, $description, $serial_no, $remarks, $site, $status, $invoicePath, $date_del, $ItemID]);
        // }else{
            DB::update('UPDATE phone_sims SET phone_sims.user=?, phone_sims.desc=?, phone_sims.serial_no=?, phone_sims.remarks=?, phone_sims.site=?, phone_sims.status=?, phone_sims.date_del=? WHERE phone_sims.id=?', [$user, $description, $serial_no, $remarks, $site, $status, $date_del, $ItemID]);
        // }

        return redirect()->route('phoneSim.index');
    }

    public function delete(Request $request){
        // $oldInvoice = (DB::table('phone_sims')->where('id', $request->deleteID)->first())->invoice;
        // unlink(storage_path('app/public/'.$oldInvoice));
        DB::delete('DELETE FROM phone_sims WHERE phone_sims.id=?', [$request->deleteID]);
        return redirect()->route('phoneSim.index');
    }

    public function defective(Request $request){
        $defectiveID = $request->defectiveID;
        DB::update('UPDATE phone_sims SET is_Defective=1 WHERE id=?', [$defectiveID]);
        return redirect()->route('phoneSim.index');
    }

    public function defectivePhoneIndex(){
        $items = DB::select('SELECT phone_sims.id, phone_sims.item, phone_sims.user, phone_sims.desc, phone_sims.serial_no, phone_sims.remarks, phone_sims.site, sites.name AS site_name, phone_sims.status, phone_sims.invoice, phone_sims.date_del, phone_sims.is_Defective FROM phone_sims INNER JOIN sites ON phone_sims.site = sites.id WHERE phone_sims.is_Defective = 1 ORDER BY phone_sims.id desc');
        return view('inventory.defective-phone-sim', compact('items'));
    }

    public function defectivePhoneRestore(Request $request){
        $defectiveID = $request->defectiveID;
        DB::update('UPDATE phone_sims SET is_Defective=0 WHERE id=?', [$defectiveID]);
        return redirect()->route('defectivePhone.index');
    }
}