<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\MarketingMail;
use App\Models\EmailRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendMailRequest;
use App\Models\DynamicMail;
use App\Models\EmailRecordsDetails;
use Illuminate\Support\Facades\Storage;

class SendMailController extends Controller
{
    public function send_mail(SendMailRequest $request)
    {
        $file_urls=[];
        $email_content = [
            $subject = $request->subject,
            $template = $request->template,
            $email = $request->email,            
        ];
        $files = $request->file('files');
        foreach($files as $file){
            $fileName = $file->getClientOriginalName();
            $fileExt = $fileName;
            $file->move(public_path('assets/email_attachment'), $fileExt);
            $file_path = "assets/email_attachment/" . $fileExt;
            array_push($file_urls, $file_path);
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
        
        if ($request->id == 0) {
            $result = Mail::to($email)->send(new MarketingMail($email_content,$file_urls));
            $records = new EmailRecords();
            $count = 0;
            $records->sender = config('mail.from.address');
            $records->counts = $count + 1;
            $response = $records->save();
            foreach($files as $file){
                $fileName = $file->getClientOriginalName();
                unlink(public_path("/assets/email_attachment/".$fileName));
            }
            if ($response) {
                EmailRecordsDetails::create([
                    'recipients_mail' => $email,
                    'sender' => config('mail.from.address'),
                    'email_records_id' => $records->id
                ]);


                return response()->json([
                    'message' => "Mail sent",
                    'status' => 200,
                    'data' => $email,
                    'id' => $records->id
                ]);
            }
        } else {
            $result = Mail::to($email)->send(new MarketingMail($email_content,$file_urls));
            $record = EmailRecords::findOrFail($request->id);
            $record->sender = config('mail.from.address');
            $record->counts = $record->counts + 1;
            $response = $record->save();
            foreach($files as $file){
                $fileName = $file->getClientOriginalName();
                // unlink(public_path("/assets/email_attachment/".$fileName));
                unlink(public_path("/assets/email_attachment/".$fileName));
            }
            if ($response) {
                EmailRecordsDetails::create([
                    'recipients_mail' => $email,
                    'sender' => config('mail.from.address'),
                    'email_records_id' => $request->id
                ]);
                return response()->json([
                    'message' => "Mail sent",
                    'status' => 200,
                    'data' => $email,
                    'id' => $record->id
                ]);
            }
        }
    }

    public function imageUrl(Request $request)
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
