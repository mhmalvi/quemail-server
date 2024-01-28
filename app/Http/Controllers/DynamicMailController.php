<?php

namespace App\Http\Controllers;

use App\Models\DynamicMail;
use Illuminate\Http\Request;
use App\Http\Requests\DynamicMailRequest;

class DynamicMailController extends Controller
{
    public function saveMail(DynamicMailRequest $request)
    {
        $mails = DynamicMail::all();
        if (count($mails) > 1) {
            $response = DynamicMail::create([
                'driver' => $request->driver,
                'host' => $request->host,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $request->password,
                'encryption' => $request->encryption,
                'from_mail_address' => $request->from_mail_address,
                'from_name' => $request->from_name,
                'user_id' => $request->user_id
            ]);
            if ($response) {
                return response()->json([
                    'message' => 'Inserted',
                    'status' => 201,
                    'data' => $response
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } else {
            return response()->json([
                'message' => "Cannot insert more than one email",
                'status' => 500
            ], 500);
        }
    }
}
