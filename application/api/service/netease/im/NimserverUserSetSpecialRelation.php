<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverUserSeSpecialRelation extends Base
{

    /**
     * 设置黑名单/静音
     *
     * accid    String  是   用户帐号，最大长度32字符，必须保证一个
     * APP内唯一
     * targetAcc   String  是   被加黑或加静音的帐号
     * relationType    int 是   本次操作的关系类型,1:黑名单操作，2:静音列表操作
     * value   int 是   操作值，0:取消黑名单或静音，1:加入黑名单或静音
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
                $this->apiConf['nimserver.user.setSpecialRelation'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('设置黑名单/静音失败,[NimserverUserSeSpecialRelation]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
