<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamMutTlistAll extends Base
{

    /**
     * 将群组整体禁言
     *
     * tid  String  是   网易云通信服务器产生，群唯一标识，创建群时会返回
     * owner   String  是   群主的accid
     * mute    String  是   true:禁言，false:解禁
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
                $this->apiConf['nimserver.team.muteTlistAll'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('将群组整体禁言失败,[NimserverTeamMutTlistAll]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
