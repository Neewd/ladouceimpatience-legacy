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

Route::apiResource('thematics', 'ThematicController');
Route::get('/user/{email}', 'UserController@exist');
Route::post('/email/verify/{id}', 'UserController@verifyEmail')->name('api.verficiation.verify')->middleware('signed');
Route::put('/reset/password', 'UserController@sendResetPassword');
Route::put('/modify/password', 'UserController@modifyPassword');
Route::post('/newsletter', 'NewsletterController@subscribe');
Route::put('/unsubscribe', 'NewsletterController@unsubscribe');

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('reedit-)password', 'AuthController@sendResetPassword');
