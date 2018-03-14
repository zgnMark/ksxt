<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomTopn extends Base
{

    /**
     * 查询聊天室统计指标TopN
     *
     * accid   String  是   用户帐号（例如：JSONArray对应的accid串，如：["zhangsan"]，如果解析出错，会报414）（一次查询最多为200）
     * donnopOpen   String  是   桌面端在线时，移动端是否不推送：true:移动端不需要推送，false:移动端需要推送
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
        *{
        *  "code": 200,
        *  "data": [
        *    {
        *      "activeNums": 5955,       // 该聊天室内的活跃数
        *      "datetime": 1471712400,   // 统计时间点，单位秒，按天统计的是当天的0点整点；按小时统计的是指定小时的整点
        *      "enterNums": 18621,       // 进入人次数量
        *      "msgs": 2793,             // 聊天室内发生的消息数
        *      "period": "HOUR",         // 统计周期，HOUR表示按小时统计；DAY表示按天统计
        *      "roomId": 3571337         // 聊天室ID号
        *    },
        *    {
        *      "activeNums": 6047,
        *      "datetime": 1471708800,
        *      "enterNums": 15785,
        *      "msgs": 2706,
        *      "period": "HOUR",
        *      "roomId": 3573737
        *    },
        *    {
        *      "activeNums": 5498,
        *      "datetime": 1471708800,
        *      "enterNums": 14590,
        *      "msgs": 2258,
        *      "period": "HOUR",
        *      "roomId": 3513774
        *    }
        *  ]
        *}     
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.topn'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('查询聊天室统计指标TopN失败,[NimserverChatroomTopn]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
