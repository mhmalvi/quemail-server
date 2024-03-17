<?php

namespace App\Http\Controllers;

use App\Models\DemoEmail;
use App\Services\tutorial\MyEmailSenderService;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    // public function track(Request $request, User $user)
    // {
    //     // function defined above
    // }
    public function sendEmail(Request $request,DemoEmail $demo, MyEmailSenderService $sender)
    {
        $demo->email = $request->email;
        $demo->save();
        $sender->sendTrackedEmail($request->email,$demo->id);
    }

    public function track(Request $request,$id)
    {
        // A simple way to handle the user tracking
        DemoEmail::find($id)->update([
            'open'=>1
        ]);

        // A simple way to return an image back to the user's email client
        return redirect()->secure('https://emailmarketing.queleadscrm.com' . '1x1.png');
    }
}
