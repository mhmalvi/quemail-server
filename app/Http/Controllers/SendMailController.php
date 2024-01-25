<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\MarketingMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendMailRequest;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function send_mail(SendMailRequest $request)
    {
        // $request->validated();
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
        try {
            foreach ($emails as $key => $email) {
                // dd($value);
                $result = Mail::to($email)->send(new MarketingMail($email_content));
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Email not valid',
                'status' => 500
            ], 500);
        }
        // dispatch($job);
        echo "Mail send successfully !!";
    }

    public function imageUrl(Request $request)
    {
        $path = $request->file('image')->store('uploads', 'public');
        return response()->json([
            'location' => "https://emailmarketing.queleadscrm.com" . Storage::url($path)
        ]);
    }
}
