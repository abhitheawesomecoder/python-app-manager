<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	$login = session('login');
    if(session('login'))
    	return redirect()->route('home');

    return view('auth.login');
});

Auth::routes();

Route::post('/upload', [App\Http\Controllers\HomeController::class, 'uploadFile'])->name('upload.file');

Route::get('/download-log', [App\Http\Controllers\HomeController::class, 'downloadLog'])->name('download.log');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/home', [App\Http\Controllers\HomeController::class, 'postindex'])->name('posthome');

Route::get('/switch-instance/{key}', [App\Http\Controllers\HomeController::class, 'switch_instance'])->name('switch.instance');

Route::post('/applogin', [App\Http\Controllers\SigninController::class, 'index'])->name('applogin');

Route::post('/applogout', [App\Http\Controllers\SigninController::class, 'logout'])->name('applogout');
