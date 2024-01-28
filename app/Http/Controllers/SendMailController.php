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
// use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function send_mail(SendMailRequest $request)
    {
        // dd($request->all());
        // $request->validated();
        $email_content = [
            $subject = $request->subject,
            $template = $request->template,
            $email = $request->email
        ];
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

        // dd($email_content[2]);
        // $job = (new \App\Jobs\SendQueueEmail($email_content))->onQueue('send_mail');
        // $emails = $request->email;
        // dd($emails);
        // $emails = ['tanjib@quadque.tech', 'tanjibrubyat@gmail.com', 'zulker@quadque.tech'];
        // dd($emails);
        // try {
        // foreach ($emails as $key => $email) {
        // dd($value);           
// dd(config('mail.from.address'));
        if ($request->id == 0) {
            // dd(config('app.mail_from_address'));
            $result = Mail::to($email)->send(new MarketingMail($email_content));
            // dd($email);
            $records = new EmailRecords();
            $count = 0;
            $records->sender = config('mail.from.address');
            $records->counts = $count + 1;
            $response = $records->save();
            // dd(json_decode($records));
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
            $result = Mail::to($email)->send(new MarketingMail($email_content));
            $record = EmailRecords::findOrFail($request->id);
            $record->sender = config('mail.from.address');
            $record->counts = $record->counts + 1;
            $response = $record->save();
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
        // }
        // } catch (Exception $e) {
        //     return response()->json([
        //         'message' => 'Email not valid',
        //         'status' => 500,
        //         'data' => $email
        //     ], 500);
        // }
        // dispatch($job);
    }

    public function imageUrl(Request $request)
    {
        $path = $request->file('image')->store('uploads', 'public');
        return response()->json([
            'location' => "https://emailmarketing.queleadscrm.com" . Storage::url($path)
        ]);
    }
}
