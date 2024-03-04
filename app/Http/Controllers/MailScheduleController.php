<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledMail;
// use App\Services\MailScheduleService;

class MailScheduleController extends Controller
{
    private $scheduler;
    public function __construct()
    {
        // $this->scheduler = $scheduler;
    }
    public function schedule_mail(Request $request)
    {
        $scheduler = new ScheduledMail();
        $scheduler->email = $request->email;
        $scheduler->bounce_status = 1;
        $scheduler->schedule = $request->schedule;
        $scheduler->user_id = $request->user_id;
        $response = $scheduler->save();
        if ($response) {
            return response()->json([
                'message' => 'success',
                'status' => 201,
                'data' => $scheduler
            ], 201);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500
            ], 500);
        }
    }
}
