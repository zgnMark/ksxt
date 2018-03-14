<?php
namespace app\admin\logic;

use app\vendor\log\Monolog;
use Think\Db;

class Advice extends Base
{
    /**
     * 获取课程列表
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
        $map = [];
        if (!empty($where['content'])) {
            $map['content'] = array('like', '%' . $where['content'] . '%');
        }
        if (!empty($where['userid'])) {
            $map['userid'] = array('eq', $where['userid']);
        }             
        if (!empty($where['adminid'])) {
            $map['adminid'] = array('eq', $where['adminid']);
        }         
        if (!empty($where['ip'])) {
            $map['ip'] = array('eq', $where['ip']);
        }                 
        if (!empty($where['id'])) {
            $map['id'] = array('eq', $where['id']);
        }        
            $map['is_del'] = array('eq', 0);
        if (isset($where['status'])) {
            $map['status'] = array('eq', $where['status']);
         }        
        if (!empty($where['datemin'])) {
            $map['create_time'] = array('egt', $where['datemin']);
        }
        if (!empty($where['datemax'])) {
            $map['create_time'] = array('elt', $where['datemax']);
        }
        if (!empty($where['datemin']) && !empty($where['datemax'])) {
            $map['create_time'] = array('between', $where['datemin']. ',' . $where['datemax']);
        }
        //排序
        if (!empty($order)) {
            $orderSort = "{$order['order_field']}  {$order['order']}";
        } else {
            $orderSort = "id desc";
        }

        //获取总数
        $total = Db::table('x2_advice')->where($map)->count();
        //$totalPage = ceil($total / $pageSize);

        $data = [];
        //判断是全部获取还是分页
        if (!empty($pageSize) && $pageSize > 0) {
            if ($total > 0) {
                $page = ($page <= 1) ? 0 : ($page - 1);
                $data = Db::table('x2_advice')->limit($page * $pageSize, $pageSize)->where($map)->order($orderSort)->select();
            }
        } else {
            $data = Db::table('x2_advice')->where($map)->order($orderSort)->select();
        }
        return array(
            'total' => $total,
            'list'  => $data,
        );
    }
    
}
