<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadedImageController extends Controller
{
    public function getImages()
    {
        // $directory = Storage::url('public/uploads');
        // $files = Storage::files($directory);
        // dd($files);
        $fileUrl = Storage::disk('local')->files('public/uploads');
        $imageBaseUrl = [];
        foreach ($fileUrl as $key => $path) {
            array_push($imageBaseUrl, "https://emailmarketing.queleadscrm.com" . $fileUrl);
        }
        dd($imageBaseUrl);
        return response()->json(['file_url' => $imageBaseUrl]);
    }
}
