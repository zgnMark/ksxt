<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class ExamRoom extends Base
{
    /**
     * 考场列表
     * @return [type] [description]
     */
    public function lists()
    {
        $param = [
            'is_del' => 0,
        ];
        //获取考场数据
        $data = Loader::model('ExamRoom', 'logic')->getList($param);
        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
        ]);
    }

    /**
     * 考场试卷详情
     * @return [type] [description]
     */
    public function get()
    {
        $id         = input('param.id', 1);
        //获取考场试卷详情
        $data = Db::table('x2_examroom')
            ->where(['id' => $id])
            ->find();
        $tipsData = Db::table('x2_tips')->where(['room_id' => $id])->select();
        foreach ($tipsData as $key => $value) {
            $data['tipsData'][$key]['tipsname'] = $value['content'];
        }
        return $this->packReturn([
            'code'     => 0,
            'paper_info' => $data,
        ]);
    }

}
