<?php
namespace app\api\controller\v1;

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
    	$subject_type   = input('param.subject_type', 0); //0为video 1为书籍 2为工具
    	$subject_id 	= input('param.subject_id', '');
        $title          = input('param.title', '');
        $toolurl        = [];

        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');

        $param = [
            'is_del' => 0,
            'title'  => $title,
            'subject_id'   => $subject_id,
            'subject_type' => $subject_type,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        $subjectData = Db::table('x2_subject')->select();
        //获取课程资源
        $data = Loader::model('SubjectResources', 'logic')
                ->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
        if ($subject_type == 1) {
            array_walk($data['list'], function (&$v) {
                 $v['resources_url'] = explode(':::',$v['resources_url']);
            });
        }
                
        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
            'subject_list' => $subjectData,
            'total'   => $data['total'],
        ]);
    }

}
