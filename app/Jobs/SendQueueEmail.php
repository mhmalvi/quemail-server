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
    public $email_content;
    public $file_urls;
    /**
     * Create a new job instance.
     */
    public function __construct($email_content,$file_urls)
    {
        $this->email_content = $email_content;
        $this->file_urls = $file_urls;
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
        // $obj = new MarketingMail();
        foreach ($email_content[2] as $key => $value) {
            \Mail::to($value)->send(new MarketingMail($this->email_content, $this->file_urls ? $this->file_urls : ''));
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
