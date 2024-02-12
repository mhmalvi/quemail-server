<?php

namespace App\Jobs;

use App\Mail\MarketingMail;
use App\Models\DynamicMail;
use App\Models\EmailRecords;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Models\EmailRecordsDetails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email_details_id;
    public $email_content;
    public $mail;
    public $user_id;
    public $email;
    public $file_urls;
    /**
     * Create a new job instance.
     */
    public function __construct($email_details_id,$email_content, $mail,$user_id,$email, $file_urls)
    {
        $this->email_details_id = $email_details_id;
        $this->email_content = $email_content;
        $this->mail = $mail;
        $this->user_id = $user_id;
        $this->email = $email;
        $this->file_urls = $file_urls;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->mail) {
            $smtpSettings = [
                'default' => $this->mail->driver,
                'host' => $this->mail->host,
                'port' => $this->mail->port,
                'username' => $this->mail->username,
                'password' => $this->mail->password,
                'encryption' => $this->mail->encryption,
                'from_mail_address' => $this->mail->from_mail_address,
                'from_name' => $this->mail->from_name
            ];
            config([
                'mail.default' => $smtpSettings['default'],
                'mail.mailers.smtp.host' => $smtpSettings['host'],
                'mail.mailers.smtp.port' => $smtpSettings['port'],
                'mail.mailers.smtp.username' => $smtpSettings['username'],
                'mail.mailers.smtp.password' => $smtpSettings['password'],
                'mail.mailers.smtp.encryption' => $smtpSettings['encryption'],
                'mail.from.address' => $smtpSettings['from_mail_address'],
                'mail.from.name' => $smtpSettings['from_name']
            ]);
            
            Mail::to($this->email)->send(new MarketingMail($this->email_content, $this->email_details_id, $this->email, $this->file_urls ? $this->file_urls : ''));
        }
    }
}
