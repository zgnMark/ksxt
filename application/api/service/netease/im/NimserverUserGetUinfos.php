<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverUsergetUinfos extends Base
{

    /**
     * 获取用户名片
     * 1.第三方帐号导入到网易云通信平台；
     * 2.注意accid，name长度以及考虑管理token。
     *
     * accid   String  是   用户帐号（例如：JSONArray对应的accid串，如：["zhangsan"]，如果解析出错，会报414）（一次查询最多为200）
     * needkick String  否   是否踢掉被禁用户，true或false，默认false
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200,
     *  "uinfos":
     *     [
     *      {"email":"t1@163.com",  "accid":"t1","name":"abc","gender":1,"mobile":"18645454545"},
     *      {"accid":"t2","name":"def","gender":0}
     *     ]
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.user.getUinfos'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('获取用户名片失败,[NimserverUsergetUinfos]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
