<?php

namespace app\admin\logic;

use app\vendor\log\Monolog;
use Think\Db;

class User extends Base
{
    /**
     * 获取用户列表
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
        if (!empty($where['mobile'])) {
            $map['mobile'] = array('like', '%' . $where['mobile'] . '%');
        }
        if (!empty($where['useremail'])) {
            $map['useremail'] = array('like', '%' . $where['useremail'] . '%');
        }
        if (!empty($where['account'])) {
             $map['account'] = array('like', '%' . $where['account'] . '%');
        }
        if (!empty($where['username'])) {
             $map['username'] = array('like', '%' . $where['username'] . '%');
        }
        if (!empty($where['userid'])) {
            $map['userid'] = array('eq', $where['userid']);
        }        
        if (!empty($where['is_del'])) {
            $map['is_del'] = array('eq', $where['is_del']);
        }


        //排序
        if (!empty($order)) {
            $orderSort = "{$order['order_field']}  {$order['order']}";
        } else {
            $orderSort = "userid desc";
        }
        $total = Db::table('x2_user')->where($map)->count();
        $data = [];
        //判断是全部获取还是分页
        if (!empty($pageSize) && $pageSize > 0) {
            if ($total > 0) {
                $page = ($page <= 1) ? 0 : ($page - 1);
                $data = Db::table('x2_user')->where($map)->limit($page * $pageSize, $pageSize)->order($orderSort)->select();
            }
        } else {
            $data = Db::table('x2_user')->where($map)->order($orderSort)->select();
        }

        return array(
            'total' => $total,
            'list'  => $data,
        );
    }

    //删除用户
    public function delUser(int $userid)
    {
        Db::table('x2_user')
            ->where('userid', $userid)
            ->delete();
    }

    //更新用户
    public function updateUser(array $params, array $where)
    {
        //剔除空
        $params = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });

        $flag = Db::table('x2_user')
            ->where($where)
            ->update($params);

        if ($flag === false) {
            Monolog::error('更新失败,[Admin.UserLogic.updateUser]:', [$where]);
            throw new \Exception("更新失败", 3);
        }
        return true;
    }

    //检测用户是否存在
    public function isExists($data)
    {
        $flag = Db::table('x2_user')
            ->where($data)
            ->find();

        if ($flag === false) {
            Monolog::error('查询失败,[Admin.UserLogic.isExists]:', [$data]);
            throw new \Exception("查询失败", 3);
        }

        return !empty($flag);
    }

}
