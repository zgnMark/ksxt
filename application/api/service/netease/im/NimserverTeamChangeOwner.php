<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamChangeOwner extends Base
{

    /**
     * 移交群主
     *
     * tid  String  是   网易云通信服务器产生，群唯一标识，创建群时会返回，最大长度128字符
     * owner   String  是   群主用户帐号，最大长度32字符
     * newowner    String  是   新群主帐号，最大长度32字符
     * leave   int 是   1:群主解除群主后离开群，2：群主解除群主后成为普通成员。其它414
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
                $this->apiConf['nimserver.team.changeOwner'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('移交群主失败,[NimserverTeamChangeOwner]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
