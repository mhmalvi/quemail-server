<?php

namespace App\Jobs;

use App\Mail\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email_content;
    /**
     * Create a new job instance.
     */
    public function __construct($email_content)
    {
        $this->email_content = $email_content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $data = User::all();
        // dd($this->email_content[2]);
        $emails = $this->email_content[2];
        // $emails = ['tanjib@quadque.tech', 'tanjibrubyat@gmail.com', 'zulker@quadque.tech'];
        // dd($emails);
        foreach ($emails as $key => $value) {
            \Mail::to($value)->queue(new Mail($this->email_content[0], $this->email_content[1]));
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
