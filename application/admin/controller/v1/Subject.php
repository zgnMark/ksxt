<?php
namespace app\admin\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class Subject extends Base
{
    /**
     * 课程列表
     * @return [type] [description]
     */
    public function lists()
    {
        $id             = input('param.id', '');
        $title          = input('param.title', '');
        $create_time    = input('param.create_time', '');

        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');

        $param = [
            'is_del' => 0,
            'title'  => $title,
            'id'     => $id,
            'create_time' => $create_time,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        //获取课程资源
        $data = Loader::model('Subject', 'logic')
                ->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);

        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
            'total'   => $data['total'],
        ]);
    }

    public function save()
    {   
        $id             = input('param.id', '');
        $title          = input('param.title', '');
        $is_del         = input('param.is_del',0);

        $params = [
            'is_del'        => $is_del,
            'title'         => $title,         
        ];
        //剔除空
        $params = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });
        if (empty($id)) {
            $data = Db::table('x2_subject')->insert($params);
        } else {
            $data = Db::table('x2_subject')->where(['id'=>$id])->update($params);
        }
       
        if (empty($data)) {
            return $this->packReturn([
                'code' => 100,
                'msg'  => empty($id) ? '创建失败' : '编辑失败',
            ]);
        }
        return $this->packReturn([
            'code' => 0,
            'msg'  => empty($id) ? '创建成功' : '编辑成功',
        ]);
    }

}
