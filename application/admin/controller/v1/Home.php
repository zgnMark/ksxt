<?php
namespace app\admin\controller\v1;

use think\Db;
use \think\Loader;

//use app\vendor\log\Monolog;

class Home extends Common
{

    public function lists()
    {
    	$id = input('param.adminid','');
    	$adminData = Db::table('x2_admin')->find(); 
        $login = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$adminData['ip']);
    	$user = Db::table('x2_user')->count();
    	$news = Db::table('x2_latestnews')->count();
    	$question = Db::table('x2_question')->count();

    	return $this->packReturn([
            'code'   => 0,
            'user'   => $user,
            'news'   => $news,
            'browse'   => 5000,
            'question'   => $question,
            'login'   => $login,
            'adminData' => $adminData,
        ]);
    }
    public function message()
    {
        $id = input('param.adminid','');
        $status = input('param.adminid',0);
        if (!empty($id)) {
            Db::table('x2_message')->where(['id'=>$id])->update(['status'=>$status]);
            return $this->packReturn([
                'code'   => 0,
                'msg'   => '操作成功',
            ]);
        }

        $read = Db::table('x2_message')->where('status',1)->select();
        $unread = Db::table('x2_message')->where('status',0)->select();
        return $this->packReturn([
            'code'   => 0,
            'read'   => $read,
            'unread'   => $unread,
        ]);
    }

}
