<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use Exception;
use App\Mail\MarketingMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function send_mail(SendMailRequest $request)
    {
        $request->validated();
        $email_content = [
            $subject = $request->subject,
            $template = $request->template,
            $emails = $request->email
        ];
        // dd($email_content[2]);
        // $job = (new \App\Jobs\SendQueueEmail($email_content))->onQueue('send_mail');
        // $emails = $request->email;
        // dd($emails);
        // $emails = ['tanjib@quadque.tech', 'tanjibrubyat@gmail.com', 'zulker@quadque.tech'];
        // dd($emails);
        foreach ($emails as $key => $email) {
            // dd($value);
            try {
                
                $result = Mail::to($email)->send(new MarketingMail($email_content));
                // dd(Mail::flushMacros());
                if($result){
                    // dd("wrong");
                    return response()->json([
                        'message'=>'Mail sent',
                        'status'=>200,
                        'data'=> $email
                    ],200);
                }else{
                    return response()->json([
                        'message' => 'Mail sent failed',
                        'status' => 500,
                        'data' => $email
                    ], 500);
                }
            } catch (Exception $e) {
                return response()->json([
                    'message'=>'Email not valid',
                    'status'=>500
                ],500);
            }
            
            
        }
        // dispatch($job);
        echo "Mail send successfully !!";
    }

    public function imageUrl(Request $request){
        // dd($request->all());
        
    }
}
