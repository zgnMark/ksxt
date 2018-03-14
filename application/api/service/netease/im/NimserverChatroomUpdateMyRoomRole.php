<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomUpdateMyRoomRole extends Base
{

    /**
     * 变更聊天室内的角色信息
     *
     * roomid   long    是   聊天室id
     * accid   String  是   需要变更角色信息的accid
     * save    boolean 否   变更的信息是否需要持久化，默认false，仅对聊天室固定成员生效
     * needNotify  boolean 否   是否需要做通知
     * notifyExt   String  否   通知的内容，长度限制2048
     * nick    String  否   聊天室室内的角色信息：昵称
     * avator  String  否   聊天室室内的角色信息：头像
     * ext String  否   聊天室室内的角色信息：开发者扩展字段
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.updateMyRoomRole'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('变更聊天室内的角色信息失败,[NimserverChatroomUpdateMyRoomRole]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
