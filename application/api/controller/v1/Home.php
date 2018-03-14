<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Config;
use think\Db;
use think\Loader;

class Home extends Common
{
    /**
     * 我的信息
     * @return [type] [description]
     */
    public function get()
    {
        $userid        = input('param.userid');

        //获取用户信息
        $data = Db::table('x2_user')->where(['userid' => $userid])->find();
        unset($data['userpassword']);
        return $this->packReturn([
            'code'    => 0,
         	'info'	  => $data,	
        ]);
    }

    /**
     * 更新
     * @return [type] [description]
     */
    public function save()
    {
        $userid      = input('param.userid', '');
        $mobile      = input('param.mobile', '');
        $usertruename    = input('param.usertruename', '');
        $useremail    = input('param.useremail', '');
        $file        = request()->file('photo');
        $photo       = null;

        if (empty($userid)) {
            return $this->packReturn([
                'code'  => 100,
                'info' => 'id不能为空',
            ]);
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $params = [
            'photo'     => $photo,
            'mobile'    => $mobile,
            'usertruename'  => $usertruename,
            'useremail'  => $useremail,
        ];

        $flag = $this->checkAccountRegister($params);
        if ($flag) {
            return $this->packReturn([
                'code'  => $flag,
                'info' => $flag == 101?'邮箱已已被注册':'手机号已被注册',
            ]);
         } 
        //剔除空
        $params = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });


        // 获取表单上传文件 例如上传了001.jpg
        if (!empty($file)) {
            $info = $file->validate(['size'=>155678,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $params['photo'] = DS . 'uploads' . DS . $info->getSaveName();
            } else {
                // 上传失败获取错误信息
                return $this->packReturn([
                    'code' => 100,
                    'info'  => $file->getError(),
                ]);
            }
        }

        $flag = Db::table('x2_user')
            ->where(['userid' => $userid])
            ->update($params);
        if (empty($flag)) {
            return $this->packReturn([
                'code'    => 0,
                'info' => '更新失败',
            ]);
        }
        return $this->packReturn([
            'code'    => 0,
            'photo'   => $photo,
            'data'    => Db::table('x2_user')->where(['userid'=>$userid])->find(),
            'info'    => '更新成功',
        ]);
    }

    public function updatePass()
    {
        $userid         = input('param.userid');
        $password       = md5(input('param.password'));
        $repassword     = md5(input('param.repassword'));
        
        $flag = Db::table('x2_user')->where(['userid'=>$userid,'userpassword'=>$password])->find();



        if ($flag) {
            Db::table('x2_user')->where(['userid'=>$userid])->update(['userpassword' => $repassword]);
            $data = Db::table('x2_user')->where(['userid'=> $userid])->find();
            return $this->packReturn([
                'code'    => 0,
                'data'    => $data,
                'msg'     =>'修改成功'
            ]); 
        } else {
                return $this->packReturn([
                'code'    => 100,
                'msg'     =>'修改失败,原始密码错误'
            ]); 
        }
        
    }

    public function exam()
    {
        $page         = input('param.page', 1);
        $pageSize     = input('param.pageSize', 2);
        $order        = input('param.order', 'desc');
        $orderField   = input('param.order_field', 'id');


        $user_id      = input('param.user_id', '');
        $room_id      = input('param.room_id', 1);
        $is_del       = input('param.is_del', 0);
        $status       = input('param.status', 1);

        $datemin = input('param.datemin', '');
        $datemax = input('param.datemax', '');

        $param = [
            'user_id'        => $user_id,
            'room_id'        => $room_id,
            'datemax'        => $datemax,
            'datemin'        => $datemin,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        $data = Loader::model('ExamHistory', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
        $roomData = Db::table('x2_examroom')->select();

        //管理员行为日志
        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['list'],
            'roomlist'  => $roomData,
            'total' => $data['total'],
        ]);
    }

    public function subject()
    {
        $page         = input('param.page', 1);
        $pageSize     = input('param.pageSize', 8);
        $order        = input('param.order', 'desc');
        $orderField   = input('param.order_field', 'id');


        $user_id        = input('param.user_id', '');
        $video_id       = input('param.video_id', 1);
        $study_time     = input('param.study_time', 1);
        $video_name     = input('param.video_name', '');

        $datemin = input('param.datemin', '');
        $datemax = input('param.datemax', '');

        $param = [
            'user_id'        => $user_id,
            'title'          => $video_name,
            'datemax'        => $datemax,
            'datemin'        => $datemin,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        $data = Loader::model('Video', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
        //获取视频详细信息
        $ids      = array_column($data['list'], 'video_id');

        $videoData = Db::table('x2_video_resources')->where(['id' => ['in', $ids]])->select();
        $videoData = array_column($videoData, null, 'id');

        //转换
        array_walk($data['list'], function (&$v) use ($videoData) {
            $videoData[$v['video_id']]['list_time'] = date('Y-m-d H:i:s',$videoData[$v['video_id']]['list_time']);
            $v['videoData'] = $videoData[$v['video_id']];
        });

        //管理员行为日志
        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['list'],
            'total' => $data['total'],
        ]);
    }


    private function checkAccountRegister(array $params)
    {
        $email_flag = Db::table('x2_user')->where([
            'useremail'  => $params['useremail'],
        ])->count();        
        $mobile_flag = Db::table('x2_user')->where([
            'mobile'     => $params['mobile'],
        ])->count();

        if ($email_flag > 1) {
            return 101; 
        } else if ($mobile_flag > 1) {
            return 102;
        }
        return false;
    }
}

