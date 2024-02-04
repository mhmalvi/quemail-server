<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\EmailRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EmailRecordsDetails;

class EmailCounter extends Controller
{
    public function number_of_emails_sent_today(Request $request)
    {
        $counts = EmailRecords::where(DB::raw('CAST(created_at as
            date)'), Carbon::now()->toDateString())->sum('counts');
        if ($counts) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $counts
            ], 200);
        } else {
            return response()->json([
                'message' => 'No mails found',
                'status' => 404
            ], 404);
        }
    }
}
