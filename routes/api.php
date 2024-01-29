<?php

use App\Http\Controllers\DynamicMailController;
use App\Http\Controllers\MailTemplate;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\UploadedImageController;
use App\Http\Controllers\EmailHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/send-mail',[SendMailController::class, 'send_mail']);
Route::post('/save-template', [MailTemplate::class, 'saveTemplate']);
Route::get('/get-template', [MailTemplate::class, 'getTemplate']);
Route::post('/delete-template', [MailTemplate::class, 'destroy']);
Route::post('/update-template', [MailTemplate::class, 'updateTemplate']);
Route::post('/email-history',[EmailHistoryController::class,'emailHistory']);
Route::post('/email-history-details',[EmailHistoryController::class,'emailHistoryDetails']);

Route::post('/save-mail', [DynamicMailController::class, 'saveMail']);
Route::get('/get-mail/{user_id}', [DynamicMailController::class, 'getMail']);
Route::put('/update-mail/{id}', [DynamicMailController::class, 'updateMail']);

Route::post('/upload-image',[SendMailController::class, 'imageUrl']);
Route::get('/get-image', [UploadedImageController::class, 'getImages']);
Route::post('/delete-image', [UploadedImageController::class, 'deleteImage']);