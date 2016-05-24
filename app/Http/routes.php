<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
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
