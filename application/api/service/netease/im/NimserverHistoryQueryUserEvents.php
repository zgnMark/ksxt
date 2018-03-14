<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverHistoryQueryUserEvents extends Base
{

    /**
     * 用户登录登出事件记录查询
     *
     * accid    String  是   要查询用户的accid
     * begintime   String  是   开始时间，ms
     * endtime String  是   截止时间，ms
     * limit   int 是   本次查询的消息条数上限(最多100条),小于等于0，或者大于100，会提示参数错误
     * reverse int 否   1按时间正序排列，2按时间降序排列。其它返回参数414错误。默认是按降序排列
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     * { 
     *   "code":200, 
     *   "size":xxx,//总共记录数 
     *   "events": 
     *   [ 
     *     { 
     *       "accid":"t4",    //用户accid 
     *       "timestamp":1452058433412, //发生时间，ms 
     *       "eventType":2,    //2表示登录，3表示登出 
     *       "clientIp":"8.8.8.8", //用户clientip 
     *       "sdkVersion":12, //sdk 版本 
     *       "clientType":"IOS", //终端 
     *       "code":200    //登录成功状态，200表示成功 
     *     }, 
     *     { 
     *       "accid":"t4",    //用户accid 
     *       "timestamp":1452058381580,    //发生时间，ms 
     *       "eventType":3,    //2表示登录，3表示登出 
     *       "clientIp":"8.8.8.8", //用户clientip 
     *       "sdkVersion":12, //sdk 版本 
     *       "clientType":"IOS", //终端 
     *       "code":200    //登录成功状态，200表示成功 
     *     } 
     *   ] 
     * }    
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.history.queryUserEvents'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('用户登录登出事件记录查询失败,[NimserverHistoryQueryUserEvents]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
