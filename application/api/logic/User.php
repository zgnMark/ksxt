<?php
/**
 * @Author     yhz
 * @time       2018/2/9
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\logic;

use app\vendor\log\Monolog;
use Think\Db;

class User extends BaseLogic
{

    /**
     * 更新用户
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function updateUser(array $params)
    {
        //剔除空
        $params = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });
        $id = $params['user_id'];
        unset($params['user_id']);

        $flag = Db::table('j_sysuser_user')
            ->where(['user_id' => $id])
            ->update($params);

        if ($flag === false) {
            Monolog::error('更新失败,[api.UserLogic.updateUser]:', [$params]);
            throw new \Exception("更新失败", 3);
        }
        return true;
    }

    /**
     * 更新用户账号表信息
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function updateUserBase(array $params)
    {
        //剔除空
        $params = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
            return !empty($v);
        });

        $flag = Db::table('j_sysuser_account')
            ->where(['id' => $params['id']])
            ->update($params);

        if ($flag === false) {
            Monolog::error('更新失败,[api.UserLogic.updateUserBase]:', [$where]);
            throw new \Exception("更新失败", 3);
        }
        return true;
    }

}
