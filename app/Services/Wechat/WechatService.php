<?php

namespace App\Services\Wechat;

use EasyWeChat;
use EasyWeChat\Payment\Notify;
use Illuminate\Support\Facades\Log;
use App\Services\Wechat\Traits\Auth;

class WechatService
{
    use Auth;

    const wechatAccountName = '智鸣跳绳';

    /**
     * 处理微信的请求消息.
     *
     * @param EasyWeChat $server
     *
     * @return string
     *
     * @internal param Wechat $wechat
     * @internal param Server $server
     * @internal param Overtrue\Wechat\Server $server
     */
    public function serve()
    {
        $server = $this->setMsgAndEvent(EasyWeChat::server());

        return $server->serve();
    }


    //可复写该方法
    protected function setMsgAndEvent($server)
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


    public function addMenu($buttons)
    {
        try {
            EasyWeChat::menu()->add($buttons);
            echo '设置成功！';
        } catch (\Exception $e) {
            echo '设置失败：'.$e->getMessage();
        }
    }


    public function jsConfig($option, array $apis = [], $debug = false, $beta = false, $json = true)
    {
        $js = EasyWeChat::js();
        $option['url'] ? $js->setUrl($option['url']) : '';
        $apis = $apis ? $apis : ['onMenuShareTimeline', 'onMenuShareAppMessage'];

        return $js->config($apis, $debug, $beta, $json);
    }


    //微信支付回掉
    public function notify()
    {
        $notify = new Notify(config('wechat.app_id'), config('wechat.secret'), config('wechat.mch_id'),
            config('wechat.mch_key'));

        $transaction = $notify->verify();

        if ( ! $transaction) {
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
