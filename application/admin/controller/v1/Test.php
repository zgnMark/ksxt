<?php
/**
 * @Author     SuJun (351699382@qq.com)
 * @time       2017-12-04
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\admin\controller\v1;

use Auth\Auth;
use think\Config;
use think\Session;
use \think\Loader;
use \think\Model;
use \think\Db;


class Test extends Base
{
    //权限验证
    public function test()
    {
        $user['id'] = 1;
        Session::set('user',$user);
        $actionlog = Loader::model('action', 'logic')->actionlog('测试');
        dump($actionlog);
    }

    public function sql()
    {
        //导入数据库
        $sql = include '';

        Db::execute('drop database database_v1');
        Db::execute('create database database_v1');
    }


    function xmlToArray(){
        //禁止引用外部xml实体
        $xml = file_get_contents('arrays.xml');
        libxml_disable_entity_loader(true);

        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        $val = json_decode(json_encode($xmlstring),true);
        //var_dump($val['string-array'][0]['item']);
        $item = $val['string-array'][0]['item'];
        $item1 = $val['string-array'][1]['item'];

        foreach($item as $key=>$val)
        {
           $name = substr($val, 0, strpos($val,' '));


           //$chinese = substr($val, 0, strpos($val,' '));
            $chinese = substr($item1[$key], 0, strpos($item1[$key],' '));
            $english = substr($val, 0, strpos($val,'*'));
            $mobile =  substr($val, strpos($val,'+'), strpos($val,'|'));
            $mobile =  substr($mobile, 0, strpos($mobile,' '));
            $arr[$key]['name'] = $english;
            $arr[$key]['chinese_name'] = $chinese;
            $arr[$key]['english_name'] = $english;
            $arr[$key]['area_code']  = $mobile;
            $arr[$key]['status']  = 0;
            $arr[$key]['update_time']  = 0;
            $arr[$key]['create_time']  = date('Y-m-d H:i:s');
            $arr[$key]['update_time']  = date('Y-m-d H:i:s');

            $flag = Db::table('j_country')->insert($arr[$key]);
        }


    }

}
