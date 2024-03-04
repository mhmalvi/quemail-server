<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledMail;
use Illuminate\Support\Facades\DB;
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
        // dd(count($request->email));
        // DB::beginTransaction();
        try {
            $scheduler = new ScheduledMail();
            foreach ($request->email as $email) {
                $scheduler->email = $email;
                $scheduler->bounce_status = 1;
                $scheduler->schedule = $request->schedule;
                $scheduler->user_id = $request->user_id;
                $scheduler->save();
            }
            if ($request->bounced_email && count($request->bounced_email) > 0) {
                foreach ($request->bounced_email as $email) {
                    $scheduler->email = $email;
                    $scheduler->bounce_status = 0;
                    $scheduler->schedule = $request->schedule;
                    $scheduler->user_id = $request->user_id;
                    $scheduler->save();
                }
            }
            return response()->json([
                'message' => 'success',
                'status' => 201
            ], 201);
            // DB::commit();
        } catch (\Throwable $th) {
            // DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
