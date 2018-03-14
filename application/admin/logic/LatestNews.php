<?php
namespace app\admin\logic;

use app\vendor\log\Monolog;
use Think\Db;

class LatestNews extends Base
{
    /**
     * 获取最新资讯列表
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
        if (!empty($where['title'])) {
            $map['title'] = array('like', '%' . $where['title'] . '%');
        }        
        if (!empty($where['publisher'])) {
            $map['publisher'] = array('like', '%' . $where['publisher'] . '%');
        }
        if (!empty($where['content'])) {
             $map['content'] = array('like', '%' . $where['content'] . '%');
        }     
        if (!empty($where['new_type'])) {
            $map['new_type'] = array('eq', $where['new_type']);
        }            
         if (!empty($where['is_del'])) {
            $map['is_del'] = array('eq', $where['is_del']);
        }         
        if (!empty($where['id'])) {
            $map['id'] = array('eq', $where['id']);
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
        $total = Db::table('x2_latestnews')->where($map)->count();
        //$totalPage = ceil($total / $pageSize);

        $data = [];
        //判断是全部获取还是分页
        if (!empty($pageSize) && $pageSize > 0) {
            if ($total > 0) {
                $page = ($page <= 1) ? 0 : ($page - 1);
                $data = Db::table('x2_latestnews')->limit($page * $pageSize, $pageSize)->where($map)->order($orderSort)->select();
            }
        } else {
            $data = Db::table('x2_latestnews')->where($map)->order($orderSort)->select();
        }
        return array(
            'total' => $total,
            'list'  => $data,
        );
    }
    
}
