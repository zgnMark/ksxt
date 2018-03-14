<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverHistoryQueryBroadcastMsg extends Base
{

    /**
     * 批量查询广播消息
     *
     * broadcastId  long    否   查询的起始ID，0表示查询最近的limit条。默认0。
     * limit   int 否   查询的条数，最大100。默认100。
     * type    long    否   查询的类型，1表示所有，2表示查询存离线的，3表示查询不存离线的。默认1。
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * {
     *     "code": 200,
     *     "msgs": [
     *         {
     *             "expireTime": 1505502793520,
     *             "body": "hello world 1",
     *             "createTime": 1505466793520,
     *             "isOffline": true,
     *             "broadcastId": 48174937359009,
     *             "targetOs": [
     *                 "ios",
     *                 "pc",
     *                 "aos"
     *             ]
     *         },
     *         {
     *             "expireTime": 1505502292394,
     *             "body": "hello world 2",
     *             "createTime": 1505466292394,
     *             "isOffline": true,
     *             "broadcastId": 48174921356545,
     *             "targetOs": [
     *                 "pc",
     *                 "aos",
     *                 "ios"
     *             ]
     *         }
     *     ]
     * }      
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.history.queryBroadcastMsg'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('批量查询广播消息失败,[NimserverHistoryQueryBroadcastMsg]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
