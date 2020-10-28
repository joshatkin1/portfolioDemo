<?php

use Illuminate\Support\Facades\Route;


//FALLBACK ROUTE
Route::fallback(function () {return redirect('/home');});

Route::get('/', function () {
    return view('home');
})->name('landingPage');

Route::get('/home', function () {
    return view('home');
})->name('home');

//GENERTIC AUTH ROUTES
Auth::routes();

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

//DEVICE VERIFICATION ROUTES
Route::get('/verify-device', [App\Http\Controllers\DeviceVerificationController::class, 'index'])->name('device-verification');
Route::post('/verify-device/resend-code', [App\Http\Controllers\DeviceVerificationController::class, 'resendDeviceVerificationCode']);
Route::post('/verify-device/submit', [App\Http\Controllers\DeviceVerificationController::class, 'submitDeviceVerificationCode']);

//APP USER ROUTES
Route::get('/app', [App\Http\Controllers\AppController::class, 'index'])->name('app');
Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account');


//RESOURCES ROUTES
Route::get('/resources/app/data/session/all', [App\Http\Controllers\UserController::class, 'fetchAllSessionData']);



//RESOURCES ROUTES
Route::get('/test', [App\Http\Controllers\Controller::class, 'testFunction']);
