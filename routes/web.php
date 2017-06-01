<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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