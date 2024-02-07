<?php

namespace App\Http\Controllers;

use App\Models\QueleadsSubscribe;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\QueleadsSubscribeRequest;
use App\Http\Requests\StoreQueleadsSubscribeRequest;
use App\Http\Requests\UpdateQueleadsSubscribeRequest;

class QueleadsSubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function subscribe(QueleadsSubscribeRequest $request)
    {
        $result = QueleadsSubscribe::create([
            'email' => $request->email
        ]);
        if ($result) {
            return response()->json([
                'message' => 'Subscribed',
                'status' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed',
                'status' => 500
            ], 500);
        }
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
    public function store(StoreQueleadsSubscribeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(QueleadsSubscribe $queleadsSubscribe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QueleadsSubscribe $queleadsSubscribe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQueleadsSubscribeRequest $request, QueleadsSubscribe $queleadsSubscribe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QueleadsSubscribe $queleadsSubscribe)
    {
        //
    }
}
