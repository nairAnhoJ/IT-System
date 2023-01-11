<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class TicketController extends Controller
{

    function sendEmail(){
        try {
            $mail = new PHPMailer(true);
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'test.email@toyotaforklifts-philippines.com';                     //SMTP username
            $mail->Password   = 'qdtcmovneijyrdzx';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('test.email@toyotaforklifts-philippines.com', 'Test Email');
            $mail->addAddress('it03@toyotaforklifts-philippines.com');     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Test Email';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        
            $mail->send();

            // return redirect()->route('ticket.index');

            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

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
        $incharge = (DB::table('users')->where('id', $inChargeID)->first());
        $smtp = DB::table('settings')->where('id', 1)->first();

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
        $ticket->assigned_to = $incharge->name;
        $ticket->subject = $subject;
        $ticket->description = $description;
        if($attachment != null){
            $ticket->attachment = $attPath;
        }
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
        }

        // ===================================================================================================================

        // return redirect()->route('ticket.index');
    }

    public function update(Request $request){
        $id = $request->ticketID;
        $status = $request->ticketStatus;
        
        $smtp = DB::table('settings')->where('id', 1)->first();
        $thisTicket = DB::table('tickets')->where('id', $id)->first();
        $req = DB::table('users')->where('id', $thisTicket->user_id)->first();

        if($status == 'PENDING'){
            DB::update('update tickets set status = "ONGOING", start_date_time = NOW()  where id = ?', [$id]);

            // ===================================================================================================================
                    
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

            // ===================================================================================================================

        }else if($status == 'ONGOING'){
            $request->validate([
                'ticketResolution' => 'required',
            ]);
            DB::update('update tickets set status = "DONE", resolution = ?, end_date_time = NOW()  where id = ?', [$request->ticketResolution, $id]);
        
            // ===================================================================================================================
                    
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

            // ===================================================================================================================

        }
    }
}
