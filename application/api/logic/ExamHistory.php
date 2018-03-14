<?php
namespace app\api\logic;

use app\vendor\log\Monolog;
use Think\Db;

class ExamHistory extends BaseLogic
{
    /**
     * 获取个人考试历史记录
     * @param  array  $where  [description]
     * @param  string $select [description]
     * @return [type]         [description]
     */
    public function getList(array $where, $order = [], $select = '*')
    {

        $page     = isset($where['page']) ? $where['page'] : null;
        $pageSize = isset($where['pageSize']) ? $where['pageSize'] : null;
        unset($where['page'], $where['pageSize']);

        //剔除空
        $where = array_filter($where, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });
        //筛选
        $map           = [];
        $map['is_del'] = 0;
        if (!empty($where['room_id'])) {
            $map['room_id'] = array('eq', $where['room_id']);
        }        
        if (!empty($where['user_id'])) {
            $map['user_id'] = array('eq', $where['user_id']);
        }
        if (!empty($where['datemin'])) {
            $map['start_time'] = array('egt', $where['datemin'] . ' 00:00:00');
        }
        if (!empty($where['datemax'])) {
            $map['start_time'] = array('elt', $where['datemax'] . ' 23:59:59');
        }
        if (!empty($where['datemin']) && !empty($where['datemax'])) {
            $map['start_time'] = array('between', $where['datemin'] . ' 00:00:00' . ',' . $where['datemax'] . ' 23:59:59');
        }


        //排序
        if (!empty($order)) {
            $orderSort = "{$order['order_field']}  {$order['order']}";
        } else {
            $orderSort = "id desc";
        }

        //获取总数
        $total = Db::table('x2_examhistory')->where($map)->count();
        //$totalPage = ceil($total / $pageSize);

        $data = [];
        //判断是全部获取还是分页
        if (!empty($pageSize) && $pageSize > 0) {
            if ($total > 0) {
                $page = ($page <= 1) ? 0 : ($page - 1);
                $data = Db::table('x2_examhistory')->limit($page * $pageSize, $pageSize)->where($map)->order($orderSort)->select();
            }
        } else {
            $data = Db::table('x2_examhistory')->where($map)->order($orderSort)->select();
        }
        return array(
            'total' => $total,
            'list'  => $data,
        );
    }

    public function  commit($value='')
    {
        # code...
    }
    
}
