<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverEventSubscribeDelete extends Base
{

    /**
     * 取消在线状态事件订阅
     *
     * accid    String  是   事件订阅人账号
     * eventType   int 是   事件类型，固定设置为1，即 eventType=1
     * publisherAccids String  是        * 取消被订阅人的账号列表，最多100个账号，JSONArray格式。示例：["pub_user1","pub_user2"]
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *  "failedAccid":[] //取消订阅失败的账号数组
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.event.subscribe.delete'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('取消在线状态事件订阅失败,[NimserverEventSubscribeDelete]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
