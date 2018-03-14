<?php
namespace app\admin\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use \think\Loader;
use think\request;

class User extends Common
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
        $orderField = input('param.order_field', 'userid');

        $userid        = input('param.userid', '');
        $username      = input('param.username', '');
        $useremail     = input('param.email', '');
        $mobile        = input('param.mobile', '');
        $sex           = input('param.sex', '');
        $is_del        = input('param.is_del', '');
        $account       = input('param.account', '');



        $param = [
            'userid'       => $userid,
            'useremail'    => $useremail,
            'username'     => $username,
            'account'      => $account,
            'sex'          => $sex,
            'is_del'       => $is_del,
            'mobile'       => $mobile,
            'account'      => $account
        ];


        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];

        $data = Loader::model('User', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);

/*        //获取用户详细信息
        $ids      = array_column($data['list'], 'id');
        $userData = Db::table('x2_user')->where(['userid' => ['in', $ids]])->select();
        $userData = array_column($userData, null, 'userid');

        //转换
        array_walk($data['list'], function (&$v) use ($userData) {
            if (isset($userData[$v['id']])) {
                $v['userData'] = $userData[$v['id']];
                if ($v['userData']['sex'] == 0) {
                    $v['userData']['sex'] = '未知';
                } elseif ($v['userData']['sex'] == 1) {
                    $v['userData']['sex'] = '男';
                } else {
                    $v['userData']['sex'] = '女';
                }
            } else {
                $v['userData'] = null;
            }
        });*/
        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['list'],
            'total' => $data['total'],
        ]);
    }

    /**
     * 删除用户,软删除
     * @return [type] [description]
     */
    public function del()
    {
        $id = input('post.id', 0);
        try {
            Db::startTrans();
            $flag = Db::table('x2_user')->where(['userid' => $id])->update(['is_del' => 1]);
            if ($flag === false) {
                throw new \Exception("更新j_sysuser_user表失败", 1);
            }
            Db::commit();
            return $this->packReturn([
                'code' => 0,
                'msg'  => '删除成功',
            ]);
        } catch (\Exception $e) {
            Db::rollback();
            Monolog::error('删除失败,[Admin.User.del]:' . $e->getMessage(), [$id]);
        }
        return $this->packReturn([
            'code' => 100,
            'msg'  => '删除失败',
        ]);
    }

   
}
