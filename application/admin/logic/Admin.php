<?php
namespace app\admin\logic;

use app\vendor\log\Monolog;
use Think\Db;

class Admin extends Base
{


    /**
     * 创建后台用户
     */
    public function createAdmin(array $params)
    {
        $flag = [];
        $code = 1;
        try {
            Db::startTrans();
            if ($this->checkAccountRegister($params)) {
                return $this->checkAccountRegister($params);
            }
            //剔除空
            $where = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
                return !empty($v);
            });
            //创建
            $sysuserAccountData = [
                'username'         => $params['username'],
                'email'            => $params['email'],
                'mobile'           => $params['mobile'],
                'password'         => $params['password'], // passwd($params['login_password']),
                'is_del'           => 0,
            ];

            $flag = Db::table('x2_admin')->insert($sysuserAccountData);
            if ($flag === false) {
                $code =103;
                throw new \Exception("创建用户失败", 1);
            }
        } catch (\Exception $e) {
            Db::rollback();
            Monolog::error('创建用户失败,[Api.Passport.createUser]:' . $e->getMessage(), [$params]);
            return $code;
        }
        return 0;
    }
  
    /**
     * 获取后台用户列表
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

        $where['is_del'] = 0;
        /*
        //筛选
        if (!empty($where['idle_flow'])) {
        $where['idle_flow'] = array('elt', $where['idle_flow']);
        }
        //过滤id
        if (isset($where['notIds']) && !empty($where['notIds'])) {
        $where['id'] = array('notin', $where['notIds']);
        unset($where['notIds']);
        }
        if (isset($where['inIds']) && !empty($where['inIds'])) {
        $where['id'] = array('in', $where['inIds']);
        unset($where['inIds']);
        }
         */

        //排序
        if (!empty($order)) {
            $orderSort = "{$order['order_field']}  {$order['order']}";
        } else {
            $orderSort = "id desc";
        }

        //获取总数
        $total = Db::table('x2_admin')->where($where)->count();
        //$totalPage = ceil($total / $pageSize);

        $data = [];
        //判断是全部获取还是分页
        if (!empty($pageSize) && $pageSize > 0) {
            if ($total > 0) {
                $page = ($page <= 1) ? 0 : ($page - 1);
                $data = Db::table('x2_admin')->limit($page * $pageSize, $pageSize)->where($where)->order($orderSort)->select();
            }
        } else {
            $data = Db::table('x2_admin')->where($where)->order($orderSort)->select();
        }

        return array(
            'total' => $total,
            'list'  => $data,
        );
    }

    /**
     * 登录
     * @return [type] [description]
     */
    public function login(array $params)
    {

        $userData = Db::table('x2_admin')
            ->where(['username'=>$params['username']])
            ->find();
         try {
            if (empty($userData)) {
                $code = 101;
                throw new \Exception("不存在该用户", 1);
            }
            if ($userData['is_del'] != 0) {
                $code = 102;
                throw new \Exception("已冻结，请联系管理员", 1);
            }
            if ($userData['password'] != $params['password']) {
                $code = 103;
                throw new \Exception("密码有误", 1);
            }
        } catch (\Exception $e){
            $arr['code'] = $code;
            $arr['data']  = $e->getMessage();
            return $arr;
        }
        Db::table('x2_admin')
            ->where(['username'=>$params['username']])
            ->update(['ip'=>$_SERVER['REMOTE_ADDR'],'login_time'=>date('Y-m-d H:i:s',time())]);
        $arr['code'] = 0;
        $arr['data'] = $userData;
        return $arr;
    }

        /**
     * 检测用户是否被注册
     * [checkAccount description]
     * @return [type] bool，存在返回true,否则返回false
     */
    private function checkAccountRegister(array $params)
    {
        $email_flag = Db::table('x2_admin')->where([
            'email'  => $params['email'],
        ])->count();        
        $mobile_flag = Db::table('x2_admin')->where([
            'mobile'     => $params['mobile'],
        ])->count();
        if ($email_flag > 0) {
            return 101; 
        } else if ($mobile_flag > 0) {
            return 102;
        }
        return false;
    }
}
