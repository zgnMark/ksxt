<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverUserRefreshToken extends Base
{

    /**
     * 更新并获取新Token
     *
     * accid   String  是   网易云通信ID，最大长度32字符，必须保证一个
    APP内唯一（只允许字母、数字、半角下划线_、
    @、半角点以及半角-组成，不区分大小写，
    会统一小写处理，请注意以此接口返回结果中的accid为准）。

     *
     * @param  [type] $params [description]
     * @return
     * [
     *  code  json 状态码 200 ok 详见状态码表
     *  info  json  （示例： "info":{"token":"xxx","accid":"xx" } ）
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.user.refreshToken'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('更新并获取新Token失败,[NimserverUserRefreshToken]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
