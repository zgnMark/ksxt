<?php
namespace app\admin\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class ExamHistory extends Base
{
    /**
     * 历史试卷列表
     * @return [type] [description]
     */
    public function lists()
    {
        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 20);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');

        $user_id    = input('param.user_id', '');
        $subject_id = input('param.subject_id', '');
        $room_id    = input('param.room_id', '');
        $paper_id   = input('param.paper_id', '');
        $score   	= input('param.score', '');
        $username  = input('param.username', '');

        $datemin = input('param.datemin', '');
        $datemax = input('param.datemax', '');        
        $scoremin = input('param.scoremin', '');
        $scoremax = input('param.scoremax', '');
        $param = [
            'user_id' 		=> $user_id,
            'subject_id'    => $subject_id,
            'room_id'    	=> $room_id,
            'paper_id'   	=> $paper_id,
            'score'			=> $score,
            'username'      => $username,
            'datemin'      => $datemin,
            'datemax'      => $datemax,
            'scoremin'      => $scoremin,
            'scoremax'      => $scoremax,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];

        $data = Loader::model('ExamHistory', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
        //获取用户详细信息
        $ids      = array_column($data['list'], 'user_id');
        $userData = Db::table('x2_user')->where(['userid' => ['in', $ids]])->select();
        $userData = array_column($userData, null, 'userid');


        //获取所有区域
        $ids      = array_column($data['list'], 'room_id');
        $roomData = Db::table('x2_examroom')->where(['id' => ['in', $ids]])->select();
        $roomData = array_column($roomData, null, 'id');

        //转换
        array_walk($data['list'], function (&$v) use ($userData, $roomData) {
            $v['roomData'] = isset($roomData[$v['room_id']]) ? $roomData[$v['room_id']] : null;
            $v['userData'] = isset($userData[$v['user_id']]) ? $userData[$v['user_id']] : null;
        });
        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['list'],
            'total' => $data['total'],
        ]);
    }
    /**
     * 删除
     * @return [type] [description]
     */
    public function del()
    {
        $id     = input('param.id', 0);
        $params = ['is_del' => 1];
        $flag   = Db::table('x2_examroom')
            ->where(['id' => (int) $id])
            ->update($params);
        
        return $this->packReturn([
            'code' => 0,
            'msg'  => '删除成功',
        ]);
    }
}
