<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadedImageController extends Controller
{
    public function getImages()
    {
        $fileMainUrl = Storage::files('public/uploads');
        $fileUrl = str_replace('public', 'storage', $fileMainUrl);
        // dd($fileUrl);
        $imageBaseUrl = [];
        foreach ($fileUrl as $url) {
            $path = "https://emailmarketing.queleadscrm.com/" . $url;
            array_push($imageBaseUrl, $path);
        }
        if (count($imageBaseUrl) > 0) {
            return response()->json([
                'meassage' => 'success',
                'status' => 200,
                'count' => count($imageBaseUrl),
                'file_url' => $imageBaseUrl
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }

    public function deleteImage(Request $request)
    {
        $request->validate([
            'path'=>'required'
        ]);
        $file = $request->path;
        dd($file);
        $file_name = str_replace('https://emailmarketing.queleadscrm.com/storage/uploads/', '', $file);
        // dd($path);
        if (count($file_name)>0) {
            foreach($file_name as $name){
                $response = unlink(storage_path('app/public/uploads/' . $name));
                // dd($response);
                if ($response) {
                    return response()->json([
                        'message' => 'Deleted',
                        'status' => 200
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Deleted',
                        'status' => 500
                    ], 500);
                }
            }                
        } else {
            return response()->json([
                'message' => 'File not found',
                'status' => 500
            ], 500);
        }
    }
}
