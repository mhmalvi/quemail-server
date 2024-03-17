<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\EmailHistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/view', function () {
    return view('mail.mail');
});

Route::get('/images/{id}', [EmailHistoryController::class, 'update_open_in_email_details'])->name('track_open');
Route::get('/track-mail/{id}', [EmailHistoryController::class, 'update_click_in_email_details'])->name('track_click');
// Route::get('/track-mail/{id}', function () {
//     DB::table('email_records_details')->where('email', request()->email)->update(['click' => 1]);
//     return response()->file(public_path('1x1.png'));
// })->name('track_click');

////////////////////////////////////////////////////

Route::get('/track/user/{user}', [TrackingController::class, 'track']);
