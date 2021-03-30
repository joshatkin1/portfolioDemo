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
Route::post('/login', [App\Http\Controllers\api\ApiAuthenticationController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('/user', function(Request $request){
        return response( $request->user(), 200);
    });

});

