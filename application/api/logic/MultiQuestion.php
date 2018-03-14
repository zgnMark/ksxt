<?php
namespace app\api\logic;

use app\vendor\log\Monolog;
use Think\Db;

class MultiQuestion extends BaseLogic
{
    //获取随机的题目列表
    public function getRandList(array $where)
    {
    	//剔除空
        $where = array_filter($where, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });
        $where['type'] = 1;
        $data = Db::table('x2_question')->limit(10)->where($where)->order('rand()')->select();
        return $data;
    }
}
