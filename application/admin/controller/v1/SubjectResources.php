<?php
namespace app\admin\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class SubjectResources extends Common
{
    /**
     * 课程列表
     * @return [type] [description]
     */
    public function lists()
    {
        $subject_type   = input('param.subject_type', 0); //0为video 2为书籍 1为工具
        $subject_id     = input('param.subject_id', '');
        $title          = input('param.title', '');


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
        //获取课程资源
        $data = Loader::model('SubjectResources', 'logic')
                ->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
        if ($subject_type == 0) {
        	array_walk($data['list'], function (&$v) {
                $v['videolist'] = Db::table('x2_video_resources')->where(['resource_id'=>$v['id']])->select();
        	});
        }
              

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
        $resources_url  = input('param.resources_url', '');
        $resources_id   = input('param.resources_id', '');
        $description    = input('param.description', '');
        $subject_type   = input('param.subject_type', '');
        $subject_id     = input('param.subject_id', '');
        $create_time    = input('param.create_time', '');
        $is_del         = input('param.is_del', 0);
        $list_time      = input('param.list_time', '11');
        $video		    = input('param.video', '');

        if (empty($subject_id) && $subject_id !== 0) {
            return $this->packReturn([
                'code'  => 100,
                'info' => '课程id不能为空',
            ]);
        }

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('img_url');
        if (!empty($file)) {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>255678,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $img_url = DS . 'uploads' . DS . $info->getSaveName();
            } else {
                // 上传失败获取错误信息
                return $this->packReturn([
                    'code' => 100,
                    'info'  => $file->getError(),
                ]);
            }
        }


/*        $room_data = Db::table('x2_examroom')->select();    
        $ids      = array_column($data['list'], 'room_id');*/
        $params = [
            'title'         => $title,        
            'resources_url' => $resources_url,
            'resource_id'   => $resources_id,
            'video_url'     => $resources_url,
            'img_url'       => $img_url,
            'subject_type'  => $subject_type,  
            'description'   => $description, 
            'subject_id'    => $subject_id,   
            'subject_type'  => $subject_type,   
            'create_time'   => $create_time, 
            'list_time'     => $list_time, 
            'is_del'        => $is_del,       
        ];

        if (!empty($resources_id)) {
            unset($params['subject_type']);
            unset($params['description']);
            unset($params['subject_id']);
            unset($params['resources_url']);
            if (empty($id)) {
                $data = Db::table('x2_video_resources')->insert($params);
            } else {
                $data = Db::table('x2_video_resources')->where(['id'=>$id])->update($params);
                if (!empty($data)) {
                    $news = '课程资源已更新';
                    $this->addNews($news,$subject_id);  
                }
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
        //剔除空
        $params = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });
        unset($params['video_url']);
        unset($params['list_time']);
        if (empty($id)) {
            $data = Db::table('x2_subjectresources')->insert($params);
        } else {
            $data = Db::table('x2_subjectresources')->where(['id'=>$id])->update($params);
            if (!empty($data)) {
                $news = '课程资源已更新';
                $this->addNews($news,$subject_id);  
            }
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

    public function series()
    {
        $data = Db::table('x2_subjectresources')->where(['subject_type'=>0])->select();
        return $this->packReturn([
            'code' => 0,
            'data' => $data,
        ]);
    }
}
