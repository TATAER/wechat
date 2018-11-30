<?php
/**
 * Created by PhpStorm.
 * User: 山岭巨人
 * Date: 2018/11/29
 * Time: 下午9:16
 */

namespace App\Http\Controllers;

use Log;

class WechatController extends Controller
{

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat.official_account');
        $wechat->server->push(function($message){
            return "欢迎关注 overtrue！";
        });

        Log::info('return response.');

        return $wechat->server->serve();//这一句是对微信进行了验证
    }
}