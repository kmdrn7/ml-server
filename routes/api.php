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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function() {
    return response()->json([
        'status' => 'OK',
    ], 200);
});

Route::get('/sensor/{serial}', [
    'uses' => 'SensorController@show',
    'as' => 'api.sensor.show',
]);

Route::get('/sensor/{serial}/config', [
    'uses' => 'SensorController@config',
    'as' => 'api.sensor.config',
]);

Route::get('/sensor/{serial}/model', [
    'uses' => 'SensorController@model',
    'as' => 'api.sensor.model',
]);

Route::get('/sensor/{serial}/healthz', [
    'uses' => 'SensorController@healthz',
    'as' => 'api.sensor.healthz',
]);