<?php
/**
 * @Author     SuJun (351699382@qq.com)
 * @time       2017-12-04
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\controller\v1;

use app\vendor\cache\Cache;

class Common extends Base
{
    //权限验证
    public function __construct()
    {
        /*
    exit(json_encode([
    "ret"  => 200,
    "msg"  => "",
    "data" => [
    "code" => 1000, //状态码，0表示正常获取，1表示用户不存在
    "msg"  => "没有权限",
    ],
    ], JSON_UNESCAPED_UNICODE));
     */

    }

    /**
     * 获取用户ID
     * @return [type] [description]
     */
    public function getUserId()
    {
        $token = input('post.token');
        $cache = new Cache();
        $user  = $cache->getSession($token, 'user');
        return $user['id'];
    }

}
