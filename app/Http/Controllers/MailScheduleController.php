<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledMail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ScheduleMailRequest;
use App\Models\ScheduledJobs;

// use App\Services\MailScheduleService;

class MailScheduleController extends Controller
{
    private $scheduler;
    public function __construct()
    {
        // $this->scheduler = $scheduler;
    }
    public function schedule_mail(ScheduledJobs $scheduleJob, Request $request)
    {
        DB::beginTransaction();
        try {
            $mail_count = count($request->email);
            if (isset($request->bounced_email) && count($request->bounced_email) > 0) {
                $bounce_count = count($request->bounced_email);
                $number_of_mails = $mail_count + $bounce_count;
            } else {
                $number_of_mails = $mail_count;
            }
            $scheduleJob = ScheduledJobs::create([
                'file_name' => $request->file_name,
                'schedule' => $request->schedule,
                'user_id' => $request->user_id,
                'number_of_mails' => $number_of_mails
            ]);
            // dd($scheduleJob->id);
            for ($i = 0; $i < count($request->email); $i++) {
                $scheduler = new ScheduledMail();
                if ($request->email[$i] != "undefined" || $request->subject[$i] != "undefined" || $request->email[$i] != "" || $request->subject[$i] != "") {
                    $scheduler->email = $request->email[$i];
                    // if (preg_match('/@.+\./', $request->email[$i])) {
                    //     $scheduler->bounce_status = 1; //// 1 = bounced
                    // } else {
                    $scheduler->bounce_status = 0; //// 0 = not bounced
                    // }
                    $scheduler->schedule = $request->schedule;
                    $scheduler->user_id = $request->user_id;
                    $scheduler->template = $request->template[$i];
                    $scheduler->subject = $request->subject[$i];
                    $scheduler->scheduled_jobs_id = $scheduleJob->id;
                    $scheduler->delivery_status = 0;
                    $scheduler->save();
                }
            }
            if (isset($request->bounced_email) && count($request->bounced_email) > 0) {
                for ($j = 0; $j < count($request->bounced_email); $j++) {
                    $scheduler = new ScheduledMail();
                    if ($request->bounced_email[$j] != "" || $request->bounced_email[$j] != "undefined" || $request->subject[$i] != "" || $request->subject[$i] != "undefined") {
                        $scheduler->email = $request->bounced_email[$j];
                        $scheduler->bounce_status = 1; //// 1 = bounced
                        $scheduler->schedule = $request->schedule;
                        $scheduler->user_id = $request->user_id;
                        $scheduler->scheduled_jobs_id = $scheduleJob->id;
                        $scheduler->save();
                    }
                }
            }
            DB::commit();
            return response()->json([
                'message' => 'success',
                'status' => 201
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
