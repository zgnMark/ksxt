<?php
namespace app\api\logic;

use app\vendor\log\Monolog;
use Think\Db;

class SubjectResources extends BaseLogic
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

        //筛选
        $map = [];
        if (!empty($where['title'])) {
            $map['title'] = array('like', '%' . $where['title'] . '%');
        }
            $map['subject_type'] = array('eq',$where['subject_type']);
        if (!empty($where['subject_id'])) {
            $map['subject_id'] = array('eq', $where['subject_id']);
        }        
        if (!empty($where['is_del'])) {
            $map['is_del'] = array('eq', $where['is_del']);
        }

        //排序
        if (!empty($order)) {
            $orderSort = "{$order['order_field']}  {$order['order']}";
        } else {
            $orderSort = "id desc";
        }

        //获取总数
        $total = Db::table('x2_subjectresources')->where($map)->count();
        //$totalPage = ceil($total / $pageSize);

        $data = [];
        //判断是全部获取还是分页
        if (!empty($pageSize) && $pageSize > 0) {
            if ($total > 0) {
                $page = ($page <= 1) ? 0 : ($page - 1);
                $data = Db::table('x2_subjectresources')->limit($page * $pageSize, $pageSize)->where($map)->order($orderSort)->select();
            }
        } else {
            $data = Db::table('x2_subjectresources')->where($map)->order($orderSort)->select();
        }
        return array(
            'total' => $total,
            'list'  => $data,
        );
    }
    
}
