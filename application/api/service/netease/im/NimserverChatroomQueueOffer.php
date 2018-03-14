<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomQueueOffer extends Base
{

    /**
     * 往聊天室有序队列中新加或更新元素
     *
     *roomid    long    是   聊天室id
     * key String  是   elementKey,新元素的UniqKey,长度限制128字符
     * value   String  是   elementValue,新元素内容，长度限制4096字符
     * operator    String  否        * 提交这个新元素的操作者accid，默认为该聊天室的创建者，若operator对应的帐号不存在，会返回404错误。
     * 若指定的operator不在线，则添加元素成功后的通知事件中的操作者默认为聊天室的创建者；若指定的operator在线，则通知事件的操  * 作者为operator。
     * transient   String  否        * 这个新元素的提交者operator的所有聊天室连接在从该聊天室掉线或者离开该聊天室的时候，提交的元素是否需要删除。 
     * true：需要删除；false：不需要删除。默认false。 
     * 当指定该参数为true时，若operator当前不在该聊天室内，则会返回403错误。
     *
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
                $this->apiConf['nimserver.chatroom.queueOffer'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('往聊天室有序队列中新加或更新元素失败,[NimserverChatroomQueueOffer]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
