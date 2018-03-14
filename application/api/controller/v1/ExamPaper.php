<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class ExamPaper extends Base
{
    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {
        $param = [
            'is_del' => 0,
        ];
        //获取试卷列表
        $data = Loader::model('ExamPaper', 'logic')->getList($param);
        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
            'totle'   => $data['totle'],
        ]);
    }

    /**
     * 考场试卷详情
     * @return [type] [description]
     */
    public function get()
    {
        $id         = input('param.room_id', 0);
        //获取考场试卷详情
        $data = Db::table('x2_exampaper')
            ->where(['room_id' => $id])
            ->find();
        return $this->packReturn([
            'code'     => 0,
            'data' => $data,
        ]);
    }

}
