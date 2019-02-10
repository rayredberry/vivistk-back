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


Route::middleware('cors')->group(function(){

    Route::group([

        'middleware' => 'api',
        'prefix' => 'auth'

    ], function ($router) {

        Route::post('register', 'AuthController@register');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'ResetPasswordController@resetPassword');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
        Route::post('hardcore/{user}', 'AuthController@hardcore');

        // fb

        Route::post('facebook/login', 'SocialLoginController@fbLogin');

        // google

        Route::post('google/login', 'SocialLoginController@googleLogin');

    });

});