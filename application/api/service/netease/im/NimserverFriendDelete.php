<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverFriendDelete extends Base
{

    /**
     * 删除好友
     *
     * accid   String  是   用户帐号（例如：JSONArray对应的accid串，如：["zhangsan"]，如果解析出错，会报414）（一次查询最多为200）
     * donnopOpen   String  是   桌面端在线时，移动端是否不推送：true:移动端不需要推送，false:移动端需要推送
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
                $this->apiConf['nimserver.friend.delete'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('删除好友失败,[NimserverFriendDelete]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
