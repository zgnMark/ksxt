<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamJoinTeams extends Base
{

    /**
     * 获取某用户所加入的群信息
     *
     * accid   String  是   用户帐号（例如：JSONArray对应的accid串，如：["zhangsan"]，如果解析出错，会报414）（一次查询最多为200）
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *      "count":2,
    *       "infos":
    *       [
    *      {"owner":"t2","tname":"test1","maxusers":50,"tid":3620,"size":3, "custom":""},
    *      {"owner":"t1","tname":"test2","maxusers":50,"tid":3622,"size":4, "custom":""}
    *      ]
    * }       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.team.joinTeams'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('获取某用户所加入的群信息失败,[NimserverTeamJoinTeams]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
