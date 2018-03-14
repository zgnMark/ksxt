<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomQueryMembers extends Base
{

    /**
     * 批量获取在线成员信息
     *
     * roomid   long    是   聊天室id
     * accids  JSONArray   是   ["abc","def"], 账号列表，最多200条
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * [
        *"Content-Type": "application/json; charset=utf-8"
        *{
        *  "desc": {
        *    "data": [
        *      {
        *        "roomid": 111,
        *        "accid": "abc",
        *        "nick": "cba",
        *        "type": 1,
        *        "onlineStat": true
        *      }
        *    ]
        *  },
        *  "code": 200
        *}    
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.queryMembers'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('批量获取在线成员信息失败,[NimserverChatroomQueryMembers]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
