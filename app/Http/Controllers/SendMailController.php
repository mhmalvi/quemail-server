<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\MarketingMail;
use App\Models\EmailRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendMailRequest;
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
        // dd($email_content[2]);
        // $job = (new \App\Jobs\SendQueueEmail($email_content))->onQueue('send_mail');
        // $emails = $request->email;
        // dd($emails);
        // $emails = ['tanjib@quadque.tech', 'tanjibrubyat@gmail.com', 'zulker@quadque.tech'];
        // dd($emails);
        // try {
            // foreach ($emails as $key => $email) {
            // dd($value);           

            if ($request->id == 0) {
                // dd(config('app.mail_from_address'));
                $result = Mail::to($email)->send(new MarketingMail($email_content));
                // dd($email);
                $records = new EmailRecords();
                $count = 0;
                $records->sender = config('app.mail_from_address');
                $records->counts = $count + 1;
                $response = $records->save();
                // dd(json_decode($records));
                if ($response) {
                    EmailRecordsDetails::create([
                        'recipients_mail' => $email,
                        'sender' => config('app.mail_from_address'),
                        'email_records_id' => $records->id
                    ]);
                    return response()->json([
                        'message' => "Mail sent",
                        'status' => 200,
                        'data' => $email,
                        'id'=>$records->id
                    ]);
                }
            } else {
                $result = Mail::to($email)->send(new MarketingMail($email_content));
                $record = EmailRecords::findOrFail($request->id);
                $record->sender = config('app.mail_from_address');
                $record->counts = $record->counts + 1;
                $response = $record->save();
                if ($response) {
                    EmailRecordsDetails::create([
                        'recipients_mail' => $email,
                        'sender' => config('app.mail_from_address'),
                        'email_records_id' => $request->id
                    ]);
                    return response()->json([
                        'message' => "Mail sent",
                        'status' => 200,
                        'data' => $email
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
