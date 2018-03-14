<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverFriendGet extends Base
{

    /**
     * 获取好友关系
     *
     * accid    String  是   发起者accid
     * updatetime  Long    是   更新时间戳，接口返回该时间戳之后有更新的好友列表
     * createtime  Long    否   【Deprecated】定义同updatetime
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * {
     *     "code":200,
     *     "size":2,
     *     "friends":
     *     [
     *       {"createtime":1440037706987,"bidirection":true,"faccid":"t2"},
     *       {"createtime":1440037718190,"bidirection":true,"faccid":"t3","alias":"t3"}
     *     ]
     * }     
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.friend.get'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('获取好友关系,[NimserverFriendGet]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
