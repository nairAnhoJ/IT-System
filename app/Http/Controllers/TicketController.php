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

        $tickets = DB::table('tickets')->orderBy('id', 'desc')->get();

        return view('ticketing.dashboard', compact('userDept', 'tickets'));
    }

    public function create(){
        return view('ticketing.create');
    }

    public function store(Request $request){
        $nature = $request->nature;
        $subject = $request->subject;
        $description = $request->description;
        $attachment = $request->attachment;

        $attPath = null;
        if($attachment != null){
            $unique = Str::random(12);
            $attPath = $request->file('attachment')->storeAs(
                'attachments',
                date('Ymd') . '-' . $unique . '.' . $request->file('attachment')->getClientOriginalExtension(),
                'public');
        }

        $request->validate([
            'subject' => ['required'],
            'description' => ['required'],
            'attachment' => ['nullable'],
        ]);

        $ticket = new Ticket();
        $ticket->ticket_no = 'na';
        $ticket->user_id = auth()->user()->id;
        $ticket->department = auth()->user()->dept_id;
        $ticket->nature_of_problem = $nature;
        $ticket->assigned_to = 'na';
        $ticket->subject = $subject;
        $ticket->description = $description;
        if($attachment != null){
            $ticket->attachment = $attPath;
        }
        $ticket->save();

        return redirect()->route('ticket.index');
    }

}
