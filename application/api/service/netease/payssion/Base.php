<?php
/**
 * @Author     yhz
 * @time       2017-12-27
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\payssion;

use GuzzleHttp\Client;

class Base
{
    //api配置链接
    public $apiConf;
    //请求
    public $httpClient;
    //公共头部
    public $headers;

    public function __construct()
    {
        $this->apiConf    = config('api');
        $this->httpClient = new Client([
            'timeout' => 5.0,
        ]);
        $type = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'],'/')+1);


        //设置头部
        $api_key         = '95da49ce1a1c564cb64a786f3500998c';
        $secret_key      = '2';
        $pm_id           = '9453b5864d6b';
        $amount          = input('param.amount','');
        $currency        = time();
        $order_id        = input('param.order_id','');
        $transaction_id  = input('param.transaction_id','');


        switch ($type) {
            case 'create':
                $arr = [$api_key,$pm_id,$amount,$currency,$order_id,$secret_key];
                break;
            case 'getDetail':
                $arr = [$api_key,$transaction_id,$order_id,$secret_key];
                break;
            default:
                return;
                break;
        }

        $api_sig = md5(implode("|",$arr));
        
        $this->headers = [
            'api_sig'      => $api_sig
        ];

    }

    public function test($params)
    {

        //带上签名验证
        $params['test'] = 1;
        try {
            $response = $this->httpClient->post($this->apiConf['test'],
                [
                    'form_params' => $param,
                    'headers'     => [],
                    // 'json'    => $param,
                    // 'headers' => [
                    //     'Content-Type' => 'application/json',
                    // ],
                ]
            );
            $body = $response->getBody()->getContents();
            return $body;
        } catch (\Exception $e) {
            Monolog::error('error' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
