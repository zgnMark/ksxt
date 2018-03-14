<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverChatroomSendMsg extends Base
{

    /**
     * 发送聊天室消息
     *
     * roomid   long    是   聊天室id
     *  msgId   String  是   客户端消息id，使用uuid等随机串，msgId相同的消息会被客户端去重
     *  fromAccid   String  是   消息发出者的账号accid
     *  msgType int 是   消息类型：
     *  0: 表示文本消息， 
     *  1: 表示图片， 
     *  2: 表示语音， 
     *  3: 表示视频， 
     *  4: 表示地理位置信息，
     *  6: 表示文件，
     *  10: 表示Tips消息，
     *  100: 自定义消息类型（特别注意，对于未对接易盾反垃圾功能的应用，该类型的消息不会提交反垃圾系统检测）
     *  resendFlag  int 否   重发消息标记，0：非重发消息，1：重发消息，如重发消息会按照msgid检查去重逻辑
     *  attach  String  否   消息内容，格式同消息格式示例中的body字段,长度限制4096字符
     *  ext String  否   消息扩展字段，内容可自定义，请使用JSON格式，长度限制4096字符
     *  antispam    String  否   对于对接了易盾反垃圾功能的应用，本消息是否需要指定经由易盾检测的内容（antispamCustom）。
     *  true或false, 默认false。
     *  只对消息类型为：100 自定义消息类型 的消息生效。
     *  antispamCustom  String  否   在antispam参数为true时生效。
     *  自定义的反垃圾检测内容, JSON格式，长度限制同body字段，不能超过5000字符，要求antispamCustom格式如下：
     *  {"type":1,"data":"custom content"}
     *  字段说明：
     *  1. type: 1：文本，2：图片。
     *  2. data: 文本内容or图片地址。
     *  skipHistory int 否   是否跳过存储云端历史，0：不跳过，即存历史消息；1：跳过，即不存云端历史；默认0
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *  {
     *    "code":200,
     *    "desc":{
     *      "time": "1456396333115", 
     *      "fromAvator":"http://b12026.nos.netease.com/MTAxMTAxMA==/bmltYV84NDU4OF8xNDU1ODczMjA2NzUwX2QzNjkxMjI2LWY2NmQtNDQ3Ni0E2LTg4NGE4MDNmOGIwMQ==",
     *      "msgid_client": "c9e6c306-804f-4ec3-b8f0-573778829419",
     *      "fromClientType": "REST",
     *      "attach": "This+is+test+msg",
     *      "roomId": "36",
     *      "fromAccount": "zhangsan",
     *      "fromNick": "张三",
     *      "type": "0",
     *      "ext": ""
     *    } 
      *  }    
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.chatroom.sendMsg'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('发送聊天室消息失败,[NimserverChatroomSendMsg]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
