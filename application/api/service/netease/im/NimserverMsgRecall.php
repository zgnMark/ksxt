<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverMsgRecall extends Base
{

    /**
     * 消息撤回
     *
     * deleteMsgid  String  是   要撤回消息的msgid
     *  timetag long    是   要撤回消息的创建时间
     *  type    int 是   7:表示点对点消息撤回，8:表示群消息撤回，其它为参数错误
     *  from    String  是   发消息的accid
     *  to  String  是   如果点对点消息，为接收消息的accid,如果群消息，为对应群的tid
     *  msg String  否   可以带上对应的描述
     *  ignoreTime  String  否   1表示忽略撤回时间检测，其它为非法参数，如果需要撤回时间检测，不填即可
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
                $this->apiConf['nimserver.msg.recall'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('消息撤回失败,[NimserverMsgRecall]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
