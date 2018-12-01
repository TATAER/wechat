<?php
/**
 * Created by PhpStorm.
 * User: 山岭巨人
 * Date: 2018/11/30
 * Time: 下午5:53
 */

namespace App\Console\Commands;

use App\Common\Services\HttpService;
use Illuminate\Console\Command;

class ChangeButtonCommand extends Command
{
    protected $signature = 'changeButton:run';
    protected $description = 'changeButton';

    public function handle()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . config('wechat.official_account.default.app_id') . '&secret=' . config('wechat.official_account.default.secret');
//        $reponse = file_get_contents($url);
//        dd(json_decode($reponse, true));

        $token = '16_RbWEDCiQWxk4oDXz2FJYHYj9FG2uHj9YWS1YAuBt_Wf26jNM_5_74ozqziH3kxg5tWj4RdSsZBFSAZlrqTjz0gQO_pxvKVRW1yPqc5WSisvhFPv_A28YalRfqvRkl7BilExK568OhQsgGjbaHJMcAHAKMP';
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $token;

        $button = [
            'button' => [
                    ['name' => '去抽奖', 'type' => 'view', 'url' => 'http://www.baidu.com'],
                    ['name' => '我的', 'sub_button' => [
                            [
                                "type" => "view",
                                "name" => "搜索",
                                "url" => "http://www.soso.com/"
                            ],
                            [
                                "type" => "view",
                                "name" => "搜索",
                                "url" => "http://www.soso.com/"
                            ]
                        ]
                    ],
                    ]
        ];
        $res = HttpService::postJson($url, json_encode($button, JSON_UNESCAPED_UNICODE));
        dd($res);
    }
}
