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
                'count'=>count($imageBaseUrl),
                'file_url' => $imageBaseUrl
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }

    public function deleteImage(Request $request){
        $file = $request->path;
        $file_name=str_replace('https://emailmarketing.queleadscrm.com/storage/uploads/', '', $file);
        // dd($path);
        $file_path = Storage::path($file_name);
        dd($file_path);
        $response = Storage::disk('local')->delete($file_path);
        // dd($response);
    }
}
