<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class MailTemplate extends Controller
{
    public function saveTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'template' => 'required'
        ]);
        $response = Template::create([
            'name' => $request->name,
            'template' => $request->template
        ]);
        if ($response) {
            return response()->json([
                'message' => 'Template saved',
                'status' => 201,
                'data' => $request->all()
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed',
                'status' => 500
            ], 500);
        }
    }
}
