<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverFriendUpdate extends Base
{

    /**
     * 更新好友相关信息
     *
     * accid    String  是   发起者accid
     * faccid  String  是   要修改朋友的accid
     * alias   String  否   给好友增加备注名，限制长度128
     * ex  String  否   修改ex字段，限制长度256
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
                $this->apiConf['nimserver.friend.update'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('更新好友相关信息失败,[NimserverFriendUpdate]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
