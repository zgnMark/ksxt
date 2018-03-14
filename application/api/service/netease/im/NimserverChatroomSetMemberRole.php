<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomSetMemberRole extends Base
{

    /**
     * 设置聊天室内用户角色
      *  roomid  long    是   聊天室id
      *  operator    String  是   操作者账号accid
      *  target  String  是   被操作者账号accid
      *  opt int 是   操作：
      *  1: 设置为管理员，operator必须是创建者 
      *  2:设置普通等级用户，operator必须是创建者或管理员 
      *  -1:设为黑名单用户，operator必须是创建者或管理员 
      *  -2:设为禁言用户，operator必须是创建者或管理员
      *  optvalue    String  是   true或false，true:设置；false:取消设置
      *  notifyExt   String  否   通知扩展字段，长度限制2048，请使用json格式
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * {
    *    "desc": {
      *      "roomid": 16,
      *      "level": 10,
      *      "accid": "zhangsan",
      *      "type": "COMMON"
      *    },
      *    "code": 200
      *  }      
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.setMemberRole'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('设置聊天室内用户角色失败,[NimserverChatroomSetMemberRole]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
