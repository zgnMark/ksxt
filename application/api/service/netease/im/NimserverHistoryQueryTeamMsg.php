<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverHistoryQueryTeamMsg extends Base
{

    /**
     * 群聊云端历史消息查询
     *
     * tid  String  是   群id
     * accid   String  是   查询用户对应的accid.
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
     *   "size":xxx,//总共消息条数
     *   "msgs":[各种类型的消息参见"历史消息查询返回的消息格式说明",JSONArray]
     * }    
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.history.queryTeamMsg'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('群聊云端历史消息查询失败,[NimserverHistoryQueryTeamMsg]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
