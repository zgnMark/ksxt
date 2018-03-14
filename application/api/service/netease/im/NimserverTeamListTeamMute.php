<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamListTeamMute extends Base
{

    /**
     * 获取群组禁言列表
     *
     * tid  String  是   网易云通信服务器产生，群唯一标识，创建群时会返回
     * owner   String  是   群主的accid
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *    "mutes":[ 
     *   {"nick":"nick1","accid":"user1","tid":17874,"type":0}, 
     *   {"nick":"nick2","accid":"user2","tid":17874,"type":0} 
     * ]
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.team.listTeamMute'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('获取群组禁言列表失败,[NimserverTeamListTeamMute]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
