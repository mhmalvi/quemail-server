<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;

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
    return view('mails.campaign');
});


// Route::get('/images', function () {
//     // logger(request()->all());
//     // dd(request()->email);
//     DB::table('campaigns')->where('email', request()->email)->update(['open' => 1]);
//     return response()->file(public_path("11.png"));
// })->name('track_open');

Route::get('/track-mail', function () {

    DB::table('campaigns')->where('email', request()->email)->update(['click' => 1]);
    // return redirect(request()->url);
    return redirect()->away(request()->url);

})->name('track_click');
