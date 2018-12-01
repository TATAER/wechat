<?php
/**
 * Created by PhpStorm.
 * User: 山岭巨人
 * Date: 2018/11/29
 * Time: 下午9:16
 */

namespace App\Http\Controllers;

use App\Http\Services\WechatServce;
use Illuminate\Support\Facades\Cache;
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

    public function login(Request $request)
    {
        $code = $request->get('code');

        if (empty($code)) {
            echo "登录失败";
        } else {
            return WechatServce::auth($code);
        }

        Log::info(json_encode($request->all()));
    }

    public function test(Request $request)
    {
        echo Cache::get('111');
        Cache::put("111", "333", 70000);
        Log::info(json_encode($request->all()));
        echo 111;
    }

    public function auth()
    {
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe41f26bdfd345a05&redirect_uri=http://df.youlebaobao.com/login&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        return redirect($url);
    }

    public function draw(Request $request)
    {
        $drawList1 = [
            1=>'images/fugai/1.png',
            2=>'images/fugai/2.png',
            3=>'images/fugai/3.png',
            4=>'images/fugai/4.png',
            5=>'images/fugai/5.png',
            6=>'images/fugai/6.png',
            7=>'images/fugai/7.png',
            8=>'images/fugai/8.png',
            9=>'images/fugai/9.png',
        ];
        $drawList2 = [
            1=>'images/jieguo/1.png',
            2=>'images/jieguo/2.png',
            3=>'images/jieguo/3.png',
            4=>'images/jieguo/4.png',
            5=>'images/jieguo/5.png',
            6=>'images/jieguo/6.png',
            7=>'images/jieguo/7.png',
            8=>'images/jieguo/8.png',
            9=>'images/jieguo/9.png',
        ];

        shuffle($drawList1);
        shuffle($drawList2);
        return view('wechat/draw', ['drawList1' =>$drawList1,'drawList2' =>$drawList2]);
    }
}