<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\DynamicMail;
use App\Models\EmailRecords;
use App\Models\ScheduledMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\ScheduledMarketingMail;
use App\Models\EmailRecordsDetails;
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
                $email_records_id = "";
                $isEmailRecordExists = EmailRecords::where('scheduled_jobs_id', $email->scheduled_jobs_id)->exists();
                if (!$isEmailRecordExists) {
                    $email_records = new EmailRecords();
                    $email_records->sender = $mail->from_mail_address;
                    $email_records->counts = 0;
                    $email_records->user_id = $email->user_id;
                    $email_records->schedule = $email->schedule;
                    $email_records->bounce = 0;
                    $email_records->scheduled_jobs_id = $email->scheduled_jobs_id;
                    $email_records->save();
                    $email_records_id = json_decode($email_records->id);
                }
                if ($isEmailRecordExists) {
                    $emailRecordsResult = EmailRecords::where(
                        'scheduled_jobs_id',
                        $email->scheduled_jobs_id
                    )->first();
                    $email_records_id = $emailRecordsResult->id;
                }
                $current_mail = ScheduledMail::where('email', $email->email)->where('scheduled_jobs_id', $email->scheduled_jobs_id)->first();
                if ($email->bounce_status == 0) {
                    $current_mail->delivery_status = 1;
                    $current_mail->save();
                }

                // dd($email_records_id);
                $email_records_details = new EmailRecordsDetails();
                $email_records_details->recipients_mail = $email->email;
                $email_records_details->sender = $mail->from_mail_address;
                $email_records_details->email_records_id = $email_records_id;
                $email_records_details->open = 0;
                $email_records_details->click = 0;
                if ($email->bounce_status == 1) {
                    $email_records_details->subscribed_or_unsubscribed = 1;
                } else {
                    $email_records_details->subscribed_or_unsubscribed = 0;
                }

                $email_records_details->schedule = $email->schedule;
                $email_records_details->bounce_status = $email->bounce_status;
                $email_records_details->save();
                $email_records->counts += 1;
                 $email_records->save();


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

                            Mail::to($email->email)->send(new ScheduledMarketingMail($email->subject, $email->template, $email->id,  $email->email));
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
