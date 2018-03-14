<?php
namespace app\admin\controller\v1;

//use app\vendor\log\Monolog;
use think\Db;
use \think\Loader;

class Country extends Common
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
        $orderField = input('param.order_field', 'sort');
        $id         = input('param.id', '');

        $param = [
            'id' => $id,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];

        $data = Loader::model('Country', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '获取国家列表', 'post' => $_POST]);

        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['list'],
            'total' => $data['total'],
        ]);
    }

    /**
     * 获取所有
     * @return [type] [description]
     */
    public function getAlls()
    {
        $data = Loader::model('Country', 'logic')->getAlls();
        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '获取所有国家信息', 'post' => $_POST]);

        return $this->packReturn([
            'code' => 0,
            'list' => $data,
        ]);
    }

    /**
     * 获取一条
     * @return [type] [description]
     */
    public function get()
    {
        $id   = input('param.id', 0);
        $data = Db::table('j_country')
            ->where(['id' => $id])
            ->find();
        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '获取一个国家信息', 'post' => $_POST]);

        return $this->packReturn([
            'code' => 0,
            'info' => $data,
        ]);
    }

    /**
     * 添加一个国家
     * @return [type] [description]
     */
    public function saveCountry()
    {
        $id           = input('param.id', '');
        $name         = input('param.name', '');
        $chinese_name = input('param.chinese_name', '');
        $english_name = input('param.english_name', '');
        $logo         = input('param.logo', '');
        $status       = input('param.status', '');
        $areaCode     = input('param.area_code', '');
        $sort         = input('param.sort', '');
        $params       = [
            'id'           => $id,
            'name'         => $name,
            'chinese_name' => $chinese_name,
            'english_name' => $english_name,
            'logo'         => $logo,
            'status'       => $status,
            'area_code'    => $areaCode,
            'sort'         => $sort,
        ];
        $data = Loader::model('Country', 'logic')->saveCountry($params);
        //管理员行为日志
        if (empty($id)) {
            $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '创建一个国家', 'post' => $_POST]);
        } else {
            $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '编辑一个国家', 'post' => $_POST]);
        }
        return $this->packReturn([
            'code' => 0,
            'msg'  => empty($id) ? '创建成功' : '编辑成功',
        ]);
    }

    /**
     * 删除国家
     * @return [type] [description]
     */
    public function del()
    {
        $id     = input('param.id', 0);
        $params = ['is_del' => 1];
        $flag   = Db::table('j_country')
            ->where(['id' => (int) $id])
            ->update($params);
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '删除一个国家', 'post' => $_POST]);
        return $this->packReturn([
            'code' => 0,
            'msg'  => '删除成功',
        ]);
    }

}
