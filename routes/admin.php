<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest:admin'], function()
{
    Route::get('/login', [
        'uses' => 'Auth\LoginController@showLoginForm',
        'as' => 'admin.login'
    ]);
    Route::post('/login', [
        'uses' => 'Auth\LoginController@login',
        'as' => 'admin.login.post'
    ]);
});

Route::group(['middleware' => ['auth:admin']], function()
{
    Route::get('/', [
        'uses' => 'DashboardController@root',
        'as' => 'admin.dashboard.root',
    ]);
    Route::get('/logout', [
        'uses' => 'Auth\LoginController@logout',
        'as' => 'admin.logout'
    ]);
    Route::get('dashboard', [
        'uses' => 'DashboardController@index',
        'as' => 'admin.dashboard.index',
    ]);

    Route::group(['prefix' => 'util'], function(){
        Route::get('disk-info', [
            'uses' => 'DashboardController@getDiskInfo',
        ]);
    });

    Route::group(['prefix' => 'realtime-sensor'], function(){
        Route::get('/', [
            'uses' => 'RealtimeSensorController@index',
            'as' => 'admin.realtime-sensor.index',
        ]);
        Route::get('/view/{id}', [
            'uses' => 'RealtimeSensorController@show',
            'as' => 'admin.realtime-sensor.view'
        ]);
    });

    Route::group(['prefix' => 'monitor-sensor'], function(){
        Route::get('/', [
            'uses' => 'MonitorSensorController@index',
            'as' => 'admin.monitor-sensor.index',
        ]);
        Route::get('/data/{os}/{arch}', [
            'uses' => 'MonitorSensorController@data',
            'as' => 'admin.monitor-sensor.data'
        ]);
    });

    Route::group(['prefix' => 'ml-model'], function ()
    {
        Route::get('/', [
            'uses' => 'MLModelController@index',
            'as' => 'admin.ml-model.index'
        ]);
        Route::get('/datatable', [
            'uses' => 'MLModelController@get_datatable',
            'as' => 'admin.ml-model.dt'
        ]);
        Route::get('/add', [
            'uses' => 'MLModelController@create',
            'as' => 'admin.ml-model.add'
        ]);
        Route::post('/store', [
            'uses' => 'MLModelController@store',
            'as' => 'admin.ml-model.store'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'MLModelController@edit',
            'as' => 'admin.ml-model.edit'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'MLModelController@update',
            'as' => 'admin.ml-model.update'
        ]);
        Route::post('/delete', [
            'uses' => 'MLModelController@destroy',
            'as' => 'admin.ml-model.delete'
        ]);
        Route::get('/view/{id}', [
            'uses' => 'MLModelController@show',
            'as' => 'admin.ml-model.view'
        ]);
    });

    Route::group(['prefix' => 'sensor'], function ()
    {
        Route::get('/', [
            'uses' => 'SensorController@index',
            'as' => 'admin.sensor.index'
        ]);
        Route::get('/datatable', [
            'uses' => 'SensorController@get_datatable',
            'as' => 'admin.sensor.dt'
        ]);
        Route::get('/add', [
            'uses' => 'SensorController@create',
            'as' => 'admin.sensor.add'
        ]);
        Route::post('/store', [
            'uses' => 'SensorController@store',
            'as' => 'admin.sensor.store'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'SensorController@edit',
            'as' => 'admin.sensor.edit'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'SensorController@update',
            'as' => 'admin.sensor.update'
        ]);
        Route::post('/delete', [
            'uses' => 'SensorController@destroy',
            'as' => 'admin.sensor.delete'
        ]);
        Route::get('/view/{id}', [
            'uses' => 'SensorController@show',
            'as' => 'admin.sensor.view'
        ]);
    });

    Route::group(['prefix' => 'sensor-processing'], function ()
    {
        Route::get('/', [
            'uses' => 'SensorProcessingController@index',
            'as' => 'admin.sensor-processing.index'
        ]);
        Route::get('/datatable', [
            'uses' => 'SensorProcessingController@get_datatable',
            'as' => 'admin.sensor-processing.dt'
        ]);
        Route::get('/add', [
            'uses' => 'SensorProcessingController@create',
            'as' => 'admin.sensor-processing.add'
        ]);
        Route::post('/store', [
            'uses' => 'SensorProcessingController@store',
            'as' => 'admin.sensor-processing.store'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'SensorProcessingController@edit',
            'as' => 'admin.sensor-processing.edit'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'SensorProcessingController@update',
            'as' => 'admin.sensor-processing.update'
        ]);
        Route::post('/delete', [
            'uses' => 'SensorProcessingController@destroy',
            'as' => 'admin.sensor-processing.delete'
        ]);
        Route::get('/view/{id}', [
            'uses' => 'SensorProcessingController@show',
            'as' => 'admin.sensor-processing.view'
        ]);
    });

    Route::group(['prefix' => 'report-sensor', 'namespace' => 'Report'], function ()
    {
        Route::get('/', [
            'uses' => 'SensorController@index',
            'as' => 'admin.report-sensor.index'
        ]);
        Route::get('/datatable', [
            'uses' => 'SensorController@get_datatable',
            'as' => 'admin.report-sensor.dt'
        ]);
        Route::get('/view/{id}', [
            'uses' => 'SensorController@show',
            'as' => 'admin.report-sensor.view'
        ]);
        Route::get('view/{id}/datatable', [
            'uses' => 'SensorController@get_datatable_view',
            'as' => 'admin.report-sensor.dt-view'
        ]);
    });

    Route::group(['prefix' => 'data-admin'], function ()
    {
        Route::get('/', [
            'uses' => 'AdminController@index',
            'as' => 'admin.admin.index'
        ]);
        Route::get('/datatable', [
            'uses' => 'AdminController@get_datatable',
            'as' => 'admin.admin.dt'
        ]);
        Route::get('/combo', [
            'uses' => 'AdminController@combo',
            'as' => 'admin.admin.combo'
        ]);
        Route::get('/add', [
            'uses' => 'AdminController@create',
            'as' => 'admin.admin.add'
        ]);
        Route::post('/store', [
            'uses' => 'AdminController@store',
            'as' => 'admin.admin.store'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'AdminController@edit',
            'as' => 'admin.admin.edit'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'AdminController@update',
            'as' => 'admin.admin.update'
        ]);
        Route::post('/delete', [
            'uses' => 'AdminController@destroy',
            'as' => 'admin.admin.delete'
        ]);
        Route::get('/view/{id}', [
            'uses' => 'AdminController@show',
            'as' => 'admin.admin.view'
        ]);
    });

    Route::group(['prefix' => 'cache-manager'], function ()
    {
        Route::get('/', [
            'uses' => 'CacheController@index',
            'as' => 'admin.cache.index'
        ]);
        Route::get('/datatable', [
            'uses' => 'CacheController@get_datatable',
            'as' => 'admin.cache.dt'
        ]);
        Route::post('/delete', [
            'uses' => 'CacheController@destroy',
            'as' => 'admin.cache.delete'
        ]);
        Route::get('/view/{id}', [
            'uses' => 'CacheController@show',
            'as' => 'admin.cache.view'
        ]);
    });

    Route::group(['prefix' => 'konfigurasi'], function ()
    {
        Route::get('/', [
            'uses' => 'ConfigController@index',
            'as' => 'admin.config.index'
        ]);
        Route::get('/datatable', [
            'uses' => 'ConfigController@get_datatable',
            'as' => 'admin.config.dt'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'ConfigController@edit',
            'as' => 'admin.config.edit'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'ConfigController@update',
            'as' => 'admin.config.update'
        ]);
        Route::get('/view/{id}', [
            'uses' => 'ConfigController@show',
            'as' => 'admin.config.view'
        ]);
    });
});
