<?php

namespace App\Http\Controllers;

use App\Mail\Mail;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function send_mail(Request $request)
    {
        // $details = "Hello";
        // dd($request->all());
        $email_content = [
            $subject = $request->subject,
            $template = $request->template,
            $emails = $request->email
        ];
        // dd($email_content[2]);
        // $job = (new \App\Jobs\SendQueueEmail($email_content))->onQueue('send_mail');
        $emails = $request->email;
        // dd($emails);
        // $emails = ['tanjib@quadque.tech', 'tanjibrubyat@gmail.com', 'zulker@quadque.tech'];
        // dd($emails);
        foreach ($emails as $key => $value) {
            \Mail::to($value)->queue(new Mail($email_content));
        }
        // dispatch($job);
        echo "Mail send successfully !!";
    }

    public function imageUrl(Request $request){
        dd($request->all());
    }
}
