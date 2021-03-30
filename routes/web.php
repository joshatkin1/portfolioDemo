<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

//APP USER SECTION ROUTES
Route::get('/app', [App\Http\Controllers\AppController::class, 'appView'])->name('app');

Route::get('/company/register', [App\Http\Controllers\CompanyRegisterController::class, 'companyRegisterView'])->name('companyRegister-view');
Route::post('/company/register/submit', [App\Http\Controllers\CompanyRegisterController::class, 'registerCompany'])->name('companyRegister-register');


//RESOURCES ROUTES
Route::get('/resources/app/data/session/all', [App\Http\Controllers\UserController::class, 'fetchAllSessionData']);
Route::get('/resources/app/data/session/company-link-name', [App\Http\Controllers\UserController::class, 'fetchUserSessionCompanyLinkName']);
