<?php
namespace app\admin\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class Advice extends Base
{
    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {
        $id      		= input('param.id', ''); 
    	$userid    		= input('param.userid', ''); 
        $adminid      	= input('param.adminid', '');
        $content      	= input('param.content', '');
        $username       = input('param.username', '');
        $ip    			= input('param.ip', '');
        $status			= input('param.status', '');
        $is_del		    = input('param.is_del', '');

        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 8);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'create_time');

        $datemin = input('param.datemin', '');
        $datemax = input('param.datemax', '');

        $param = [
            'id'           => $id,
            'userid'       => $userid,
            'adminid'      => $adminid,
            'content'      => $content,
            'username'     => $username,
            'ip'		   => $ip,
            'status'       => $status,
            'is_del'       => $is_del,
            'datemin'      => $datemin,
            'datemax'      => $datemax,
        ];


        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        //获取建议资源
        $data = Loader::model('Advice', 'logic')
                ->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);

        //获取用户详细信息
        $ids      = array_column($data['list'], 'userid');
        $userData = Db::table('x2_user')->where(['userid' => ['in', $ids]])->select();
        $userData = array_column($userData, null, 'userid');
        $ids      = array_column($data['list'], 'adminid');
        $adminData = Db::table('x2_admin')->where(['id' => ['in', $ids]])->select();
        $adminData = array_column($adminData, null, 'id');
        //转换
        array_walk($data['list'], function (&$v) use ($userData,$adminData) {
            $v['userName'] = isset($userData[$v['userid']])?$userData[$v['userid']]['username']:null;
            $v['account'] = isset($userData[$v['userid']])?$userData[$v['userid']]['account']:null;
            $v['adminName'] =  isset($adminData[$v['adminid']])?$adminData[$v['adminid']]['username']:null;
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
        $reply          = input('param.reply', '');


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
            'reply'		   => $reply,
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

    public function del()
    {
    	$id   = input('param.id', '');
    	$data = Db::table('x2_advice')->where(['id'=>$id])->update(['is_del'=>1]);
         return $this->packReturn([
            'code' => empty($data) ? 100:0,
            'msg'  => empty($data) ? '删除失败' : '删除成功',
         ]);
    }    

    public function get()
    {
    	$id   = input('param.id', '');
    	$data = Db::table('x2_advice')->where(['id'=>$id])->find();

    	if (empty($id)) {
    		return $this->packReturn([
            	'code' => 100,
            	'data'  => 'id不能为空',
         	]);	
    	}
        return $this->packReturn([
            'code' => empty($data) ? 100:0,
            'data'  => empty($data) ? '查询失败' : $data,
         ]);
    }



}
