<?php
namespace app\push\controller;

use think\worker\Server;

class Worker extends Server
{
    protected $socket = 'websocket://172.19.156.136:819';

    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        //$connection->send('我收到你的信息了');

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
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {
    }

    // 向所有验证的用户推送数据
    public function broadcast()
    {
       global $worker;
       foreach($worker->uidConnections as $connection)
       {
            $connection->send();
       }
    }
    
    // 针对uid推送数据
    public function sendMessageByUid($uid, $message)
    {
        global $worker;
        if(isset($worker->uidConnections[$uid]))
        {
            $connection = $worker->uidConnections[$uid];
            $connection->send($message);
        }
    }

}
