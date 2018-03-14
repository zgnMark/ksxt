<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomRequestAddr extends Base
{

    /**
     * 請求聊天室地址
     *
     * roomid   long    是   聊天室id
    *  accid   String  是   进入聊天室的账号
    *  clienttype  int 否   1:weblink（客户端为web端时使用）; 2:commonlink（客户端为非web端时使用）, 默认1
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
      * {
      *   "addr": [
      *     "testchat.netease.im:6666",
      *     "testchat.netease.im:8888"
      *   ],
      *   "code": 200
      * }      
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.requestAddr'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('請求聊天室地址失败,[NimserverChatroomRequestAddr]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
