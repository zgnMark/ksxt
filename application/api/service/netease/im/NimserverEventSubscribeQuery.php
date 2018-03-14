<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverEventSubscribeQuery extends Base
{

    /**
     * 查询在线状态事件订阅关系
     *
     * accid    String  是   事件订阅人账号
     * eventType   int 是   事件类型，固定设置为1，即 eventType=1
     * publisherAccids String  是   被订阅人的账号列表，最多100个账号，JSONArray格式。示例：["pub_user1","pub_user2"]
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *    "code": 200,
     * "subscribes":[
     *   {"accid":"pub_user1",//被订阅人账号
     *    "eventType":1, //事件类型
     *    "expireTime":1490341879766,  //过期时间
     *    "subscribeTime":1490255479766 //订阅时间
     *   },
     *   ...
     * ]
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.event.subscribe.query'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('查询在线状态事件订阅关系失败,[NimserverEventSubscribeQuery]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
