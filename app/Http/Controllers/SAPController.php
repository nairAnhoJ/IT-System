<?php

namespace App\Http\Controllers;

use App\Models\SAP;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SAPController extends Controller
{
    public function index(){
        $sapbps = DB::table('sapbp')->get();
        return view('ticketing.sap', compact('sapbps'));
    }

    public function store(Request $request){
        $saprequest = $request->saprequest;
        $remarks = $request->remarks;
        $type = $request->type;
        $code = $request->code;
        $wtax_code = $request->wtax_code;
        $AR_inCharge = $request->AR_inCharge;
        $isOnHold = $request->isOnHold;
        $AR_email = $request->AR_email;
        $name = $request->name;
        $isAutoEmail = $request->isAutoEmail;
        $payment_terms = $request->payment_terms;
        $billing_address = $request->billing_address;
        $style = $request->style;
        $bir_attachment = $request->bir_attachment;
        $shipping_address = $request->shipping_address;
        $contact_name1 = $request->contact_name1;
        $contact_no1 = $request->contact_no1;
        $contact_email1 = $request->contact_email1;
        $tin = $request->tin;
        $contact_name2 = $request->contact_name2;
        $contact_no2 = $request->contact_no2;
        $contact_email2 = $request->contact_email2;
        $sales_employee = $request->sales_employee;
        $contact_name3 = $request->contact_name3;
        $contact_no3 = $request->contact_no3;
        $contact_email3 = $request->contact_email3;

        $request->validate([
            'name' => 'required',
            'remarks' => 'required',
        ]);

        $inChargeID = (DB::table('departments')->where('id', auth()->user()->dept_id)->get())[0]->in_charge;

        $TicketID = DB::table('tickets')->orderBy('id','DESC')->first();
        if(isset($TicketID)){
            $TicketID = $TicketID->id + 1;
            if(strlen($TicketID) <= 4){
                $TicketIDLength = 4 - strlen($TicketID);
        
                for($x = 1; $x <= $TicketIDLength; $x++){
                    $TicketID = "0{$TicketID}";
                }
            }else{
                $TicketID = substr($TicketID, -4);
            }
        }else{
            $TicketID = '0001';
        }
        $ticketNo = date('m').$TicketID;

        $attPath = null;
        if($bir_attachment != null){
            $unique = Str::random(12);
            $attPath = $request->file('bir_attachment')->storeAs('attachments/'.date('mY'), date('Ymd') . '-' . $ticketNo . '.' . $request->file('bir_attachment')->getClientOriginalExtension(), 'public');
        }

        $sap = new SAP();
        $sap->type = $type;
        $sap->request = $saprequest;
        $sap->remarks = $remarks;
        $sap->code = $code;
        $sap->wtax_code = $wtax_code;
        $sap->AR_inCharge = $AR_inCharge;
        $sap->isOnHold = $isOnHold;
        $sap->AR_email = $AR_email;
        $sap->name = $name;
        $sap->isAutoEmail = $isAutoEmail;
        $sap->payment_terms = $payment_terms;
        $sap->billing_address = $billing_address;
        $sap->style = $style;
        $sap->bir_attachment = $bir_attachment;
        $sap->shipping_address = $shipping_address;
        $sap->contact_name1 = $contact_name1;
        $sap->contact_no1 = $contact_no1;
        $sap->contact_email1 = $contact_email1;
        $sap->tin = $tin;
        $sap->contact_name2 = $contact_name2;
        $sap->contact_no2 = $contact_no2;
        $sap->contact_email2 = $contact_email2;
        $sap->sales_employee = $sales_employee;
        $sap->contact_name3 = $contact_name3;
        $sap->contact_no3 = $contact_no3;
        $sap->contact_email3 = $contact_email3;
        $sap->save();

        $ticket = new Ticket();
        $ticket->ticket_no = $ticketNo;
        $ticket->user_id = auth()->user()->id;
        $ticket->department = auth()->user()->dept_id;
        $ticket->nature_of_problem = '5';
        $ticket->assigned_to = $inChargeID;
        $ticket->subject = 'FOR '.$saprequest;
        $ticket->description = $remarks;
        if($bir_attachment != null){
            $ticket->attachment = $attPath;
        }
        $ticket->save();

        return redirect()->route('sap.index');
    }

    public function edit(Request $request){
        $id = $request->id;

        $sap = DB::table('sapbp')->where('id', $id)->first();

        $type = $sap->type;
        $code = $sap->code;
        $wtax_code = $sap->wtax_code;
        $AR_inCharge = $sap->AR_inCharge;
        $isOnHold = $sap->isOnHold;
        $AR_email = $sap->AR_email;
        $name = $sap->name;
        $isAutoEmail = $sap->isAutoEmail;
        $payment_terms = $sap->payment_terms;
        $billing_address = $sap->billing_address;
        $style = $sap->style;
        $shipping_address = $sap->shipping_address;
        $contact_name1 = $sap->contact_name1;
        $contact_no1 = $sap->contact_no1;
        $contact_email1 = $sap->contact_email1;
        $tin = $sap->tin;
        $contact_name2 = $sap->contact_name2;
        $contact_no2 = $sap->contact_no2;
        $contact_email2 = $sap->contact_email2;
        $sales_employee = $sap->sales_employee;
        $contact_name3 = $sap->contact_name3;
        $contact_no3 = $sap->contact_no3;
        $contact_email3 = $sap->contact_email3;

        $result = array(
            'type' => $type,
            'code' => $code,
            'wtax_code' => $wtax_code,
            'AR_inCharge' => $AR_inCharge,
            'isOnHold' => $isOnHold,
            'AR_email' => $AR_email,
            'name' => $name,
            'isAutoEmail' => $isAutoEmail,
            'payment_terms' => $payment_terms,
            'billing_address' => $billing_address,
            'style' => $style,
            'shipping_address' => $shipping_address,
            'contact_name1' => $contact_name1,
            'contact_no1' => $contact_no1,
            'contact_email1' => $contact_email1,
            'tin' => $tin,
            'contact_name2' => $contact_name2,
            'contact_no2' => $contact_no2,
            'contact_email2' => $contact_email2,
            'sales_employee' => $sales_employee,
            'contact_name3' => $contact_name3,
            'contact_no3' => $contact_no3,
            'contact_email3' => $contact_email3
        );

        echo json_encode($result);
    }

    public function update(Request $request){
        $id = $request->id;
        $type = $request->type;
        $saprequest = $request->saprequest;
        $remarks = $request->remarks;
        $code = $request->code;
        $wtax_code = $request->wtax_code;
        $AR_inCharge = $request->AR_inCharge;
        $isOnHold = $request->isOnHold;
        $AR_email = $request->AR_email;
        $name = $request->name;
        $isAutoEmail = $request->isAutoEmail;
        $payment_terms = $request->payment_terms;
        $billing_address = $request->billing_address;
        $style = $request->style;
        $bir_attachment = $request->bir_attachment;
        $shipping_address = $request->shipping_address;
        $contact_name1 = $request->contact_name1;
        $contact_no1 = $request->contact_no1;
        $contact_email1 = $request->contact_email1;
        $tin = $request->tin;
        $contact_name2 = $request->contact_name2;
        $contact_no2 = $request->contact_no2;
        $contact_email2 = $request->contact_email2;
        $sales_employee = $request->sales_employee;
        $contact_name3 = $request->contact_name3;
        $contact_no3 = $request->contact_no3;
        $contact_email3 = $request->contact_email3;

        $request->validate([
            'name' => 'required',
            'remarks' => 'required',
        ]);

        $inChargeID = (DB::table('departments')->where('id', auth()->user()->dept_id)->get())[0]->in_charge;

        $TicketID = DB::table('tickets')->orderBy('id','DESC')->first();
        if(isset($TicketID)){
            $TicketID = $TicketID->id + 1;
            if(strlen($TicketID) <= 4){
                $TicketIDLength = 4 - strlen($TicketID);
        
                for($x = 1; $x <= $TicketIDLength; $x++){
                    $TicketID = "0{$TicketID}";
                }
            }else{
                $TicketID = substr($TicketID, -4);
            }
        }else{
            $TicketID = '0001';
        }
        $ticketNo = date('m').$TicketID;

        $attPath = null;
        if($bir_attachment != null){
            $unique = Str::random(12);
            $attPath = $request->file('bir_attachment')->storeAs('attachments/'.date('mY'), date('Ymd') . '-' . $ticketNo . '.' . $request->file('bir_attachment')->getClientOriginalExtension(), 'public');
        }

        $sap = SAP::find($id);
        $sap->request = $saprequest;
        $sap->remarks = $remarks;
        $sap->type = $type;
        $sap->code = $code;
        $sap->wtax_code = $wtax_code;
        $sap->AR_inCharge = $AR_inCharge;
        $sap->isOnHold = $isOnHold;
        $sap->AR_email = $AR_email;
        $sap->name = $name;
        $sap->isAutoEmail = $isAutoEmail;
        $sap->payment_terms = $payment_terms;
        $sap->billing_address = $billing_address;
        $sap->style = $style;
        $sap->bir_attachment = $bir_attachment;
        $sap->shipping_address = $shipping_address;
        $sap->contact_name1 = $contact_name1;
        $sap->contact_no1 = $contact_no1;
        $sap->contact_email1 = $contact_email1;
        $sap->tin = $tin;
        $sap->contact_name2 = $contact_name2;
        $sap->contact_no2 = $contact_no2;
        $sap->contact_email2 = $contact_email2;
        $sap->sales_employee = $sales_employee;
        $sap->contact_name3 = $contact_name3;
        $sap->contact_no3 = $contact_no3;
        $sap->contact_email3 = $contact_email3;
        $sap->update();

        $ticket = new Ticket();
        $ticket->ticket_no = $ticketNo;
        $ticket->user_id = auth()->user()->id;
        $ticket->department = auth()->user()->dept_id;
        $ticket->nature_of_problem = '5';
        $ticket->assigned_to = $inChargeID;
        $ticket->subject = 'FOR '.$saprequest;
        $ticket->description = $remarks;
        if($bir_attachment != null){
            $ticket->attachment = $attPath;
        }
        $ticket->save();

        return redirect()->route('sap.index');
    }
}
