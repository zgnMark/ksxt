<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverEventSubscribeAdd extends Base
{

    /**
     * 订阅在线状态事件
     *
     * accid    String  是   事件订阅人账号
    *eventType   int 是   事件类型，固定设置为1，即 eventType=1
    *publisherAccids String  是   被订阅人的账号列表，最多100个账号，JSONArray格式。示例：["pub_user1","pub_user2"]
    *ttl long    是   有效期，单位：秒。取值范围：60～2592000（即60秒到30天）nopOpen   String  是       *桌面端在线时，移动端是否不推送：true:移动端不需要推送，false:移动端需要推送
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *  "failedAccid":[] //订阅失败的账号数组
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.event.subscribe.add'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('订阅在线状态事件失败,[NimserverEventSubscribeAdd]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
