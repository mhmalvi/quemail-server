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

    public function getTemplate()
    {
        $response = Template::all();
        if ($response) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found',
                'status' => 404
            ], 404);
        }
    }

    public function destroy(Request $request)
    {
        $response = Template::find($request->id);
        if ($response) {
            $data = $response->delete();
            if ($data) {
                return response()->json([
                    'message' => 'Deleted',
                    'status' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Not found',
                    'status' => 404
                ], 404);
            }
        }
    }
}
