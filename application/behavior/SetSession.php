<?php
namespace app\behavior;

use think\Session;

//过滤请求
class SetSession
{
    public function run(&$params)
    {
/*        $header = getallheaders();

        $header = array_change_key_case($header, CASE_LOWER);
        if (isset($header['x-auth-token']) && !empty($header['x-auth-token'])) {
            session_id($header['x-auth-token']);
        }

        Session::start();
        // $sessionId = session_id();
        // Monolog::error('session_id:' . $sessionId, []);
        // define('SESSION_ID', $sessionId);*/
    }
}
