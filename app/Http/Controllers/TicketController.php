<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class TicketController extends Controller
{
    public function index(){
        $userID = auth()->user()->id;
        $userDeptID = auth()->user()->dept_id;
        $userRow = DB::table('users')->where('id', $userID)->first();
        $dic = (DB::table('dept_in_charges')->first())->dept_id;
        $dic_users = User::with('site_row', 'department_row')->where('id', '!=', 1)->where('dept_id', $dic)->orderBy('name', 'asc')->get();

        $userDept = '';
        $deptInCharge = '';

        $userDeptRow = DB::table('departments')->where('id', $userDeptID)->first();
        if($userDeptRow != null){
            $userDept = $userDeptRow->name;
        }
        $deptInChargeRow = DB::table('dept_in_charges')->where('id', 1)->first();
        if($deptInChargeRow != null){
            $deptInCharge = $deptInChargeRow->dept_id;
        }

        if($userDeptID != $deptInCharge){
            $tickets = Ticket::with('requestor', 'departmentRow', 'category', 'assigned')
                ->whereIn('status', ['PENDING', 'ONGOING', 'DONE'])
                ->where('department', $userDeptID)
                ->orderBy('status', 'desc')
                ->orderBy('id', 'desc')
                ->limit(30)
                ->get();
        }else{
            $tickets = Ticket::with('requestor', 'departmentRow', 'category', 'assigned')
                ->whereIn('status', ['PENDING', 'ONGOING', 'DONE'])
                ->orderBy('status', 'desc')
                ->orderBy('id', 'desc')
                ->limit(50)
                ->get();
        }

        return view('ticketing.dashboard', compact('userDept', 'tickets', 'deptInCharge', 'dic_users'));
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
        $incharge = (DB::table('users')->where('id', $inChargeID)->first());
        $smtp = DB::table('settings')->where('id', 1)->first();
        $site = DB::table('sites')->where('id', Auth::user()->site)->first()->name;

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

        if($attachment != null){
            $filename = date('Ymd') . '-' . $ticketNo . '.' . $request->file('attachment')->getClientOriginalExtension();
            $path = "attachments/";
            $attachment_path = $path . $filename;
            $request->file('attachment')->move(public_path('storage/'.$path), $filename);
        }

        // $attPath = null;
        // if($attachment != null){
        //     $unique = Str::random(12);
        //     $attPath = $request->file('attachment')->storeAs('attachments/'.date('mY'), date('Ymd') . '-' . $ticketNo . '.' . $request->file('attachment')->getClientOriginalExtension(), 'public');
        // }

        $request->validate([
            'subject' => ['required'],
            'description' => ['required'],
            'attachment' => ['nullable'],
        ]);

        $ticket = new Ticket();
        $ticket->ticket_no = $ticketNo;
        $ticket->user_id = auth()->user()->id;
        $ticket->department = auth()->user()->dept_id;
        $ticket->site = $site;
        $ticket->nature_of_problem = $nature;
        $ticket->assigned_to = $inChargeID;
        $ticket->subject = $subject;
        $ticket->description = $description;
        if($attachment != null){
            $ticket->attachment = $attachment_path;
        }
        $ticket->is_SAP = '0';
        $ticket->save();
        
        // ===================================================================================================================
        
        if($smtp->smtp_is_activated == 1){
            $hostServer = $smtp->smtp_server;
            $name = $smtp->smtp_name;
            $username = $smtp->smtp_username;
            $password = $smtp->smtp_password;
            $port = $smtp->smtp_port;
            $emailto = $incharge->email;
        
            try {
                $mail = new PHPMailer(true);
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = "$hostServer";                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = "$username";                     //SMTP username
                $mail->Password   = "$password";                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom("$username", "$name");
                $mail->addAddress("$emailto");     //Add a recipient
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Ticketing System - New Ticket - '.$ticketNo;
                $mail->Body    = 'Dear '.$incharge->name.',<br><br>You have a new ticket that was assign to you.<br><br>The Ticket number is: '.$ticketNo.'<br>Please login to IT Ticketing System for the details of this incidents.<br><br>Kind regards,<br>IT Department<br><br><br><i>Note: Please do not reply to this email, this is auto generated email.</i>';
            
                $mail->send();

                return redirect()->route('ticket.index');
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }else{
            return redirect()->route('ticket.index');
        }

        // ===================================================================================================================
    }

    public function createForIT(){
        $cats = DB::select('SELECT * FROM ticket_categories ORDER BY ticket_categories.name ASC');
        $dic = (DB::table('dept_in_charges')->first())->dept_id;
        $users = User::with('site_row', 'department_row')->where('id', '!=', 1)->orderBy('name', 'asc')->get();
        $dic_users = User::with('site_row', 'department_row')->where('id', '!=', 1)->where('dept_id', $dic)->orderBy('name', 'asc')->get();

        return view('ticketing.create-ticket', compact('cats', 'users', 'dic', 'dic_users'));
    }

    public function storeForIT(Request $request){
        $nature = $request->nature;
        $user = $request->user;
        $user_dept = (DB::table('users')->where('id', $user)->first())->dept_id;
        $site = DB::table('sites')->where('id', Auth::user()->site)->first()->name;
        $subject = $request->subject;
        $description = $request->description;
        $status = $request->status;
        $attachment = $request->attachment;
        $assigned_to = $request->assigned_to;

        if($status == 'DONE'){
            $resolution = $request->resolution;
        }

        $request->validate([
            'subject' => ['required'],
            'description' => ['required'],
            // 'resolution' => ['required'],
            'attachment' => ['nullable'],
        ]);

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

        if($attachment != null){
            $filename = date('Ymd') . '-' . $ticketNo . '.' . $request->file('attachment')->getClientOriginalExtension();
            $path = "attachments/";
            $attachment_path = $path . $filename;
            $request->file('attachment')->move(public_path('storage/'.$path), $filename);
        }

        // $attPath = null;
        // if($attachment != null){
        //     $unique = Str::random(12);
        //     $attPath = $request->file('attachment')->storeAs('attachments/'.date('mY'), date('Ymd') . '-' . $ticketNo . '.' . $request->file('attachment')->getClientOriginalExtension(), 'public');
        // }

        $ticket = new Ticket();
        $ticket->ticket_no = $ticketNo;
        $ticket->user_id = $user;
        $ticket->department = $user_dept;
        $ticket->site = $site;
        $ticket->nature_of_problem = $nature;
        if($assigned_to != null){
            $ticket->assigned_to = $assigned_to;
        }else{
            $ticket->assigned_to = auth()->user()->id;
        }
        $ticket->subject = $subject;
        $ticket->description = $description;
        if($status == 'DONE'){
            $ticket->resolution = $resolution;
            if($assigned_to != null){
                $ticket->done_by = $assigned_to;
            }else{
                $ticket->done_by = auth()->user()->id;
            }
            $ticket->start_date_time = date('Y-m-d H:i:s');
            $ticket->end_date_time = date('Y-m-d H:i:s');
        }else if($status == 'ONGOING'){
            $ticket->start_date_time = date('Y-m-d H:i:s');
        }
        if($attachment != null){
            $ticket->attachment = $attachment_path;
        }
        $ticket->status = $status;
        $ticket->is_SAP = '0';
        $ticket->save();

        return redirect()->route('ticket.index');
    }

    public function update(Request $request){
        $id = $request->ticketID;
        $status = $request->ticketStatus;
        $ticketUpdate = date('F j, Y h:i A') . ' - ' . Auth::user()->name . "\n" . $request->ticketUpdate . "\n";
        $deptInCharge = (DB::table('dept_in_charges')->where('id', 1)->first())->dept_id;
        
        $smtp = DB::table('settings')->where('id', 1)->first();
        $thisTicket = Ticket::where('id', $id)->first();
        $req = DB::table('users')->where('id', $thisTicket->user_id)->first();
        
        $isReassign = $request->isReassign;

        if($isReassign == 1){
            $assigned_to = $request->assigned_to;
            $thisTicket->assigned_to = $assigned_to;
            $thisTicket->save();
        }else{
            if($status == 'PENDING'){
                if($request->isCancel == '1'){
                    $ticket = Ticket::where('id', $id)->first();
                    $ticket->status = "CANCELLED";
                    $ticket->assigned_to = auth()->user()->id;
                    $ticket->save();
                }else{
                    $ticket = Ticket::where('id', $id)->first();
                    $ticket->status = "ONGOING";
                    $ticket->start_date_time = date('Y-m-d H:i:s');
                    $ticket->save();
    
                    // SMTP
                        if($smtp->smtp_is_activated == 1){
                            $hostServer = $smtp->smtp_server;
                            $name = $smtp->smtp_name;
                            $username = $smtp->smtp_username;
                            $password = $smtp->smtp_password;
                            $port = $smtp->smtp_port;
                            $emailto = $req->email;
                            $reqName = $req->name;
                            $ticketNo = $thisTicket->ticket_no;
    
                            try {
                                $mail = new PHPMailer(true);
                                //Server settings
                                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                                $mail->isSMTP();                                            //Send using SMTP
                                $mail->Host       = "$hostServer";                     //Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                $mail->Username   = "$username";                     //SMTP username
                                $mail->Password   = "$password";                               //SMTP password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                $mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                            
                                //Recipients
                                $mail->setFrom("$username", "$name");
                                $mail->addAddress("$emailto");     //Add a recipient
                            
                                //Content
                                $mail->isHTML(true);                                  //Set email format to HTML
                                $mail->Subject = 'Ticketing System - Ticket Update - '.$ticketNo;
                                $mail->Body    = 'Dear '.$reqName.',<br><br>Ticket Status: <b>ONGOING</b><br><br>The status of your ticket has been updated as shown above.<br><br>You can check on the status of your ticket at any time by logging into IT Ticketing System.<br><br>If you have any questions, please feel free to contact us at local 406<br><br><br>Kind regards,<br>IT Department<br><br><br><i>Note: Please do not reply to this email, this is auto generated email.</i>';
                            
                                $mail->send();
    
                                return redirect()->route('ticket.index');
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }
                        }
                    // SMTP
                }
            }else if($status == 'ONGOING'){
                if($request->isCancel == '1'){
                    $ticket = Ticket::where('id', $id)->first();
                    $ticket->status = "CANCELLED";
                    $ticket->assigned_to = auth()->user()->id;
                    $ticket->save();
                }else if($request->isUpdate == '1'){
                    $ticket = Ticket::where('id', $id)->first();
                    if($ticket->update != null){
                        $ticket_update = $ticket->update;
                        $ticket->update = $ticket_update . "\n" . $ticketUpdate;
                    }else{
                        $ticket->update = $ticketUpdate;
                    }
                    $ticket->save();
                }else{
                    $request->validate([
                        'ticketResolution' => 'required',
                    ]);
                    $attachment = $request->attachment;
                    
                    $ticket = Ticket::where('id', $id)->first();
                    $ticket->status = "DONE";
                    $ticket->done_by = auth()->user()->id;
                    $ticket->resolution = $request->ticketResolution;
                    if($attachment != null){
                        $filename = date('Ymd-His') . '-' . $ticket->ticket_no . '.' . $request->file('attachment')->getClientOriginalExtension();
                        $path = "storage/attachments/";
                        $attachment_path = $path . $filename;
                        $request->file('attachment')->move(public_path($path), $filename);
                        $ticket->resolution_attachment = $attachment_path;
                    }
                    $ticket->end_date_time = date('Y-m-d H:i:s');
                    $ticket->save();
    
                    // SMTP
                        if($smtp->smtp_is_activated == 1){
                            $hostServer = $smtp->smtp_server;
                            $name = $smtp->smtp_name;
                            $username = $smtp->smtp_username;
                            $password = $smtp->smtp_password;
                            $port = $smtp->smtp_port;
                            $emailto = $req->email;
                            $reqName = $req->name;
                            $ticketNo = $thisTicket->ticket_no;
    
                            try {
                                $mail = new PHPMailer(true);
                                //Server settings
                                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                                $mail->isSMTP();                                            //Send using SMTP
                                $mail->Host       = "$hostServer";                     //Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                $mail->Username   = "$username";                     //SMTP username
                                $mail->Password   = "$password";                               //SMTP password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                $mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                            
                                //Recipients
                                $mail->setFrom("$username", "$name");
                                $mail->addAddress("$emailto");     //Add a recipient
                            
                                //Content
                                $mail->isHTML(true);                                  //Set email format to HTML
                                $mail->Subject = 'Ticketing System - Ticket Update - '.$ticketNo;
                                $mail->Body    = 'Dear '.$reqName.',<br><br>Ticket Status: <b>DONE</b><br><br>The status of your ticket has been updated as shown above.<br><br>If you have any questions, please feel free to contact us at local 406<br><br><br>Kind regards,<br>IT Department<br><br><br><i>Note: Please do not reply to this email, this is auto generated email.</i>';
                            
                                $mail->send();
    
                                return redirect()->route('ticket.index');
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }
                        }
                    // SMTP
                }
            }
        }

        return redirect()->route('ticket.index');
    }

    public function report(){
        $deptInCharge = (DB::table('dept_in_charges')->where('id', 1)->first())->dept_id;
        $users = DB::select('SELECT * FROM users WHERE dept_id = ? AND id != ?', [$deptInCharge, 1]);
        $cats = DB::table('ticket_categories')->orderBy('name', 'desc')->get();

        $inputDateFrom = date('m/d/Y');
        $inputDateTo = date('m/d/Y');
        $cbp = 1;
        $cbo = 1;
        $cbd = 1;
        $userF = 0;
        $categoryF = 0;

        $dateFrom = date('Y-m-d').' 00:00:00.000';
        $newDateFrom = date("Y-m-d H:i:s", strtotime($dateFrom));
        $dateTo = date('Y-m-d').' 23:59:59';
        $newDateTo = date("Y-m-d H:i:s", strtotime($dateTo));

        // $tickets = DB::select("SELECT tickets.id, tickets.ticket_no, u.name AS user, departments.name AS dept, ticket_categories.name AS nature_of_problem, a.name AS assigned_to, tickets.subject, tickets.description, tickets.status, tickets.created_at, tickets.attachment, tickets.resolution FROM tickets INNER JOIN users AS u ON tickets.user_id = u.id INNER JOIN departments ON tickets.department = departments.id INNER JOIN users AS a ON tickets.assigned_to = a.id INNER JOIN ticket_categories ON tickets.nature_of_problem = ticket_categories.id WHERE tickets.created_at BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME) AND tickets.status != 'CANCELLED' ORDER BY tickets.id DESC", [$newDateFrom, $newDateTo]);

        $tickets = DB::table('tickets')
            ->select(
                'tickets.id',
                'tickets.ticket_no',
                'u.name AS user',
                'departments.name AS dept',
                'ticket_categories.name AS nature_of_problem',
                'a.name AS assigned_to',
                'd.name AS done_by',
                'tickets.subject',
                'tickets.description',
                'tickets.status',
                'tickets.is_SAP',
                'tickets.created_at',
                'tickets.attachment',
                'tickets.resolution'
            )
            ->join('users AS u', 'tickets.user_id', '=', 'u.id')
            ->join('departments', 'tickets.department', '=', 'departments.id')
            ->join('users AS a', 'tickets.assigned_to', '=', 'a.id')
            ->leftJoin('users AS d', 'tickets.done_by', '=', 'd.id')
            ->join('ticket_categories', 'tickets.nature_of_problem', '=', 'ticket_categories.id')
            ->whereBetween('tickets.created_at', [date('Y-m-d H:i:s', strtotime($newDateFrom)), date('Y-m-d H:i:s', strtotime($newDateTo))])
            ->where('tickets.status', '!=', 'CANCELLED')
            ->orderBy('tickets.id', 'DESC')
            ->get();

        $total = count($tickets);
        $pending = (DB::select("SELECT COUNT(id) AS count FROM tickets WHERE status = 'PENDING' AND created_at BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME)", [$newDateFrom, $newDateTo]))[0]->count;
        $ongoing = (DB::select("SELECT COUNT(id) AS count FROM tickets WHERE status = 'ONGOING' AND created_at BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME)", [$newDateFrom, $newDateTo]))[0]->count;
        $done = (DB::select("SELECT COUNT(id) AS count FROM tickets WHERE status = 'DONE' AND created_at BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME)", [$newDateFrom, $newDateTo]))[0]->count;


        return view('ticketing.reports', compact('tickets', 'total', 'pending', 'ongoing', 'done', 'users', 'cats', 'inputDateFrom', 'inputDateTo', 'cbp', 'cbo', 'cbd', 'userF', 'categoryF'));
    }
    
    public function genReport(Request $request){
        $deptInCharge = (DB::table('dept_in_charges')->where('id', 1)->first())->dept_id;
        $users = DB::select('SELECT * FROM users WHERE dept_id = ? AND id != ?', [$deptInCharge, 1]);
        $cats = DB::table('ticket_categories')->orderBy('name', 'desc')->get();

        $inputDateFrom = $request->dateFrom;
        $inputDateTo = $request->dateTo;


        $dateFrom = $request->dateFrom.' 00:00:00.000';
        $newDateFrom = date("Y-m-d H:i:s", strtotime($dateFrom));
        $dateTo = $request->dateTo.' 23:59:59';
        $newDateTo = date("Y-m-d H:i:s", strtotime($dateTo));
        $userF = $request->user;
        $userfilter = "";
        if($userF != 0){
            $userfilter = " AND tickets.done_by = ".$userF;
        }

        $categoryF = $request->category;
        $catfilter = "";
        if($categoryF != 0){
            $catfilter = " AND tickets.nature_of_problem = ".$categoryF;
        }
        $cbp = 0;
        $cbo = 0;
        $cbd = 0;

        
        $pending = (DB::select("SELECT COUNT(id) AS count FROM tickets WHERE status = 'PENDING' AND created_at BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME)".$userfilter.$catfilter, [$newDateFrom, $newDateTo]))[0]->count;
        $ongoing = (DB::select("SELECT COUNT(id) AS count FROM tickets WHERE status = 'ONGOING' AND created_at BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME)".$userfilter.$catfilter, [$newDateFrom, $newDateTo]))[0]->count;
        $done = (DB::select("SELECT COUNT(id) AS count FROM tickets WHERE status = 'DONE' AND created_at BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME)".$userfilter.$catfilter, [$newDateFrom, $newDateTo]))[0]->count;

        // $tickets = DB::select("SELECT tickets.id, tickets.ticket_no, u.name AS user, departments.name AS dept, ticket_categories.name AS nature_of_problem, a.name AS assigned_to, tickets.subject, tickets.description, tickets.status, tickets.created_at, tickets.attachment, tickets.resolution FROM tickets INNER JOIN users AS u ON tickets.user_id = u.id INNER JOIN departments ON tickets.department = departments.id INNER JOIN users AS a ON tickets.assigned_to = a.id INNER JOIN ticket_categories ON tickets.nature_of_problem = ticket_categories.id WHERE tickets.created_at BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME) AND tickets.status != 'CANCELLED'".$status.$userfilter.$catfilter." ORDER BY tickets.id DESC", [$newDateFrom, $newDateTo]);

        $query = DB::table('tickets')
            ->select(
                'tickets.id',
                'tickets.ticket_no',
                'u.name AS user',
                'departments.name AS dept',
                'ticket_categories.name AS nature_of_problem',
                'a.name AS assigned_to',
                'd.name AS done_by',
                'tickets.subject',
                'tickets.description',
                'tickets.status',
                'tickets.is_SAP',
                'tickets.created_at',
                'tickets.attachment',
                'tickets.resolution'
            )
            ->join('users AS u', 'tickets.user_id', '=', 'u.id')
            ->join('departments', 'tickets.department', '=', 'departments.id')
            ->join('users AS a', 'tickets.assigned_to', '=', 'a.id')
            ->leftJoin('users AS d', 'tickets.done_by', '=', 'd.id')
            ->join('ticket_categories', 'tickets.nature_of_problem', '=', 'ticket_categories.id')
            ->whereBetween('tickets.created_at', [date('Y-m-d H:i:s', strtotime($newDateFrom)), date('Y-m-d H:i:s', strtotime($newDateTo))])
            ->where('tickets.status', '!=', 'CANCELLED');
            // Add additional filters conditionally
            if(isset($request->cbPending) && !isset($request->cbOngoing) && !isset($request->cbDone)){
                $query->where('tickets.status', 'PENDING');
                $cbp = 1;
                $ongoing = 0;
                $done = 0;
            }elseif(!isset($request->cbPending) && isset($request->cbOngoing) && !isset($request->cbDone)){
                $query->where('tickets.status', 'ONGOING');
                $cbo = 1;
                $pending = 0;
                $done = 0;
            }elseif(!isset($request->cbPending) && !isset($request->cbOngoing) && isset($request->cbDone)){
                $query->where('tickets.status', 'DONE');
                $cbd = 1;
                $pending = 0;
                $ongoing = 0;
            }elseif(isset($request->cbPending) && isset($request->cbOngoing) && !isset($request->cbDone)){
                $query->where('tickets.status', '!=', 'DONE');
                $cbp = 1;
                $cbo = 1;
                $done = 0;
            }elseif(isset($request->cbPending) && !isset($request->cbOngoing) && isset($request->cbDone)){
                $query->where('tickets.status', '!=', 'ONGOING');
                $cbd = 1;
                $cbp = 1;
                $ongoing = 0;
            }elseif(!isset($request->cbPending) && isset($request->cbOngoing) && isset($request->cbDone)){
                $query->where('tickets.status', '!=', 'PENDING');
                $cbo = 1;
                $cbd = 1;
                $pending = 0;
            }else{
                // $status = "";
                $cbp = 1;
                $cbo = 1;
                $cbd = 1;
            }
            if ($userF != 0) {
                $query->where('tickets.done_by', $userF);
            }
            if ($categoryF != 0) {
                $query->where('tickets.nature_of_problem', $categoryF);
            }
            $tickets = $query->orderBy('tickets.id', 'DESC')
            ->get();

        $total = count($tickets);


        return view('ticketing.reports', compact('tickets', 'total', 'pending', 'ongoing', 'done', 'users', 'cats', 'inputDateFrom', 'inputDateTo', 'cbp', 'cbo', 'cbd', 'userF', 'categoryF'));
    }
}
