<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverFriendAdd extends Base
{

    /**
     * 加好友
     *
     * accid    String  是   加好友发起者accid
     *  faccid  String  是   加好友接收者accid
     *  type    int 是   1直接加好友，2请求加好友，3同意加好友，4拒绝加好友
     *  msg String  否   加好友对应的请求消息，第三方组装，最长256字符
     *
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
                $this->apiConf['nimserver.friend.add'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('加好友,[NimserverFriendAdd]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
