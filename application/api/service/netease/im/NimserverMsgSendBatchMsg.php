<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverMsgSendBatchMsg extends Base
{

    /**
     * 批量发送点对点普通消息
     *
     * fromAccid    String  是   发送者accid，用户帐号，最大32字符，
      *  必须保证一个APP内唯一
      *  toAccids    String  是   ["aaa","bbb"]（JSONArray对应的accid，如果解析出错，会报414错误），限500人
      *  type    int 是   0 表示文本消息,
      *  1 表示图片，
      *  2 表示语音，
      *  3 表示视频，
      *  4 表示地理位置信息，
      *  6 表示文件，
      *  100 自定义消息类型
      *  body    String  是   请参考下方消息示例说明中对应消息的body字段，
      *  最大长度5000字符，为一个json串
      *  option  String  否   发消息时特殊指定的行为选项,Json格式，可用于指定消息的漫游，存云端历史，发送方*多端同步，推送，消息抄送等特殊行为;option中字段不填时表示默认值 option示例:
*
      *  {"push":false,"roam":true,"history":false,"sendersync":true,"route":false,"badge":false,"needPushNi*ck":true}
*
      *  字段说明：
      *  1. roam: 该消息是否需要漫游，默认true（需要app开通漫游消息功能）； 
      *  2. history: 该消息是否存云端历史，默认true；
      *   3. sendersync: 该消息是否需要发送方多端同步，默认true；
      *   4. push: 该消息是否需要APNS推送或安卓系统通知栏推送，默认true；
      *   5. route: 该消息是否需要抄送第三方；默认true (需要app开通消息抄送功能);
      *   6. badge:该消息是否需要计入到未读计数中，默认true;
      *  7. needPushNick: 推送文案是否需要带上昵称，不设置该参数时默认true;
      *  8. persistent: 是否需要存离线消息，不设置该参数时默认true。
      *  pushcontent String  否   *ios推送内容，不超过150字符，option选项中允许推送（push=true），此字段可以指定推送内容
      *  payload String  否   ios 推送对应的payload,必须是JSON,不能超过2k字符
      *  ext String  否   开发者扩展字段，长度限制1024字符*
      *
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
                $this->apiConf['nimserver.msg.sendBatchMsg'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('批量发送点对点普通消息失败,[NimserverMsgSendBatchMsg]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
