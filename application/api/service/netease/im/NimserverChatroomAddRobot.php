<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomAddRobot extends Base
{

    /**
     * 往聊天室内添加机器人
     *
     * roomid   long    是   聊天室id
     * accids  JSONArray   是   机器人账号accid列表，必须是有效账号，账号数量上限100个
     * roleExt String  否   机器人信息扩展字段，请使用json格式，长度4096字符
     * notifyExt   String  否   机器人进入聊天室通知的扩展字段，请使用json格式，长度2048字符
     *      *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
      *  {
      *    "desc": {
      *      "failAccids": "[\"hzzhangsan\"]",
      *      "successAccids": "[\"hzlisi\"]"
      *    },
      *    "code": 200
      *  }   
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.addRobot'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('往聊天室内添加机器人失败,[NimserverChatroomAddRobot]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
