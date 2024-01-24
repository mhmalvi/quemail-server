<?php

namespace App\Jobs;

use App\Mail\MarketingMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // public $email_content;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // $this->email_content = $email_content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // dd("fdfdgfrgg");
        // $data = User::all();
        // dd($this->email_content[2]);
        // $emails = $this->email_content[2];
        // dd($emails);
        // $emails = ['tanjib@quadque.tech', 'tanjibrubyat@gmail.com', 'zulker@quadque.tech'];
        // dd($emails);
        $obj = new MarketingMail();
        foreach ($emails as $key => $value) {
            \Mail::to('tanjib@quadque.tech')->send($obj);
        }

        // foreach ($data as $key => $value) {
        //     $input['email'] = $value->email;
        //     $input['name'] = $value->name;
        //     // \Mail::send('mail.Test_mail', [], function ($message) use ($input) {
        //     //     $message->to($input['email'], $input['name'])
        //     //         ->subject($input['subject']);
        //     // });
        //     Mail::to($this->details)->queue(new Mail());
        // }
    }
}
