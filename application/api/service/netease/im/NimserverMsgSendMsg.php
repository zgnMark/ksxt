<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverMsgSendMsg extends Base
{

    /**
     * 发送普通消息
     *
     * from String  是   发送者accid，用户帐号，最大32字符，
      *  必须保证一个APP内唯一
      *  ope int 是   0：点对点个人消息，1：群消息（高级群），其他返回414
      *  to  String  是   ope==0是表示accid即用户id，ope==1表示tid即群id
      *  type    int 是   0 表示文本消息,
      *  1 表示图片，
      *  2 表示语音，
      *  3 表示视频，
      *  4 表示地理位置信息，
      *  6 表示文件，
      *  100 自定义消息类型（特别注意，对于未对接易盾反垃圾功能的应用，该类型的消息不会提交反垃圾系统检测）
      *  body    String  是   请参考下方消息示例说明中对应消息的body字段，
      *  最大长度5000字符，为一个JSON串
      *  antispam    String  否   *对于对接了易盾反垃圾功能的应用，本消息是否需要指定经由易盾检测的内容（antispamCustom）。
      *  true或false, 默认false。
      *  只对消息类型为：100 自定义消息类型 的消息生效。
      *  antispamCustom  String  否   在antispam参数为true时生效。
      *  自定义的反垃圾检测内容, *JSON格式，长度限制同body字段，不能超过5000字符，要求antispamCustom格式如下：
*
      *  {"type":1,"data":"custom content"}
*
      *  字段说明：
      *  1. type: 1：文本，2：图片。
      *  2. data: 文本内容or图片地址。
      *  option  String  否   发消息时特殊指定的行为选项,JSON格式，可用于指定消息的漫游，存云端历史，发送方*多端同步，推送，消息抄送等特殊行为;option中字段不填时表示默认值 ，option示例:
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
      *  ext String  否   开发者扩展字段，长度限制1024字符
      *  forcepushlist   String  否   *发送群消息时的强推（@操作）用户列表，格式为JSONArray，如["accid1","accid2"]*。若forcepushall为true，则forcepushlist为除发送者外的所有有效群成员
      *  forcepushcontent    String  否   *发送群消息时，针对强推（@操作）列表forcepushlist中的用户，强制推送的内容
      *  forcepushall    String  否   *发送群消息时，强推（@操作）列表是否为群里除发送者外的所有有效成员，true或false，默认为false
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
                $this->apiConf['nimserver.msg.sendMsg'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('发送普通消息失败,[NimserverMsgSendMsg]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
