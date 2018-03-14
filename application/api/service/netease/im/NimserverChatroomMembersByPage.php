<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomMembersByPage extends Base
{

    /**
     * 分页获取成员列表
     *
     * roomid   long    是   聊天室id
     * type    int 是   需要查询的成员类型,0:固定成员;1:非固定成员;2:仅返回在线的固定成员
     * endtime long    是   单位毫秒，按时间倒序最后一个成员的时间戳,0表示系统当前时间
     * limit   long    是   返回条数，<=100
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * {
     *   "desc": {
     *     "data": [
     *        {
     *           "roomid": 111,
     *           "accid": "abc",
     *           "nick": "abc",
     *           "avator": "http://nim.nos.netease.com/MTAxMTAwMg==/bmltYV8xNzg4NTA1NF8xNDU2Mjg0NDQ3MDcyX2E4NmYzNWI5LWRhYWEtNDRmNC05ZjU1LTJhMDUyMGE5MzQ4ZA==",
     *           "ext": "ext",
     *           "type": "MANAGER",
     *           "level": 2,
     *           "onlineStat": true,
     *           "enterTime": 1487145487971,
     *           "blacklisted": true,
     *           "muted": true,
     *           "tempMuted": true,
     *           "tempMuteTtl": 120,
     *           "isRobot": true,
     *           "robotExpirAt":120
     *        }
     *     ]
     *   },
     *   "code": 200
     * }     
     * ]
     * roomid   long    聊天室id
     * accid   String  用户accid
     * nick    String  聊天室内的昵称
     * avator  String  聊天室内的头像
     * ext String  开发者扩展字段
     * type    String  角色类型：
     * UNSET（未设置），
     * LIMITED（受限用户，黑名单或禁言），
     * COMMON（普通固定成员），
     * CREATOR（创建者），
     * MANAGER（管理员），
     * TEMPORARY（临时用户,非固定成员）
     * level   int 成员级别（若未设置成员级别，则无此字段）
     * onlineStat  Boolean 是否在线
     * enterTime   long    进入聊天室的时间点
     * blacklisted Boolean 是否在黑名单中（若未被拉黑，则无此字段）
     * muted   Boolean 是否被禁言（若未被禁言，则无此字段）
     * tempMuted   Boolean 是否被临时禁言（若未被临时禁言，则无此字段）
     * tempMuteTtl long    临时禁言的解除时长,单位秒（若未被临时禁言，则无此字段）
     * isRobot Boolean 是否是聊天室机器人（若不是机器人，则无此字段）
     * robotExpirAt    int 机器人失效的时长，单位秒（若不是机器人，则无此字段）
     * 
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.membersByPage'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('获取推送状态失败,[NimserverChatroomMembersByPage]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
