<?php

namespace App\Http\Controllers;

use App\Models\EmailRecordsDetails;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function unsubscribe(Request $request,$email)
    {
        $result = EmailRecordsDetails::where('recipients_mail', $email)->get();
        // dd($result);
        foreach($result as $data){
            $data->subscribed_or_unsubscribed = 0;
            $data->save();
        }
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
