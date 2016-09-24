<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'wechat'], function () {
    Route::any('serve', [
        'as'   => 'wechat.serve',
        'uses' => 'WechatController@serve',
    ]);

    Route::any('menu', ['as' => 'wechat.menu', 'uses' => 'WechatController@menu']);

    Route::group(['middleware' => ['wechat.oauth']], function () {
        Route::get('login', [
            'as'   => 'wechat.login',
            'uses' => 'WechatController@getWechatLogin',
        ]);
    });

    Route::get('js_config', [
        'as'   => 'wechat.js',
        'uses' => 'WechatController@getJsConfig',
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index');
