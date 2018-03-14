<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomUpdate extends Base
{

    /**
     * 更新聊天室信息
     *
     *  roomid  long    是   聊天室id
     *  name    String  否   聊天室名称，长度限制128个字符
     *  announcement    String  否   公告，长度限制4096个字符
     *  broadcasturl    String  否   直播地址，长度限制1024个字符
     *  ext String  否   扩展字段，长度限制4096个字符
     *  needNotify  String  否   true或false,是否需要发送更新通知事件，默认true
     *  notifyExt   String  否   通知事件扩展字段，长度限制2048
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *  {
     *    "chatroom": {
     *      "roomid": 66,
     *      "valid": true,
     *      "announcement": "这是聊天室",
     *      "name": "mychatroom",
     *      "broadcasturl": "xxxxxx",
     *      "ext": "",
     *      "creator": "zhangsan"
     *    },
     *    "code": 200
     *  }      
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.update'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('更新聊天室信息失败,[NimserverChatroomUpdate]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
