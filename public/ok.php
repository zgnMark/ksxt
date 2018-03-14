

<?php
use Workerman\Worker;
require '/home/wwwroot/ks.nice123.xin/vendor/autoload.php';
// 初始化一个worker容器，监听1234端口
$worker = new Worker('websocket://172.19.156.136:819');
$worker->count = 1;
// 客户端发来消息时，广播给其它用户
foreach($worker->uidConnections as $connection)
{
    $connection->send('111');
}
// 运行worker
Worker::runAll();
