<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverUserUpdateUinfos extends Base
{

    /**
     * 更新用户名片
     *
     *accid   String  是   用户帐号，最大长度32字符，必须保证一个APP内唯一
     *name    String  否   用户昵称，最大长度64字符
     *icon    String  否   用户icon，最大长度1024字符
     *sign    String  否   用户签名，最大长度256字符
     *email   String  否   用户email，最大长度64字符
     *birth   String  否   用户生日，最大长度16字符
     *mobile  String  否   用户mobile，最大长度32字符，只支持国内号码
     *gender  int     否   用户性别，0表示未知，1表示男，2女表示女，其它会报参数错误
     *ex      String  否   用户名片扩展字段，最大长度1024字符，用户可自行扩展，建议封装成JSON字符串
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200,
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.user.updateUinfos'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('获取用户名片失败,[NimserverUserUpdateUinfos]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
