<?php

namespace App\Http\Controllers\Traits;

use EasyWeChat;
use Illuminate\Http\Request;

trait WechatService
{
    /**
     * 处理微信的请求消息.
     *
     * @param Request    $request
     * @param EasyWeChat $server
     *
     * @return string
     *
     * @internal param Wechat $wechat
     * @internal param Server $server
     * @internal param Overtrue\Wechat\Server $server
     */
    public function serve(Request $request)
    {
        Log::info('request arrived.');

        $server = EasyWeChat::server();
        $server = $this->onMsgAndEvent($server);

        Log::info('return response.');

        return $server->serve();
    }

    //可复写该方法
    protected function onMsgAndEvent($server)
    {
        $server->setMessageHandler(function ($message) {
            switch ($message->Event) {
                case 'subscribe':
                    return '欢迎关注'.self::wechatAccountName.'!';
                default:
                    break;
            }
        });

        return $server;
    }

    public function menu()
    {
        $menu = EasyWeChat::menu();
        try {
            $menu->add(self::buttons); // 请求微信服务器
            echo '设置成功！';
        } catch (\Exception $e) {
            echo '设置失败：'.$e->getMessage();
        }
    }

    public function getJsConfig(Request $request)
    {
        $js = EasyWeChat::js();
        $request->url ? $js->setUrl($request->url) : '';
        $apis = ['onMenuShareTimeline', 'onMenuShareAppMessage'];

        return $js->config($apis, $debug = env('APP_DEBUG', false), $beta = false, $json = true);
    }

    //微信支付回掉
    public function notify()
    {
        $notify = new Notify(config('wechat.app_id'), config('wechat.secret'), config('wechat.mch_id'),
            config('wechat.mch_key'));

        $transaction = $notify->verify();

        if (!$transaction) {
            $notify->reply('FAIL', 'verify transaction error');
        }

        echo $notify->reply();

        $res = $this->handlePayment($transaction);

        Log::info($res);
    }

    /**
     * 处理支付.
     *
     * @param $transaction
     */
    public function handlePayment($transaction)
    {
        return '';
    }
}
