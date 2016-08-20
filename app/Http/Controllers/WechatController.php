<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Services\Wechat\WechatService;
use App\UserAuth;
use View;

class WechatController extends Controller
{

    const buttons = [
        [
            'name'       => 'name',
            'sub_button' => [
                [
                    'type' => 'view',
                    'name' => '介绍',
                    'url'  => 'http://example.com',
                ],
            ],
        ],
        [
            'type' => 'view',
            'name' => 'view',
            'url'  => 'http://example.com',
        ],
    ];

    /**
     * @var \App\Services\Wechat\WechatService
     */
    private $wechatService;


    public function __construct(WechatService $wechatService)
    {
        $this->wechatService = $wechatService;
    }


    public function server()
    {
        return $this->wechatService->server();
    }


    public function getWechatLogin(Request $request)
    {
        $user_auth = $this->createUserAuth();

        $url = $this->redirectAfterCreate($user_auth, $request);

        return redirect($url);
    }


    public function createUserAuth()
    {
        $wechatUser = $this->wechatService->user();

        $user_auth_data = [
            'type'     => 'wechat',
            'auth_id'  => $wechatUser['openid'],
            'unionid'  => $wechatUser['unionid'],
            'nickname' => $wechatUser['nickname'],
            'avatar'   => $wechatUser['headimgurl'],
        ];
        $user_auth      = UserAuth::updateOrCreate(['type' => 'wechat', 'auth_id' => $wechatUser['openid']],
            $user_auth_data);

        return $user_auth;
    }


    public function redirectAfterCreate($user_auth, $request)
    {
        $query = [
            'openid'   => $user_auth->auth_id,
            'redirect' => $request->redirect,
        ];
        $query = http_build_query($query);

        $authUrl = env('FRONTEND').'/#!/auth/';
        $subUrl  = $user_auth->user_id ? 'wechatLogin' : 'register';

        return $authUrl.$subUrl.'?'.$query;
    }


    //可复写这个方法
    public function register($user_auth)
    {
        $user = User::create(['name' => $user_auth->nickname]);

        $user_auth->user_id = $user->id;

        $user_auth->save();

        Auth::login($user);
    }


    public function getMenu()
    {
        return $this->wechatService->addMenu(self::buttons);
    }


    public function getJsConfig(Request $request)
    {
        $data = $request->all();

        return $this->wechatService->jsConfig($data, [], env('APP_DEBUG', false));
    }


    public function getTip()
    {
        $message = '一个微信帐号只能预约一次呦,现在为您跳转到官网';
        $url     = 'http://www.szfashionweek.com';

        return View::make('tip', compact('message', 'url'));
    }
}
