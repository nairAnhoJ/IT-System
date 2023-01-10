<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SettingController extends Controller
{
    public function index(){
        $settings = DB::table('settings')->first();

        return view('admin.system-management.settings', compact('settings'));
    }

    public function test(Request $request){
        $hostServer = $request->hostServer;
        $username = $request->username;
        $password = $request->password;
        $name = $request->name;
        $port = $request->port;
        $reciever = $request->sendtest;

        // try {
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
            $mail->addAddress("$reciever");     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Test Email';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        
            $mail->send();
        // }





        // try {
        //     $mail = new PHPMailer(true);
        //     //Server settings
        //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        //     $mail->isSMTP();                                            //Send using SMTP
        //     $mail->Host       = "$server";                     //Set the SMTP server to send through
        //     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        //     $mail->Username   = "$username";                     //SMTP username
        //     $mail->Password   = "$password";                               //SMTP password
        //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        //     $mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
        //     //Recipients
        //     $mail->setFrom("$username", "$name");
        //     $mail->addAddress("$reciever");     //Add a recipient
        
        //     //Content
        //     $mail->isHTML(true);                                  //Set email format to HTML
        //     $mail->Subject = 'Test Email';
        //     $mail->Body    = 'This is a test email!';
        
        //     $mail->send();

        //     echo '  <div id="toast-success" class="relative left-1/2 -translate-x-1/2 flex items-center w-full max-w-xs p-4 mb-4 rounded-lg shadow text-gray-400 bg-gray-800" role="alert">
        //                 <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg bg-green-800 text-green-200">
        //                     <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        //                     <span class="sr-only">Check icon</span>
        //                 </div>
        //                 <div class="ml-3 text-sm font-normal">Test Connection Successful.</div>
        //                 <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex h-8 w-8 text-gray-500 hover:text-white bg-gray-800 hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
        //                     <span class="sr-only">Close</span>
        //                     <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        //                 </button>
        //             </div>';
        // } catch (Exception $e) {
        //     echo '  <div id="toast-error" class="relative left-1/2 -translate-x-1/2 flex items-center w-full max-w-xs p-4 mb-4 rounded-lg shadow text-gray-400 bg-gray-800" role="alert">
        //                 <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
        //                     <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        //                     <span class="sr-only">Error icon</span>
        //                 </div>
        //                 <div class="ml-3 text-sm font-normal">Test Connection Failed.</div>
        //                 <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex h-8 w-8 text-gray-500 hover:text-white bg-gray-800 hover:bg-gray-700" data-dismiss-target="#toast-error" aria-label="Close">
        //                     <span class="sr-only">Close</span>
        //                     <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        //                 </button>
        //             </div>';
        //     // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // }

    }
}
