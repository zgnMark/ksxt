<?php
namespace app\admin\controller\v1;

use think\Db;
class Cronton
{
    /**
     * 删除
     * @return [type] [description]
     */
    public function del()
    {
    	$map['create_time'] = array('elt', time());
        $flag   = Db::table('x2_monolog')
            ->where('create_time','<',date('Y-m-d H:i:s',time()))
            ->delete();
        return 0;
    }
}
