<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class LatestNews extends Base
{
    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {
    	$new_type  = input('param.new_type', ''); //0为考试 1为课程 2为其他

        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'create_time');

        $param = [
            'is_del' => 0,
            'new_type'    => $new_type
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        //获取课程资源
        $data = Loader::model('LatestNews', 'logic')
                ->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
            'total'   => $data['total'],
        ]);
    }

     /**
     * 资讯详情
     * @return [type] [description]
     */
    public function get()
    {
        $id   = input('param.id', 0);
        $data = Db::table('x2_latestnews')
            ->where(['id' => $id])
            ->find();
        $about = Db::table('x2_latestnews')
        	->limit(5)
        	->where(['subject_id' => $data['subject_id']])
        	->select();
        return $this->packReturn([
            'code' 	   => 0,
            'new_info' => $data,
            'about'	   => $about
        ]);
    }

}
