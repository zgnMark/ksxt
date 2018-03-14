<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamCreate extends Base
{

    /**
     * 创建群
     *
     * tname    String  是   群名称，最大长度64字符
*owner   String  是   群主用户帐号，最大长度32字符
*members String  是   ["aaa","bbb"](JSONArray对应的accid，如果解析出错会报414)，一次最多拉200个成员
*announcement    String  否   群公告，最大长度1024字符
*intro   String  否   群描述，最大长度512字符
*msg String  是   邀请发送的文字，最大长度150字符
*magree  int 是   管理后台建群时，0不需要被邀请人同意加入群，1需要被邀请人同意才可以加入群。其它会返回414
*joinmode    int 是   群建好后，sdk操作时，0不用验证，1需要验证,2不允许任何人加入。其它返回414
*custom  String  否   自定义高级群扩展属性，第三方可以跟据此属性自定义扩展自己的群属性。（建议为json）,*最大长度1024字符
*icon    String  否   群头像，最大长度1024字符
*beinvitemode    int 否   被邀请人同意方式，0-需要同意(默认),1-不需要同意。其它返回414
*invitemode  int 否   谁可以邀请他人入群，0-管理员(默认),1-所有人。其它返回414
*uptinfomode int 否   谁可以修改群资料，0-管理员(默认),1-所有人。其它返回414
*upcustommode    int 否   谁可以更新群自定义属性，0-管理员(默认),1-*所有人。其它返回414面端在线时，移动端是否不推送：true:移动端不需要推送，false:移动端需要推送
     *
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *    "tid":"11001",
        *"faccid":{
        *       "accid":["a","b","c"],
        *       "msg":"team count exceed"
        *   }
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.team.create'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('获取推送状态失败,[NimserverTeamCreate]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
