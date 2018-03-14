<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverHistoryQueryBroadcastMsgById extends Base
{

    /**
     * 查询单条广播消息
     *
     * broadcastId  long    是   广播消息ID，应用内唯一。
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * {
     *     "code": 200,
     *     "msg": {
     *         "expireTime": 1505502793520,
     *         "body": "hello world",
     *         "createTime": 1505466793520,
     *         "isOffline": true,
     *         "broadcastId": 48174937359009,
     *         "targetOs": [
     *             "ios",
     *             "pc",
     *             "aos"
     *         ]
     *     }
     * }      
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.history.queryBroadcastMsgById'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('查询单条广播消息失败,[NimserverHistoryQueryBroadcastMsgById]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
