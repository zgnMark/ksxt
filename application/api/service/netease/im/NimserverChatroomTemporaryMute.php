<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomTemporaryMute extends Base
{

    /**
     * 设置临时禁言状态
     *
     *roomid    long    是   聊天室id
     *  operator    String  是   操作者accid,必须是管理员或创建者
     *  target  String  是   被禁言的目标账号accid
     *  muteDuration    long    是   0:解除禁言;>0设置禁言的秒数，不能超过2592000秒(30天)
     *  needNotify  String  否   操作完成后是否需要发广播，true或false，默认true
     *  notifyExt   String  否   通知广播事件中的扩展字段，长度限制2048字符
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
      *  {
      *    "desc": {
      *      "muteDuration": 300
      *    },
      *    "code": 200
      *  }       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.temporaryMute'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('设置临时禁言状态失败,[NimserverChatroomTemporaryMute]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
