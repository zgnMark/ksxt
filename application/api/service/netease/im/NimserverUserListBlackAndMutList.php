<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverUserListBlackAndMutList extends Base
{

    /**
     * 查看指定用户的黑名单和静音列表
     *
     * accid   String  是   用户帐号（例如：JSONArray对应的accid串，如：["zhangsan"]
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * {
     *   "mutelist": [    //被静音的帐号列表
     *     "abc",
     *     "cde"
     *   ],
     *   "blacklist": [    //加黑的帐号列表
     *     "abc"
     *   ],
     *   "code": 200
     * }       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.user.listBlackAndMuteList'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('查看指定用户的黑名单和静音列表失败,[NimserverUserListBlackAndMutList]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
