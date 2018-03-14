<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomQueueList extends Base
{

    /**
     * 排序列出队列中所有元素
     *
     * roomid   long    是   聊天室id
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
       * {
       *   "desc": { 
       *     "list": [ 
       *       { 
       *         "33333": "33333" 
       *       } 
       *     ] 
       *   },
       *   "code": 200
       * }     
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.queueList'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('排序列出队列中所有元素失败,[NimserverChatroomQueueList]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
