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
    public $email_content;
    public $mail;
    public $user_id;
    public $email;
    public $file_urls;
    /**
     * Create a new job instance.
     */
    public function __construct($email_content, $mail,$user_id,$email, $file_urls)
    {
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


        // dd($this->mail);
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
            $count = EmailRecords::create([
                'sender' => $this->mail->from_mail_address,
                'counts' => count($this->email_content[2]),
                'user_id' => $this->user_id
            ]);
            $result = EmailRecordsDetails::create([
                'recipients_mail' => $this->email,
                'sender' => $this->mail->from_mail_address,
                'email_records_id' => $count->id,
                'open' => 0,
                'click' => 0,
                'subscribed_or_unsubscribed' => 1
            ]);

            // dd($smtpSettings['from_mail_address']);
            // foreach ($this->email_content[2] as $key => $value) {
            // dd($this->id);
            // dd($smtpSettings['from_mail_address']);
            Mail::to($this->email)->queue(new MarketingMail($this->email_content, $result->id, $this->email, $this->file_urls ? $this->file_urls : ''));
            // }
        }



    }
}
