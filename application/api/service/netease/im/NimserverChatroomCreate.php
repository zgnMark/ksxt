<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomCreate extends Base
{

    /**
     * 创建聊天室 ， 
     *
     * creator String  是   聊天室属主的账号accid
     * name    String  是   聊天室名称，长度限制128个字符
     * announcement    String  否   公告，长度限制4096个字符
     * broadcasturl    String  否   直播地址，长度限制1024个字符
     * ext String  否   扩展字段，最长4096字符
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * {
     *   "chatroom": {
     *     "roomid": 66,
     *     "valid": true,
     *     "announcement": null,
     *     "name": "mychatroom",
     *     "broadcasturl": "xxxxxx",
     *     "ext": "",
     *     "creator": "zhangsan"
     *   },
     *   "code": 200
     * }      
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.create'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('创建聊天室失败,[NimserverChatroomCreate]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
