<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomMuteRoom extends Base
{

    /**
     * 将聊天室整体禁言
     *
     * roomid   long    是   聊天室id
     *  operator    String  是   操作者accid，必须是管理员或创建者
     *  mute    String  是   true或false
     *  needNotify  String  否   true或false，默认true
     *  notifyExt   String  否   通知扩展字段
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
      *  {
      *    "desc": {
      *      "success": true
      *    },
      *    "code": 200
      *  }     
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.muteRoom'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('将聊天室整体禁言失败,[NimserverChatroomMuteRoom]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
