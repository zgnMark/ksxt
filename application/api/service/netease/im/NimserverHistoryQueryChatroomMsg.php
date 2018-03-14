<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverHistoryQueryChatroomMsg extends Base
{

    /**
     * 聊天室云端历史消息查询
     *
     * roomid   long    是   聊天室id
     * accid   String  是   用户账号
     * timetag long    是   查询的时间戳锚点，13位。reverse=1时timetag为起始时间戳，reverse=2时timetag为终止时间戳
     * limit   int 是   本次查询的消息条数上限(最多200条),小于等于0，或者大于200，会提示参数错误
     * reverse int 否   1按时间正序排列，2按时间降序排列。其它返回参数414错误。默认是2按时间降序排列
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *   "size":xxx,//总共消息条数
     * "msgs":[各种类型的消息参见"历史消息查询返回的消息格式说明",JSONArray]  //     * 其中的msgid字段为客户端消息id，对应单聊和群群云端历史消息中的msgid为服务端消息id
    *    }       
     * ]
     * 历史消息查询返回的消息格式说明 见文档 http://dev.netease.im/docs/product/IM%E5%8D%B3%E6%97%B6%E9%80%9A%E8%AE%AF/%E6%9C%8D%E5%8A%A1%E7%AB%AFAPI%E6%96%87%E6%A1%A3/%E5%8E%86%E5%8F%B2%E8%AE%B0%E5%BD%95?#%E8%81%8A%E5%A4%A9%E5%AE%A4%E4%BA%91%E7%AB%AF%E5%8E%86%E5%8F%B2%E6%B6%88%E6%81%AF%E6%9F%A5%E8%AF%A2
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.history.queryChatroomMsg'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('聊天室云端历史消息查询失败,[NimserverHistoryQueryChatroomMsg]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
