<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailRecords;

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
            ],500)
        }
    }
}
