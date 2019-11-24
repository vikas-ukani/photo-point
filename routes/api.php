<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Authentication related routes
 */
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    Route::post('/login', "AuthController@login");
    Route::post('/register', "AuthController@register");

    Route::post('/reset-password', "AuthController@resetPasswordFn");
    Route::post('/change-password', "AuthController@changePasswordFn");
    /** FIXME  Remain To Set Change Password From App */
});

/**
 * after login routes access
 */
Route::group(['middleware' => ["auth:api"]], function () {
    // pass
});
