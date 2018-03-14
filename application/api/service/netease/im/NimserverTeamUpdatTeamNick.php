<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamUpdatTeamNick extends Base
{

    /**
     * 修改群昵称
     *
     * tid  String  是   群唯一标识，创建群时网易云通信服务器产生并返回
     * owner   String  是   群主 accid
     * accid   String  是   要修改群昵称的群成员 accid
     * nick    String  是   accid 对应的群昵称，最大长度32字符
     * custom  String  否   自定义扩展字段，最大长度1024字节
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
                $this->apiConf['nimserver.team.updateTeamNick'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('修改群昵称失败,[NimserverTeamUpdatTeamNick]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
