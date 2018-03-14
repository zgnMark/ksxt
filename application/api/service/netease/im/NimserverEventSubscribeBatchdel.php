<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverEventSubscribeBatchdel extends Base
{

    /**
     * 取消全部在线状态事件订阅
     *
     * accid    String  是   事件订阅人账号
     * eventType   int 是   事件类型，固定设置为1，即 eventType=1
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
                $this->apiConf['nimserver.event.subscribe.batchdel'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('取消全部在线状态事件订阅失败,[NimserverEventSubscribeBatchdel]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
