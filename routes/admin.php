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
