<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use App\Services\GetTemplateService;
use App\Services\CreateTemplateService;
use App\Http\Requests\SaveTemplateRequest;

class MailTemplate extends Controller
{
    public function saveTemplate(SaveTemplateRequest $request)
    {
        $template_data = [
            $name = $request->name,
            $template = $request->template
        ];
        $createTemplateService = new CreateTemplateService($template_data);
        $response = $createTemplateService->saveTemplate();
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

    public function getTemplate(GetTemplateService $getTemplateService)
    {
        // $response = Template::all();
        $response = $getTemplateService->getTemplate();
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
    public function updateTemplate(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'template' => 'required'
        ]);
        $template = Template::find($request->id);
        $template->name = $request->name;
        $template->template = $request->template;
        $response = $template->save();
        if ($response) {
            return response()->json([
                'message' => 'updated',
                'status' => 201,
                'data' => $template
            ], 201);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        // dd($request->all());
        $response = Template::find($request->id);
        // dd($response);
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
