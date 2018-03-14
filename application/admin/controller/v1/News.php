<?php
namespace app\admin\controller\v1;

use think\worker\Server;
class News extends Server
{
	 protected $socket = 'websocket://172.19.156.136:819';
    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        $connection->send('我收到你的信息了');
    }

    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
/*        Db::table('x2_advice')->()
        if () {
            # code...
        }*/
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        
    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }

    /**
     * 列表
     * @return [type] [description]
     */
    public function onWorkerStart($worker)
    {
    	global $worker;
    }

    // 向所有验证的用户推送数据
	public function send()
	{
   		global $worker;
   		foreach($worker->uidConnections as $connection)
   		{
        	$connection->send('11');
   		}
	}


}
