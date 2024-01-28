<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailRecords;
use App\Models\EmailRecordsDetails;

class EmailHistoryController extends Controller
{
    public function emailHistory(Request $request){
        $records=EmailRecords::all();
        if(count($records)>0){
             return response()->json([
                 'message'=>'success',
                 'status'=>200,
                 'data'=>$records
             ],200);
        }else{
            return response()->json([
                'message'=>'failed',
                'status'=>500
            ],500);
        }
    }

    public function emailHistoryDetails(Request $request){
        $records = EmailRecordsDetails::where('email_records_id',$request->id)->get();
        if(count($records)>0){
            return response()->json([
                 'message'=>'success',
                 'status'=>200,
                 'data'=>$records
             ],200);
        }else{
            return response()->json([
                'message'=>'No data found',
                'status'=>404
            ],404);
        }
    }
}
