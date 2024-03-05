<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledJobs;
use App\Http\Requests\ScheduledJobsFetchRequest;
use App\Http\Requests\ScheduledMailsFetchRequest;
use App\Models\ScheduledMail;

class ScheduleMailFetchController extends Controller
{
    public function scheduled_jobs_fetch(ScheduledJobsFetchRequest $request)
    {
        $scheduledJobs = ScheduledJobs::orderBy('id', 'desc')->where('user_id', $request->user_id)->paginate($request->per_page);
        if ($scheduledJobs) {
            return response()->json([
                'message' => 'message',
                'status' => 200,
                'data' => $scheduledJobs
            ], 200);
        } else {
            return response()->json([
                'message' => 'message',
                'status' => 404
            ], 404);
        }
    }

    public function scheduled_mails_fetch(ScheduledMailsFetchRequest $request)
    {
        $scheduledMails = ScheduledMail::orderBy('id', 'desc')->where('scheduled_jobs_id', $request->job_id)->where('user_id', $request->user_id)->paginate($request->per_page);
        if ($scheduledMails) {
            return response()->json([
                'message' => 'message',
                'status' => 200,
                'data' => $scheduledMails
            ], 200);
        } else {
            return response()->json([
                'message' => 'message',
                'status' => 404
            ], 404);
        }
    }
}
