<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // logger(request()->all());
        // dd($request->query('id'));
        // DB::table('campaigns')->where('email', $request->email)->update(['open' => 1]);
        $mail = Campaign::find($request->query('id'));
        $mail->open=1;
        $res = $mail->save();
        // if($res){
            return response()->file(public_path("11.png"));
        // }else{
        //     return "failed";
        // }

    }
    public function send_mail(Request $request)
    {
        // dd($request->email);
        $id = Campaign::create([
            'email' => $request->email,
            'open' => 0,
            'click' => 0
        ]);
        // dd($id);
        Mail::to($request->email)->queue(new \App\Mail\Campaign($id->id));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampaignRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
