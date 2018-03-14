<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class video extends Base
{
    /**
     * 视频列表
     * @return [type] [description]
     */
    public function lists()
    {
    	$video_id 	= input('param.id', '');

        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');

        $param = [
            'is_del' => 0,
            'video_id' => $video_id,
        ];
        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];

        $data['list'] = Db::table('x2_video_resources')->where($param)->find();
        $data['total'] = Db::table('x2_video_resources')->where($param)->count();

        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
            'total'   => $data['total'],
        ]);
    }

    public function play()
    {
        $video_id   = input('param.id', '');
        $data = Db::table('x2_video_resources')->where(['id'=>$video_id])->find();
        $list = Db::table('x2_video_resources')->where(['resource_id'=>$data['resource_id']])->select();
        return $this->packReturn([
            'code'    => 0,
            'data'    => $data,
            'list'    => $list,
        ]);
    }
}
