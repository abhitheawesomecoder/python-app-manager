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

Route::post('/update-process', [App\Http\Controllers\HomeController::class, 'getProcessId'])->name('get.processid');

Route::post('/run-process', [App\Http\Controllers\HomeController::class, 'runprocess'])->name('run.process');

Route::post('/kill-process', [App\Http\Controllers\HomeController::class, 'killprocess'])->name('kill.process');

Route::post('/upload', [App\Http\Controllers\HomeController::class, 'uploadFile'])->name('upload.file');

Route::post('/get-log', [App\Http\Controllers\HomeController::class, 'getLog'])->name('get.log');

Route::get('/download-log', [App\Http\Controllers\HomeController::class, 'downloadLog'])->name('download.log');

Route::get('/download-config', [App\Http\Controllers\HomeController::class, 'downloadConfig'])->name('download.config');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/home', [App\Http\Controllers\HomeController::class, 'postindex'])->name('posthome');

Route::get('/switch-instance/{key}', [App\Http\Controllers\HomeController::class, 'switch_instance'])->name('switch.instance');

Route::post('/applogin', [App\Http\Controllers\SigninController::class, 'index'])->name('applogin');

Route::post('/applogout', [App\Http\Controllers\SigninController::class, 'logout'])->name('applogout');
