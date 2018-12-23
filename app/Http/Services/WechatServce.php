<?php
/**
 * Created by PhpStorm.
 * User: 山岭巨人
 * Date: 2018/12/1
 * Time: 下午1:50
 */

namespace App\Http\Services;

use App\Models\User;
use Log;

class WechatServce
{

    public static function auth($code)
    {
        $getTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . config('wechat.official_account.default.app_id') . '&secret=' . config('wechat.official_account.default.secret') . '&code=' . $code . '&grant_type=authorization_code';
        $tokenRespone = file_get_contents($getTokenUrl);
        $tokenRespone = json_decode($tokenRespone, true);
        $token = $tokenRespone['access_token'];
        $getUserInfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $token . '&openid=' . config('wechat.official_account.default.app_id') . '&lang=zh_CN';
        $userInfoResponse = file_get_contents($getUserInfoUrl);
        $userInfo = json_decode($userInfoResponse, true);
        $user = User::getUserInfoByOpenId($userInfo['openid']);
        if (is_null($user)) {
            $userData['nick_name'] = $userInfo['nickname'];
            $userData['open_id'] = $userInfo['openid'];
            $userData['sex'] = $userInfo['sex'];
            $userData['city'] = $userInfo['city'];
            $userData['province'] = $userInfo['province'];
            $userData['country'] = $userInfo['country'];
            $userData['head_img'] = $userInfo['headimgurl'];
            $user = User::create($userData);
            $id = $user->id;
        } else {
            $id = $user->id;
        }
        return redirect("/draw?id=" . $id);

    }
}