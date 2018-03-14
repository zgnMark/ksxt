<?php
/**
 * @Author     YHz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverUserUpdate extends Base
{

    /**
     * 更新网易云通信ID
     * 1.第三方帐号导入到网易云通信平台；
     * 2.注意accid，name长度以及考虑管理token。
     *
     * accid   String  是   网易云通信ID，最大长度32字符，必须保证一个
    APP内唯一（只允许字母、数字、半角下划线_、
    @、半角点以及半角-组成，不区分大小写，
    会统一小写处理，请注意以此接口返回结果中的accid为准）。
     * props   String  否   json属性，第三方可选填，最大长度1024字符
     * token   String  否   网易云通信ID可以指定登录token值，最大长度128字符，
    并更新，如果未指定，会自动生成token，并在
    创建成功后返回

     *
     * @param  [type] $params [description]
     * @return
     * [
     *  code  json 状态码 200 ok 详见状态码表
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.user.update'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('更新网易云通信ID失败,[NimserverUserUpdate]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
