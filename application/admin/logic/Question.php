<?php
namespace app\admin\logic;

use app\vendor\log\Monolog;
use Think\Db;

class MultiQuestion extends Base
{
    /**
     * 获取题目列表
     * @param  array  $where  [description]
     * @param  string $select [description]
     * @return [type]         [description]    */

    public function getList(array $where, $order = [], $select = '*')
    {
        //剔除空
        $where = array_filter($where, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });
        //排序
        if (!empty($order)) {
            $orderSort = "{$order['order_field']}  {$order['order']}";
        } else {
            $orderSort = "id desc";
        }

        //获取总数
        $total = Db::table('x2_multiquestion')->where($where)->count();
        //$totalPage = ceil($total / $pageSize);

        $data = [];
        //判断是全部获取还是分页
        if (!empty($pageSize) && $pageSize > 0) {
            if ($total > 0) {
                $page = ($page <= 1) ? 0 : ($page - 1);
                $data = Db::table('x2_multiquestion')->limit($page * $pageSize, $pageSize)->where($where)->order($orderSort)->select();
            }
        } else {
            $data = Db::table('x2_multiquestion')->where($where)->order($orderSort)->select();
        }
        return array(
            'total' => $total,
            'list'  => $data,
        );
    }

}
