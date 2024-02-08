<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Mail\MarketingMail;
use App\Models\DynamicMail;
use App\Models\EmailRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EmailRecordsDetails;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendMailRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageUploadRequest;

class SendMailController extends Controller
{
    public function send_mail(SendMailRequest $request)
    {
        set_time_limit(8000);
        $mail = DynamicMail::where('user_id', $request->user_id)->first();
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
        }
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

        $file_urls = [];
        $email_content = [
            $subject = $request->subject,
            $template = $request->template,
            $email = $request->email
        ];
        if ($request->file('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                $fileExt = $fileName;
                $file->move(public_path('assets/email_attachment'), $fileExt);
                $file_path = "assets/email_attachment/" . $fileExt;
                array_push($file_urls, $file_path);
            }
        }
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
            'sender' => $mail->from_mail_address,
            'counts' => count($email_content[2]),
            'user_id' => $request->user_id
        ]);
        foreach ($email_content[2] as $email) {
            $result = EmailRecordsDetails::create([
                'recipients_mail' => $email,
                'sender' => $mail->from_mail_address,
                'email_records_id' => $count->id,
                'open' => 0,
                'click' => 0,
                'subscribed_or_unsubscribed' => 1
            ]);
            $job = (new \App\Jobs\SendQueueEmail($email_content, $result->id, $email, $file_urls ? $file_urls : ''));
            dispatch($job);
        }


        return response()->json([
            'message' => "Mail sent",
            'status' => 200,
        ]);
    }

    public function imageUrl(ImageUploadRequest $request)
    {
        $path = $request->file('image')->store('uploads', 'public');
        if ($path) {
            return response()->json([
                'location' => "https://emailmarketing.queleadscrm.com" . Storage::url($path)
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed',
                'status' => 500
            ], 500);
        }
    }
}
