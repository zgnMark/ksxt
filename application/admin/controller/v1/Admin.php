<?php
namespace app\admin\controller\v1;

//use app\vendor\log\Monolog;
use think\Db;
use \think\Loader;

class Admin extends Common
{

    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {

        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 20);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');
        $username   = input('param.username', '');
        $email      = input('param.email', '');
        $mobile     = input('param.mobile', '');
        $status     = input('param.status', '');

        $param = [
            'username' => $username,
            'status'   => $status,
            'email'    => $email,
            'mobile'   => $mobile,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];

        $data = Loader::model('admin', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);

        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['list'],
            'total' => $data['total'],
        ]);
    }

    /**
     * 添加或更新一个用户
     * @return [type] [description]
     */
    public function add()
    {
        $mobile         = input('param.mobile', '');
        $email          = input('param.email', '');
        $loginPassword  = input('param.password', '');
        $username       = input('param.username', '');


        //qq, wechat, sina ,mobile
        //$type = input('param.type', 'mobile');
        //如果第三方登录，先判断之前有没注册过,有则跳转至登录

        $sysuserAccountData = [
            'mobile'        => $mobile,
            'email'         => $email,
            'password'      => md5($loginPassword),
            'username'      => $username,
        ];
        $flag = Loader::model('Admin', 'logic')->createAdmin($sysuserAccountData);
        if ($flag === 0) {
            return $this->packReturn([
                'code' => 0,
                'msg'  => '添加成功！',
            ]);
        } else {
            return $this->packReturn([
                'code' => $flag,
                'msg'  => '添加失败',
            ]);
        }

    }
    /**
     * 删除一个后台用户
     * @return [type] [description]
     */
    public function del()
    {
        $id = input('post.id', 0);
        Loader::model('Admin', 'logic')->saveAdmin(['id' => $id, 'is_del' => 1]);
        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '删除管理员列表', 'post' => $_POST]);

        return $this->packReturn([
            'code' => 0,
            'msg'  => '删除成功',
        ]);
    }

}
