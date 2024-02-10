<?php

namespace App\Jobs;

use App\Mail\MarketingMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email_content;
    public $id;
    public $email;
    public $file_urls;
    /**
     * Create a new job instance.
     */
    public function __construct($email_content,$id,$email,$file_urls)
    {
        $this->email_content = $email_content;
        $this->id = $id;
        $this->email = $email;
        $this->file_urls = $file_urls;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        // foreach ($this->email_content[2] as $key => $value) {
            // dd($this->id);
            Mail::to($this->email)->send(new MarketingMail($this->email_content,$this->id, $this->email, $this->file_urls ? $this->file_urls : ''))->onQueue("send-mail");
        // }
    }
}
