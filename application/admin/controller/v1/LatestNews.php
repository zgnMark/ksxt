<?php
namespace app\admin\controller\v1;

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
        $news_type      = input('param.new_type', ''); //0为考试 1为课程 2为其他
    	$new_type_id    = input('param.new_type_id', ''); //0为考试 1为课程 2为其他
        $publisher      = input('param.publisher', '');
        $content        = input('param.content', '');
        $new_type       = input('param.new_type', '');
        $subject_id     = input('param.subject_id', '');
        $is_del         = input('param.is_del', '');
        $id             = input('param.id', '');

        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'create_time');

        $datemin = input('param.datemin', '');
        $datemax = input('param.datemax', '');

        $param = [
            'id'           => $id,
            'is_del'       => $is_del,
            'news_type'    => $new_type_id,
            'publisher'    => $publisher,
            'content'      => $content,
            'subject_id'   => $subject_id,
            'datemin'      => $datemin,
            'datemax'      => $datemax,
        ];

        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        //获取课程资源
        $data = Loader::model('LatestNews', 'logic')
                ->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);

/*        return $this->packReturn([
            'code'    => 0,
            'list'    => $data,
        ]);*/
        //转换
        array_walk($data['list'], function (&$v) {
            $v['news_type_id'] = $v['new_type'];
            switch ($v['new_type']) {
                case 0:
                    $v['new_type'] = '考试';
                    break;
                case 1:
                    $v['new_type'] = '课程';
                    break;
                case 2:
                    $v['new_type'] = '其他';
                    break;
                default:
                   $v['new_type'] = '考试';
                    break;
            }
        });
        return $this->packReturn([
            'code'    => 0,
            'list'    => $data['list'],
            'total'   => $data['total'],
        ]);
    }

     /**
     * 修改添加
     * @return [type] [description]
     */
    public function save()
    {   
        $id             = input('param.id', '');
        $new_type_id    = input('param.new_type_id', ''); //0为考试 1为课程 2为其他
        $publisher      = input('param.publisher', '');
        $content        = input('param.content', '');
        $subject_id     = input('param.subject_id', '');
        $is_del         = input('param.is_del', '');
        $title          = input('param.title', '');


        // 获取表单上传文件 例如上传了001.jpg
/*        $file = request()->file('img');
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
        }*/

/*        $room_data = Db::table('x2_examroom')->select();    
        $ids      = array_column($data['list'], 'room_id');*/
        $params = [
            'is_del'       => $is_del,
            'news_type'    => $new_type_id,
            'publisher'    => $publisher,
            'content'      => $content,
            'subject_id'   => $subject_id,  
            'title'        => $title,
        ];
        //剔除空
        $params = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });
/*        return $this->packReturn([
            'code' => 0,
            'msg'  => $params,
        ]);*/
        if (empty($id)) {
            $params['create_time'] = time();
            $data = Db::table('x2_latestnews')->insert($params);
        } else {
            $data = Db::table('x2_latestnews')->where(['id'=>$id])->update($params);
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


    public function get()
    {
        $id   = input('param.id', '');
        if (empty($id)) {
            return $this->packReturn([
                'code'     => 100,
                'new_info' => 'id不能为空',
            ]);
        }
        $data = Db::table('x2_latestnews')
            ->where(['id' => $id])
            ->find();

        return $this->packReturn([
            'code'     => 0,
            'new_info' => $data,
        ]);
    }

}
