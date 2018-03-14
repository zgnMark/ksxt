<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomQueueInit extends Base
{

    /**
     * 初始化队列
     *
     *  roomid    long    是   聊天室id
     *  sizeLimit   long    是   队列长度限制，0~1000
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *  {
     *    "desc": { 
     *    },
     *    "code": 200
     *  }  
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.queueInit'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('初始化队列失败,[NimserverChatroomQueueInit]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
