<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/track-mail',function(){

    DB::table('campaigns')->where('email',request()->email)->update(['click'=>1]);
    // return redirect(request()->url);
    return redirect()->away(request()->url);

})->name('track_click');
