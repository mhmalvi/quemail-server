<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadedImageController extends Controller
{
    public function getImages()
    {
        $fileUrl = Storage::files('public/uploads');
        // dd($fileUrl);
        $fileUrl = str_replace('public', 'storage', $fileUrl);
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
                'file_url' => $imageBaseUrl
            ], 200);
        } else {
            return response()->json([
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }
}
