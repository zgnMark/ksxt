<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamKick extends Base
{

    /**
     * 踢人出群
     *
     * tid  String  是   网易云通信服务器产生，群唯一标识，创建群时会返回，最大长度128字符
    * owner   String  是   群主的accid，用户帐号，最大长度32字符
    * member  String  是   被移除人的accid，用户账号，最大长度字符
    * attach  String  否   自定义扩展字段，最大长度512
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
                $this->apiConf['nimserver.team.kick'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('踢人出群失败,[NimserverTeamKick]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
