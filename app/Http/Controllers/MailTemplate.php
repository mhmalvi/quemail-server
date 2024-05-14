<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use App\Services\GetTemplateService;
use App\Services\CreateTemplateService;
use App\Services\UpdateTemplateService;
use App\Http\Requests\SaveTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;

class MailTemplate extends Controller
{
    public function saveTemplate(SaveTemplateRequest $request)
    {
        $template_data = [
            $name = $request->name,
            $template = $request->template,
            $client_id = $request->client_id
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

    public function getTemplate(GetTemplateService $getTemplateService, Request $request)
    {
        // $response = Template::all();
        $response = $getTemplateService->getTemplate($request->client_id);
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
    public function updateTemplate(UpdateTemplateRequest $request)
    {
        $template_data = [
            $name = $request->name,
            $template = $request->template,
            $id = $request->id
        ];
        $updateTemplateService = new UpdateTemplateService($template_data);
        $response = $updateTemplateService->updateTemplate();
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
