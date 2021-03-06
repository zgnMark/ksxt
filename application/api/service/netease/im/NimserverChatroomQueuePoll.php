<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomQueuePoll extends Base
{

    /**
     * 从队列中取出元素
     *
     *roomid    long    是   聊天室id
     * key String  否   目前元素的elementKey,长度限制128字符，不填表示取出头上的第一个
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * {
     *   "desc": { 
     *     "value": "66666", 
     *     "key": "1111" 
     *   },
     *   "code": 200
     * }      
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.queuePoll'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('从队列中取出元素失败,[NimserverChatroomQueuePoll]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
