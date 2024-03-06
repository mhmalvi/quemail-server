<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\DynamicMail;
use App\Models\EmailRecords;
use App\Models\ScheduledMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\ScheduledMarketingMail;
use App\Services\EmailRecordsStoreService;
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
                $records = new EmailRecords();
                $mail = DynamicMail::where('user_id', $email->user_id)->first();
                $counts = EmailRecords::where('sender', $mail->from_mail_address)->where(DB::raw('CAST(created_at as
                date)'), Carbon::now()->toDateString())->sum('counts');
                if ($counts) {
                    $counts_array = json_decode($counts);
                    if ($counts_array >= 1000) {
                        return response()->json([
                            'message' => '1000 emails sent. You cannot send any mails for today. Come back tomorrow.',
                            'status' => 305
                        ], 305);
                    }
                }
                // $records = new EmailRecords();
                $email_records = "";
                $isEmailRecordExists = EmailRecords::where('scheduled_jobs_id', $email->scheduled_jobs_id)->exists();
                if (!$isEmailRecordExists) {
                    $EmailRecordsStoreService = new EmailRecordsStoreService(
                        $mail->username,
                        $email->user_id,
                        $email->schedule,
                        $email->scheduled_jobs_id
                    );
                    $email_records = $EmailRecordsStoreService->emailRecordsStore();
                    print_r($email_records[0][id]);
                }

                
                $db_date = Carbon::parse($email->schedule)->format('Y-m-d');
                $today_date = Carbon::now()->format('Y-m-d');
                print_r($db_date);
                print_r($today_date);
                $db_time = Carbon::parse($email->schedule)->format('H:i');
                $today_time = Carbon::now()->format('H:i');
                print_r($db_time);
                print_r($today_time);
                if ($db_date <= $today_date && $email->delivery_status == 0) {
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

                            // Mail::to($email->email)->send(new ScheduledMarketingMail($email->subject, $email->template, $email->id,  $email->email));
                        }
                    }
                    // else if($email->bounce_status == 1) {
                    //     // $record = ;

                    // }
                } else {
                    print_r('false');
                }
            }
        }
    }
}
