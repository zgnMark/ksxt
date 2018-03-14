<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;

class Advice extends Base
{
    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {
        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');

        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        $param = [];
        //获取意见列表
        $data = Loader::model('Advice', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);

        //获取用户详细信息
        $ids      = array_column($data['list'], 'userid');
        $userData = Db::table('x2_user')->where(['userid' => ['in', $ids]])->select();
        $userData = array_column($userData, null, 'userid');

        array_walk($data['list'], function (&$v) use ($userData) {
            $v['userid'] = $userData[$v['userid']]['account'];
        });

        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
            'total'    => $data['total'],
        ]);
    }

    public function commit()
    {
        $content = input('param.content', '');
        $userid =  input('param.userid');
        $where = [
            'userid'  => $userid,
            'content' => $content,
            'create_time' => date('Y-m-d H:i:s', time()),
            'ip'    => $_SERVER['REMOTE_ADDR'],
        ];
        $data = Db::table('x2_advice')->insert($where);
        if (empty($data)) {
            return $this->packReturn([
                'code'    => 100,
                'msg'     => '插入失败',
            ]);
        } 
        Db::table('x2_message')->insert(['content'=>'有新的建议待处理','create_time'=>time()]);
        return $this->packReturn([
            'code'    => 0,
            'msg'     => '插入成功',
        ]);

    }

}
