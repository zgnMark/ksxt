<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Config;
use think\Db;
use think\Loader;

class User extends Common
{
    /**
     * 我的信息列表
     * @return [type] [description]
     */
    public function lists()
    {
        $subject_id     = input('param.subject_id', '');
        $user_id        = input('param.user_id');
        $type           = input('param.type');    

        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');

        $param = [
            'is_del' => 0,
            'subject_id'   => $subject_id,
            'user_id'      => $user_id
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        //获取用户信息
        $data = Db::table('x2_user')->where($userid)->find();
        switch ($type) {
            case 1:
                # 获取考试记录
                $data = Loader::model('ExamHistory', 'logic')
                    ->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
                break;
            case 2:
                # 获取课程记录
                $data = Loader::model('SubjectResources', 'logic')
                    ->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
                break;           
            default:
                # code...
                break;
        }

        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
            'totle'   => $data['totle'],
        ]);
    }

    public function updatePass()
    {
        $userid         = input('param.userid');
        $password       = input('param.password');
        $repassword     = input('param.repassword');
        
        $flag = Db::table('x2_user')->where(['userid'=>$userid,'password'=>$password])->find();

        if ($flag) {
            Db::table('x2_user')->where(['userid'=>$userid])->update(['password' => $repassword]);
            return $this->packReturn([
                'code'    => 0,
                'msg'     =>'修改成功'
            ]); 
        } else {
                return $this->packReturn([
                'code'    => 100,
                'msg'     =>'修改失败,密码错误'
            ]); 
        }
        
    }

}

