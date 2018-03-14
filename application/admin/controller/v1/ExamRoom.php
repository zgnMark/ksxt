<?php
namespace app\admin\controller\v1;

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
        $data = Db::table('x2_examroom')->select();
        return $this->packReturn([
            'code'  => 0,
            'list'  => $data,
        ]);
    }

    /**
     * 保存一个考场信息
     * @return [type] [description]
     */
    public function save()
    {
        $id           = input('param.id', '');
        $title        = input('param.title', '');
        $subject_id   = input('param.subject_id', '');
        $area         = input('param.area', '');
        $description  = input('param.description', '');
        $exam_time    = input('param.exam_time', '');
        $job          = input('param.job', '');

        $file          = request()->file('img_url');

/*        if (empty($password)) {
            return '你传的数据是空的吉吉';
        } else{
            return 11;
        }*/
/*
        return $this->packReturn([
            'code' => $file,
            'msg'  => $img_url,
        ]);*/

        // 获取表单上传文件 例如上传了001.jpg
        if (!empty($file)) {
            $info = $file->validate(['size'=>155678,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads'. DS . 'room' . DS,'');

            if ($info) {
                $img_url = DS . 'uploads' . DS .'room'.DS. $info->getSaveName();
            } else {
                // 上传失败获取错误信息
                return $this->packReturn([
                    'code' => 100,
                    'info'  => $file->getError(),
                ]);
            }
        }

        $params = [
            'id'          => $id,
            'title'       => $title,
            'img_url'     => $img_url,
            'area'        => $area,
            'exam_time'   => $exam_time,
            'description' => $description,
        ];

        $data = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });
        if (isset($params['id']) && $params['id'] > 0) {
            $flag = Db::table('x2_examroom')
                ->where(['id' => $params['id']])
                ->update($params);
            if ($flag === false) {
                return $this->packReturn([
                    'code' => 100,
                    'msg'  => '编辑失败',
                ]);
            }
        } else {
            $flag = Db::table('x2_examroom')->insert($params);
            if ($flag === false) {
                return $this->packReturn([
                    'code' => 100,
                    'msg'  => '创建失败',
                ]);
            }
        }
        
        return $this->packReturn([
            'code' => 0,
            'msg'  => empty($id) ? '创建成功' : '编辑成功',
        ]);
    }

    /**
     * 删除考场
     * @return [type] [description]
     */
    public function del()
    {
        $id     = input('param.id', 0);
        $params = ['is_del' => 1];
        $flag   = Db::table('x2_examroom')
            ->where(['id' => (int) $id])
            ->update($params);
        
        return $this->packReturn([
            'code' => 0,
            'msg'  => '删除成功',
        ]);
    }
    /**
     * 考场info
     * @return [type] [description]
     */
    public function info()
    {
        $data = Db::table('x2_job')->select();
        return $this->packReturn([
            'code' => 0,
            'data'  => $data,
        ]);
    }

    public function test()
    {
        $id           = input('param.test', '');
        $image        = input('param.image', '');
        return $this->packReturn([
            'code' => 0,
            'data' => $_FILES['test'],
        ]);
    }


}
