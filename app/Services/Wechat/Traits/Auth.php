<?php

namespace App\Services\Wechat\Traits;

use Overtrue\LaravelSocialite\Socialite;

trait Auth
{
    /**
     * @param WechatAuth $auth
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function user()
    {
        return session('wechat.oauth_user')->original;
    }


    public function redirestToOpenWechat()
    {
        return Socialite::driver('wechat')->scopes(['snsapi_login'])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleOpenWehcatCallback()
    {
        $user = Socialite::driver('wechat')->user();
        dd($user);
        // $user->token;
    }


}
