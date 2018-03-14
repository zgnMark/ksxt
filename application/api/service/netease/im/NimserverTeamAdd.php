<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverTeamAdd extends Base
{

    /**
     * 拉人入群
     *
     * tid  String  是   网易云通信服务器产生，群唯一标识，创建群时会返回，最大长度128字符
    * owner   String  是   群主用户帐号，最大长度32字符
    * members String  是   ["aaa","bbb"](JSONArray对应的accid，如果解析出错会报414)，一次最多拉200个成员
    * magree  int 是   管理后台建群时，0不需要被邀请人同意加入群，1需要被邀请人同意才可以加入群。其它会返回414
    * msg String  是   邀请发送的文字，最大长度150字符
    * attach  String  否   自定义扩展字段，最大长度512
     * @param  [type] $params [description]
     * @return
     * 返回示例
     * ["Content-Type": "application/json; charset=utf-8"
     *{
     *  "code":200 
     *    "faccid":{
    *     "accid":["a","b","c"],
    *     "msg":"team count exceed"
    * }
     *}       
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['nimserver.team.add'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('拉人入群失败,[NimserverTeamAdd]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
