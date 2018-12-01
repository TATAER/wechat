<?php
/**
 * Created by PhpStorm.
 * User: 山岭巨人
 * Date: 2018/11/29
 * Time: 下午9:16
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $wechat->server->push(function ($message) {
            return "欢迎关注 overtrue！";
        });

        Log::info('return response.');

        return $wechat->server->serve();//这一句是对微信进行了验证
    }

    public function auth(Request $request)
    {
        $code = $request->get('code');

        if (empty($code)) {
            echo "登录失败";
        } else {
            $getTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . config('wechat.official_account.default.app_id') . '&secret=' . config('wechat.official_account.default.secret') . '&code=' . $code . '&grant_type=authorization_code';
            $tokenRespone = file_get_contents($getTokenUrl);
            $tokenRespone = json_decode($tokenRespone, true);
            $token = $tokenRespone['access_token'];
            $getUserInfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $token . '&openid=' . config('wechat.official_account.default.app_id') . '&lang=zh_CN';
            $userInfoResponse = file_get_contents($getUserInfoUrl);
            $userInfo = json_decode($userInfoResponse, true);
            Log::info($userInfoResponse);
            return  redirect("/test");
        }

        Log::info(json_encode($request->all()));
    }

    public function test(Request $request)
    {
        Log::info(json_encode($request->all()));
        echo 111;
    }
}