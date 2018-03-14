#!/usr/bin/env php
<?php
ini_set('display_errors', 'on');
if(strpos(strtolower(PHP_OS), 'win') === 0)
{
    exit("start.php not support windows.\n");
}
// 检查扩展
if(!extension_loaded('pcntl'))
{
    exit("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}
if(!extension_loaded('posix'))
{
    exit("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}
define('APP_PATH', __DIR__ . '/application/');
define('BIND_MODULE','push/Run');
// 加载框架引导文件
require '/home/wwwroot/ks.nice123.xin/vendor/autoload.php';
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';

