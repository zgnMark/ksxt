<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamQuery extends Base
{

    /**
     * 群信息与成员列表查询
     *
     * tids String  是   群id列表，如["3083","3084"]
     * ope int 是   1表示带上群成员列表，0表示不带群成员列表，只返回群信息
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * [//查询不带群成员的群列表信息
    * {
    *   "code":200,
    *   "tinfos":
    *     [
    *  {"tname":"aa","announcement":"aa","owner":"v4","maxusers":50,
    *       "joinmode":1,"tid":3083,"intro":"test","size":3, "custom":"", "mute":true},
    *  {"tname":"bb","announcement":"bb","owner":"v4","maxusers":50,
    *       "joinmode":1,"tid":3084,"intro":"test","size":3, "custom":"", "mute":false}
    *     ]
    * }
    *查询带群成员的群列表信息
    * members字段中的元素包含管理员，但不包含创建者
   * {
   *   "code":200,
   *   "tinfos":
   *     [
   *       {"tname":"aa","announcement":"aa","owner":"v4","maxusers":50,
   *       "joinmode":1,"tid":3083,"intro":"test","size":3,"custom":"",
   * "mute":true, "admins":["v3"]，"members":["v1","v2","v3"]},
   *       {"tname":"bb","announcement":"bb","owner":"v4","maxusers":50,
   *       "joinmode":1,"tid":3084,"intro":"test","size":3,"custom":"",
   * "mute":false, "admins":["v3"]，"members":["v1","v2","v3"]}
   *     ]
   * }      
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.team.query'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('群信息与成员列表查询失败,[NimserverTeamQuery]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
