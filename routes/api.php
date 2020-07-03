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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/notifications', 'Api\NotificationController');

    Route::get('/businesses/search', 'Api\BusinessesController@index');
    Route::get('/businesses/search/phone', 'Api\BusinessesController@index');
    Route::get('/businesses/{id}', 'Api\BusinessesController@index');
    Route::get('/businesses/{id}/reviews', 'Api\BusinessesController@index');
    Route::get('/businesses/matches', 'Api\BusinessesController@index');
});

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
