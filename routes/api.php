<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//MUST BE OUTSIDE API MIDDLEWARE GROUP
Route::post('/login', [App\Http\Controllers\ApiAuthenticationController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\ApiAuthenticationController::class, 'logout']);

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/me', function(Request $request){
        $user = json_decode($request->user());
        dd($user);
        return response($request->user(), 200);
    });

    Route::get('/verify-device', [App\Http\Controllers\DeviceVerificationController::class, 'index'])->name('device-verification');
    Route::get('verify-device/resend-code', [App\Http\Controllers\DeviceVerificationController::class, 'resendDeviceVerificationCode']);
    Route::post('/verify-device/submit', [App\Http\Controllers\DeviceVerificationController::class, 'submitDeviceVerificationCode']);

});

Route::prefix('resources')->group(function () {

    //RESOURCES ROUTES
    Route::get('/data/session/all', [App\Http\Controllers\UserController::class, 'fetchAllSessionData']);
    Route::get('/data/session/company-link-name', [App\Http\Controllers\UserController::class, 'fetchUserSessionCompanyLinkName']);
    Route::get('/data/user/company/cloud/invitations', [App\Http\Controllers\UserController::class, 'fetchAllUsersCloudInvitations']);

});
