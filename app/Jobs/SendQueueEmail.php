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
    protected $details;
    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $data = User::all();
        $data = $this->details;
        $emails = ['tanjib@quadque.tech', 'tanjibrubyat@gmail.com', 'zulker@quadque.tech'];
        // dd($emails);
        foreach($emails as $key=>$value){
            \Mail::to($value)->queue(new Mail($data));
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
