<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailRecords;
use App\Models\EmailRecordsDetails;

class EmailHistoryController extends Controller
{
    public function emailHistory(Request $request)
    {
        $records = EmailRecords::orderBy('id', 'desc')->where('user_id', $request->user_id)->paginate($request->per_page);
        if (count($records) > 0) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $records
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }

    public function emailHistoryDetails(Request $request)
    {
        $records = EmailRecordsDetails::where('email_records_id', $request->id)->orderBy('id', 'desc')->paginate($request->per_page);
        if (count($records) > 0) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $records
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }

    public function update_open_in_email_details(Request $request, $email)
    {
        $mail = EmailRecordsDetails::where('recipients_mail', $email)->update(['open' => 1]);
        return response(file_get_contents(public_path("1x1.png")));
    }
}
