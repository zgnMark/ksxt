<?php
namespace app\admin\logic;

use app\vendor\log\Monolog;
use Think\Db;

class ExamHistory extends Base
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
        $map = [];        
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
        if (!empty($where['scoremin'])) {
            $map['score'] = array('egt', $where['scoremin']);
        }
        if (!empty($where['scoremax'])) {
            $map['score'] = array('elt', $where['scoremax']);
        }
        if (!empty($where['scoremin']) && !empty($where['scoremax'])) {
            $map['score'] = array('between', $where['scoremin']. ',' . $where['scoremax']);
        }
        if (!empty($where['username'])) {
            $ids = Db::table('x2_user')->where('username','like' ,$where['username'] . '%')->column('userid');
            $map['user_id'] = array('in', $ids);
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
    
}
