<?php
/**
 * @Author     yhz
 * @time       2017-12-27
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\payssion;

use app\vendor\log\Monolog;

class PaymentCreate extends Base
{

    /**
     * 付钱请求
     * 用户创建频道时获取的推流地址失效时，重新获取推流地址。
     * API_KEY	应用ID	串	必填	添加应用成功后可以看到该应用的API_KEY
     * pm_id	应用支付方式ID	串	必填	支付方式标识，统一为小写字符，如sofort
     * 量	支付金额	串	必填	小数点精确到后面两位
     * 货币	货币	串	必填	如美元
     * 描述	订单描述	串	必填	最长256字符
     * ORDER_ID	订单号	串	必填
     * api_sig	请求签名	串	必填	api接入签名验证，具体生成规则参考
     * notify_url	异步通知网址	串	可选
     * return_url	完成尚未支付或者支付失败时
     * 页面跳转同步通知网址	串	可选
     * success_url	支付成功后页面跳转同步通知网址	串	可选
     * 语言	语言	串	可选	如恩
     * @param  [type] $params [description]
     * @return
     * [
     *   RESULT_CODE	错误码	INT	必填	API调用错误码
     *   去做	支付操作	串	必填	完成支付需要进行的操作
     *   return_url	支付跳转网址	串	可选	当待办事项值包含“重定向”，可将页面跳转到return_url让用户完成支付
     *   device_support	当前的支付方式支持的设备	串	可选
     *   交易	该笔支付的信息	目的	必填	交易信息
     *   银行账户	银行账户信息	目的	可选	离线银行转账的银行账户信息
     * ]
     */
    public function request($params)
    {
        try {
            $response = $this->httpClient->post(
                $this->apiConf['payment.create'],
                [
                    'json'    => $params,
                    'headers' => $this->headers,
                ]
            );
            $body = $response->getBody()->getContents();
            Monolog::info(':', [$body]);
            return json_decode($body, true);
        } catch (\Exception $e) {
            Monolog::error('创建交易,[PaymentCreate]' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
