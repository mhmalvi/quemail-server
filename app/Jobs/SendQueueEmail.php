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
        foreach ($this->email_content[2] as $key => $value) {
            \Mail::to($value)->send(new MarketingMail($this->email_content, $value, $this->file_urls ? $this->file_urls : ''));
        }
    }
}
