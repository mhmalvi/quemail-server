<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnsubscribeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EmailRecordsDetails;

class SubscriberController extends Controller
{
    public function unsubscribe(UnsubscribeRequest $request)
    {
        $result = DB::table('email_records_details')->where('recipients_mail',
        $request->recipients_mail)->update(['subscribed_or_unsubscribed' => 1]);
        if ($result) {
            return response()->json([
                'message' => 'Unsubscribed',
                'status' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed',
                'status' => 500
            ], 500);
        }
    }
}
