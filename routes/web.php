<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie as cc;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

//FALLBACK ROUTE
Route::fallback(function () {return redirect('/');});
Route::get('/', [App\Http\Controllers\Controller::class, 'landingPage']);
//GENERTIC AUTH ROUTES
Auth::routes();
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
//DEVICE VERIFICATION ROUTES
//APP USER SECTION ROUTES
Route::get('/company/register', [App\Http\Controllers\CompanyRegisterController::class, 'companyRegisterView'])->name('companyRegister-view');
Route::post('/company/register/submit', [App\Http\Controllers\CompanyRegisterController::class, 'registerCompany'])->name('companyRegister-register');

Route::prefix('resources')->group(function () {

    //RESOURCES ROUTES
    Route::get('/app/data/session/all', [App\Http\Controllers\UserController::class, 'fetchAllSessionData']);
    Route::get('/app/data/session/company-link-name', [App\Http\Controllers\UserController::class, 'fetchUserSessionCompanyLinkName']);

});

Route::get('/app', [App\Http\Controllers\AppController::class, 'appView'])->name('app');
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'profileView'])->name('profile');
