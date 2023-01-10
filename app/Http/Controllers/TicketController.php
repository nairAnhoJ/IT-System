<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index(){
        $userID = auth()->user()->id;
        $userRow = DB::table('users')->where('id', $userID)->get();
        $userDeptID = $userRow[0]->dept_id;
        $userDept = DB::table('departments')->where('id', $userDeptID)->get()[0]->name;
        $deptInCharge = (DB::table('dept_in_charges')->where('id', 1)->first())->dept_id;

        $tickets = DB::select("SELECT tickets.id, tickets.ticket_no, users.name AS user, departments.name AS dept, tickets.nature_of_problem, tickets.assigned_to, tickets.subject, tickets.description, tickets.status, tickets.created_at, tickets.attachment, tickets.resolution FROM tickets INNER JOIN users ON tickets.user_id = users.id INNER JOIN departments ON tickets.department = departments.id ORDER BY tickets.id DESC");

        return view('ticketing.dashboard', compact('userDept', 'tickets', 'deptInCharge'));
    }

    public function create(){
        $cats = DB::select('SELECT * FROM ticket_categories ORDER BY ticket_categories.name ASC');
        $inChargeID = (DB::table('departments')->where('id', auth()->user()->dept_id)->get())[0]->in_charge;
        $inchargeName = (DB::table('users')->where('id', $inChargeID)->get())[0]->name;
        return view('ticketing.create', compact('cats', 'inchargeName'));
    }

    public function store(Request $request){
        $nature = $request->nature;
        $subject = $request->subject;
        $description = $request->description;
        $attachment = $request->attachment;
        
        $inChargeID = (DB::table('departments')->where('id', auth()->user()->dept_id)->get())[0]->in_charge;
        $inchargeName = (DB::table('users')->where('id', $inChargeID)->get())[0]->name;

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
        if($attachment != null){
            $unique = Str::random(12);
            $attPath = $request->file('attachment')->storeAs('attachments/'.date('mY'), date('Ymd') . '-' . $ticketNo . '.' . $request->file('attachment')->getClientOriginalExtension(), 'public');
        }

        $request->validate([
            'subject' => ['required'],
            'description' => ['required'],
            'attachment' => ['nullable'],
        ]);

        $ticket = new Ticket();
        $ticket->ticket_no = $ticketNo;
        $ticket->user_id = auth()->user()->id;
        $ticket->department = auth()->user()->dept_id;
        $ticket->nature_of_problem = $nature;
        $ticket->assigned_to = $inchargeName;
        $ticket->subject = $subject;
        $ticket->description = $description;
        if($attachment != null){
            $ticket->attachment = $attPath;
        }
        $ticket->save();

        return redirect()->route('ticket.index');
    }

    public function update(Request $request){
        $id = $request->ticketID;
        $status = $request->ticketStatus;

        if($status == 'PENDING'){
            DB::update('update tickets set status = "ONGOING", start_date_time = NOW()  where id = ?', [$id]);
        }else if($status == 'ONGOING'){
            $request->validate([
                'ticketResolution' => 'required',
            ]);
            DB::update('update tickets set status = "DONE", resolution = ?, end_date_time = NOW()  where id = ?', [$request->ticketResolution, $id]);
        }

        return redirect()->route('ticket.index');
    }

}
