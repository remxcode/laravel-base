<?php

namespace App\Http\Controllers\Traits;

use Auth;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Socialite;
use App\Models\User;
use App\Models\UserAuth;

/**
 * Class WechatAuth.
 */
trait WechatAuth
{
    use RedirectsUsers;

    /**
     * @param WechatAuth $auth
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getWechatLogin(Request $request)
    {
        $wechatUser = session('wechat.oauth_user')->original;
        $user_auth = $this->saveUserAuth($wechatUser);

        if (\App::isLocal()) {
            $server = env('APP_URL');
        }
        if ($user_auth->user_id) {
            return redirect()->intended($this->wechatLoginUrl);
        } else {
            return Redirect::to('/auth/register');
        }
    }

    public function saveUserAuth($wechatUser)
    {
        $user_auth_data = [
            'type'     => 'wechat',
            'auth_id'  => $wechatUser['openid'],
            'unionid'  => $wechatUser['unionid'],
            'nickname' => $wechatUser['nickname'],
            'avatar'   => $wechatUser['headimgurl'],
        ];
        $user_auth = UserAuth::updateOrCreate(['type' => 'wechat', 'auth_id' => $wechatUser['openid']],
            $user_auth_data);

        return $user_auth;
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
    }

    //可复写这个方法
    public function register($user_auth)
    {
        $user = User::create(['name' => $user_auth->nickname]);

        $user_auth->user_id = $user->id;

        $user_auth->save();

        Auth::login($user);
    }
}
