<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\WechatAuth;
use App\Http\Controllers\Traits\WechatService;
use Illuminate\Http\Request;
use App\Http\Requests;


class WechatController extends Controller
{
    use WechatAuth, WechatService;

    /**
     * Where to redirect users after wechat login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $wechatLoginUrl = 'wechat/login';

    const wechatAccountName = '测试帐号';

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
}
