<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class Index extends Base
{
    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {
        $userid     = input('param.user_id', '');
        $ScoereData = false;
        if (!empty($userid)) {
            $ScoereData = Db::table('x2_examhistory')->limit(1)->where(['uerid' => $userid])->order(['order'=>'desc','order_field'=>'create_time'])
            ->select();
        }


        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');

        $param = [
            'is_del' => 0,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        //获取考场数据
        $ExamRoomData = Loader::model('ExamRoom', 'logic')
        				->getList($param, $orderSort);
        //获取最新资讯数据
        $LatestNewsData = Loader::model('LatestNews', 'logic')
        				->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
/*        foreach ($LatestNewsData['list'] as $key => $value) {
            if (!empty($LatestNewsData)) {
                $LatestNewsData[$key]['create_time']  = date('Y-m-d H:i:s',$value['create_time']);
            }
        }*/
        //获取课程数据
        $SubjectData = Loader::model('Subject', 'logic')
        				->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);

        return $this->packReturn([
            'code'  	    => 0,
            'examroom'      => $ExamRoomData['list'],
            'latest_news'   => $LatestNewsData['list'],
            'subject'       => $SubjectData['list'],
            'recent_score'  => $ScoereData  
        ]);
    }

}
