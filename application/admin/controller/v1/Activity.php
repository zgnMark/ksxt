<?php
namespace app\admin\controller\v1;

use think\Db;
use \think\Loader;

class Activity extends Common
{

    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {
        $page        = input('param.page', 1);
        $pageSize    = input('param.pageSize', 20);
        $order       = input('param.order', 'desc');
        $orderField  = input('param.order_field', 'id');
        $language_id = input('param.language_id', '');
        $admin_id    = input('param.admin_id', '');
        $title       = input('param.title', '');
        $cover_img   = input('param.cover_img', '');
        $content     = input('param.content', '');
        $country_id  = input('param.country_id', '');
        $address     = input('param.address', '');
        $view_num    = input('param.view_num', '');
        $status      = input('param.status', '');
        $is_del      = input('param.is_del', '');
        $update_time = input('param.update_time', '');
        $create_time = input('param.create_time', '');

        $param = [
            'language_id' => $language_id,
            'admin_id'    => $admin_id,
            'title'       => $title,
            'cover_img'   => $cover_img,
            'content'     => $content,
            'country_id'  => $country_id,
            'address'     => $address,
            'view_num'    => $view_num,
            'status'      => $status,
            'is_del'      => $is_del,
            'update_time' => $update_time,
            'create_time' => $create_time,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];

        $data = Loader::model('activity', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);

        //获取admin详细信息
        $ids       = array_column($data['list'], 'admin_id');
        $adminData = Db::table('j_admin')->where(['id' => ['in', $ids]])->select();
        $adminData = array_column($adminData, null, 'id');
        //获取所有区域
        $countryData = Loader::model('Country', 'logic')->getAlls();
        $countryData = array_column($countryData, null, 'id');
        //语言
        $language = Db::table('j_language')->select();
        $language = array_column($language, null, 'id');

        //转换
        array_walk($data['list'], function (&$v) use ($countryData, $adminData, $language) {
            $v['country_id']  = isset($countryData[$v['country_id']]) ? $countryData[$v['country_id']]['name'] : null;
            $v['admin_id']    = isset($adminData[$v['admin_id']]) ? $adminData[$v['admin_id']]['username'] : null;
            $v['language_id'] = isset($language[$v['language_id']]) ? $language[$v['language_id']]['name'] : null;
        });

        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '获取活动列表', 'post' => $_POST]);
        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['list'],
            'total' => $data['total'],
        ]);
    }

    /**
     * 删除活动
     * @return [type] [description]
     */
    public function del()
    {
        $id     = input('param.id', 0);
        $params = ['is_del' => 1];
        $flag   = Db::table('j_activity')
            ->where(['id' => (int) $id])
            ->update($params);
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '删除一个国家', 'post' => $_POST]);
        return $this->packReturn([
            'code' => 0,
            'msg'  => '删除成功',
        ]);
    }

    /**
     * 活动
     * @return [type] [description]
     */
    public function get()
    {
        $id   = input('post.id', 0);
        $data = Db::table('j_activity')
            ->where(['id' => (int) $id])
            ->find();
        return $this->packReturn([
            'code' => 0,
            'info' => $data,
        ]);
    }

    /**
     * 添加一个活动
     * @return [type] [description]
     */
    public function saveActivity()
    {
        $id           = input('param.id', '');
        $language_id  = input('param.language_id', '');
        $admin_id     = input('param.admin_id', '');
        $title        = input('param.title', '');
        $cover_img    = input('param.cover_img', '');
        $content      = input('param.content', '');
        $country_id   = input('param.country_id', '');
        $address      = input('param.address', '');
        $view_num     = input('param.view_num', '');
        $status       = input('param.status', '');
        $is_del       = input('param.is_del', '');
        $singer       = input('param.singer', null);
        $publish_time = input('param.publish_time', null);
        $start_time   = input('param.start_time', '');
        $end_time     = input('param.end_time', '');

        $params = [
            'id'          => $id,
            'language_id' => $language_id,
            'admin_id'    => $admin_id,
            'title'       => $title,
            'cover_img'   => $cover_img,
            'content'     => $content,
            'country_id'  => $country_id,
            'singer'      => $singer,
            'address'     => $address,
            'view_num'    => $view_num,
            'status'      => $status,
            'is_del'      => $is_del,
            'start_time'  => $start_time,
            'end_time'    => $end_time,
            'admin_id'    => $this->getLoginUser()['id'],
        ];
        if (!empty($publish_time)) {
            $params['publish_time'] = $publish_time;
        }

        $data = Loader::model('Activity', 'logic')->saveActivity($params);
        //管理员行为日志
        if (empty($id)) {
            $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '创建一个活动', 'post' => $_POST]);
        } else {
            $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '编辑一个活动', 'post' => $_POST]);
        }
        return $this->packReturn([
            'code' => 0,
            'msg'  => empty($id) ? '创建成功' : '编辑成功',
        ]);
    }

}
