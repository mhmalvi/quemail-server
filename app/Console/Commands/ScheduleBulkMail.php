<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\DynamicMail;
use App\Models\ScheduledMail;
use Illuminate\Console\Command;
use App\Mail\ScheduledMarketingMail;
use Illuminate\Support\Facades\Mail;

class ScheduleBulkMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-bulk-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MailSchedule';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mails = ScheduledMail::all();
        // print_r($mails);
        if ($mails) {
            foreach ($mails as $email) {
                $db_date = Carbon::parse($email->schedule)->format('Y-m-d');
                $today_date = Carbon::now()->format('Y-m-d');
                print_r($db_date); <br>
                print_r($today_date);<br>
                $db_time = Carbon::parse($email->schedule)->format('H:i');
                $today_time = Carbon::now()->format('H:i');
                print_r($db_time);<br>
                print_r($today_time);<br>
                if ($db_date <= $today_date && $email->delivery_status == 0 && $email->bounce_status == 0) {
                    if ($db_time <= $today_time) {
                        $mail = DynamicMail::where('user_id', $email->user_id)->first();
                        if ($mail) {
                            $smtpSettings = [
                                'default' => $mail->driver,
                                'host' => $mail->host,
                                'port' => $mail->port,
                                'username' => $mail->username,
                                'password' => $mail->password,
                                'encryption' => $mail->encryption,
                                'from_mail_address' => $mail->from_mail_address,
                                'from_name' => $mail->from_name
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

                            Mail::to($email->email)->send(new ScheduledMarketingMail($email->subject, $email->template, $email->id,  $email->email));
                        }
                    } else {
                        print_r('false');
                    }
                } else {
                    print_r('false');
                }
            }
        }
    }
}
