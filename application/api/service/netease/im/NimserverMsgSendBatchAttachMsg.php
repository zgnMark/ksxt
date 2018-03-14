<?php
/**
 * @Author      yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverMsgSendBatchAttachMsg extends Base
{

    /**
     * 批量发送点对点自定义消息
     *
      * fromAccid   String  是   发送者accid，用户帐号，最大32字符，APP内唯一
      * toAccids    String  是   ["aaa","bbb"]（JSONArray对应的accid，如果解析出错，会报414错误），最大限500人
      * attach  String  是   自定义通知内容，第三方组装的字符串，建议是JSON串，最大长度4096字符
      * pushcontent String  否   iOS推送内容，第三方自己组装的推送内容,不超过150字符
      * payload String  否   iOS推送对应的payload,必须是JSON,不能超过2k字符
      * sound   String  否       * 如果有指定推送，此属性指定为客户端本地的声音文件名，长度不要超过30个字符，如果不指定，会使用默认声音
      * save    int 否   1表示只发在线，2表示会存离线，其他会报414错误。默认会存离线
      * option  String  否   发消息时特殊指定的行为选项,      * Json格式，可用于指定消息计数等特殊行为;option中字段不填时表示默认值。
      * option示例：
      * {"badge":false,"needPushNick":false,"route":false}
      * 字段说明：
      * 1. badge:该消息是否需要计入到未读计数中，默认true;
      * 2. needPushNick: 推送文案是否需要带上昵称，不设置该参数时默认false(ps:注意与sendBatchMsg.action接口有别)。
      * 3. route: 该消息是否需要抄送第三方；默认true (需要app开通消息抄送功能)
      * 详细格式示例 看文档 http://dev.netease.im/docs/product/IM%E5%8D%B3%E6%97%B6%E9%80%9A%E8%AE%AF/%E6%9C%8D%E5%8A%A1%E7%AB%AFAPI%E6%96%87%E6%A1%A3/%E6%B6%88%E6%81%AF%E5%8A%9F%E8%83%BD
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *   "unregister":"["a","b"...]" //未注册的帐号
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.msg.sendBatchAttchMsg'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('批量发送点对点自定义通知失败,[NimserverMsgSendBatchAttachMsg]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
