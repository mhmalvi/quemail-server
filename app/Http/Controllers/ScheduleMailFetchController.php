<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledJobs;
use App\Http\Requests\ScheduledJobsFetchRequest;

class ScheduleMailFetchController extends Controller
{
    public function scheduled_jobs_fetch(ScheduledJobsFetchRequest $request)
    {
        $scheduledJobs = ScheduledJobs::where('user_id', $request->user_id)->paginate($request->per_page);
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
}
