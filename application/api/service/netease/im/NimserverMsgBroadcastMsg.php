<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverMsgBroadcastMsg extends Base
{

    /**
     * 设置桌面端在线时 ， 移动端是否需要推送
     *
     * body String  是   广播消息内容，最大4096字符
     *  from    String  否   发送者accid, 用户帐号，最大长度32字符，必须保证一个APP内唯一
     *  isOffline   String  否   是否存离线，true或false，默认false
     *  ttl int 否   存离线状态下的有效期，单位小时，默认7天
     *  targetOs    String  否   目标客户端，默认所有客户端，jsonArray，格式：["ios","aos","pc","web","mac"]
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *      "msg": {
     *  "expireTime": 1505502793520,
     *  "body": "abc",
     *  "createTime": 1505466793520,
     *  "isOffline": true,
     *  "broadcastId": 48174937359009,
     *  "targetOs": [
     *      "ios",
     *      "pc",
     *      "aos"
     *  ]
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.msg.broadcastMsg'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('获取推送状态失败,[NimserverMsgBroadcastMsg]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
