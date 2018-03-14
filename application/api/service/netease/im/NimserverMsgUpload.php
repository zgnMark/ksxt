<?php
/**
 * @Author    	yhz
 * @time       2017-12-13
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\im;

use app\vendor\log\Monolog;

class NimserverMsgUpload extends Base
{

    /**
     * 文件上传
     *
     * content  String  是   字符流base64串(Base64.encode(bytes)) ，最大15M的字符流
     * type    String  否   上传文件类型
     * ishttps String  否   返回的url是否需要为https的url，true或false，默认falsedonnopOpen   String  是        * 桌面端在线时，移动端是否不推送：true:移动端不需要推送，false:移动端需要推送
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
                $this->apiConf['nimserver.msg.upload'],
                [
                    'form_params' => $params,
                    'headers'     => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('文件上传失败,[NimserverMsgUpload]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
