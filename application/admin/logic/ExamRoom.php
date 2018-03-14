<?php
namespace app\admin\logic;

use app\vendor\log\Monolog;
use Think\Db;

class ExamRoom extends Base
{
    /**
     * 获取考场列表
     * @param  array  $where  [description]
     * @param  string $select [description]
     * @return [type]         [description]
     */
    public function getList($where)
    {
        //剔除空
        $where = array_filter($where, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });

        //获取总数
        $total = Db::table('x2_examroom')->where($where)->count();
        //$totalPage = ceil($total / $pageSize);
        //判断是全部获取还是分页
        $data = Db::table('x2_examroom')->where($where)->select();

        return array(
            'total' => $total,
            'list'  => $data,
        );
    }

    /**
     * 保存考场信息
     * @param  [type] $params [description]
     * @return [type]         [description]
     */


    
}
