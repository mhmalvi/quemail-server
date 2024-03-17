<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function track(Request $request, User $user)
    {
        // function defined above
    }

    public function track(Request $request, User $user)
    {
        // A simple way to handle the user tracking
        $user->tracked = true;
        $user->save();

        // A simple way to return an image back to the user's email client
        return redirect()->secure(env('APP_URL') . '/images/1x1.png');
    }
}
