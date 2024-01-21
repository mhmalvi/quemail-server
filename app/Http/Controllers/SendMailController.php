<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function send_mail(Request $request)
    {
        $details = "Hello";

        $job = (new \App\Jobs\SendQueueEmail($details))->onQueue('send_mail')
            ->delay(now()->addSeconds(2));

        dispatch($job);
        echo "Mail send successfully !!";
    }
}
