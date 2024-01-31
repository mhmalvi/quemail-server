<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\MarketingMail;
use App\Models\DynamicMail;
use App\Models\EmailRecords;
use Illuminate\Http\Request;
use App\Models\EmailRecordsDetails;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendMailRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageUploadRequest;

class SendMailController extends Controller
{
    public function send_mail(SendMailRequest $request)
    {
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
            $job = (new \App\Jobs\SendQueueEmail($email_content, $file_urls ? $file_urls : ''));
            dispatch($job);

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
