<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamMutTeam extends Base
{

    /**
     * 修改消息提醒开关
     *
     * tid  String  是   网易云通信服务器产生，群唯一标识，创建群时会返回
     *  accid   String  是   要操作的群成员accid
     *  ope int 是   1：关闭消息提醒，2：打开消息提醒，其他值无效@param  [type] $params [description]
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
                $this->apiConf['nimserver.team.muteTeam'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('修改消息提醒开关失败,[NimserverTeamMutTeam]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
