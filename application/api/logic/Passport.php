<?php
/**
 * @Author     yhz (351699382@qq.com)
 * @time       2017-12-04
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\logic;

use app\vendor\log\Monolog;
use Ramsey\Uuid\Uuid;
use think\Db;
use think\Request;

class Passport extends BaseLogic
{

    /**
     *
     * @return [type] [description]
     */
    public function __construct()
    {

    }

    /**
     * 登录操作
     * @return [type] [description]
     */
    public function login(array $params)
    {
        $arr = [];
        $userData = Db::table('x2_user')
            ->where('mobile|useremail','like', '%'. $params['account'] . '%')
            ->where('is_del', 'eq', 0)
            ->find();
        try {
            if (empty($userData)) {
                throw new \Exception("不存在该用户", 1);
            }
            if ($userData['status'] != 0) {
                throw new \Exception("已冻结，请联系管理员", 1);
            }
            if ($userData['userpassword'] != $params['userpassword']) {
                throw new \Exception("密码有误", 1);
            }
        } catch (\Exception $e){
            $arr['code'] = 100;
            $arr['msg'] = $e->getMessage();
            return $arr;
        }
        $arr['code'] = 0;
        $arr['data'] = $userData;
        Db::table('x2_user')->where('userid', 'eq', $userData['userid'])->update(['update_time' => date('Y-m-d H:i:s')]);
        return  $arr;
    }


    /**
     * 注册用户
     */
    public function createUser(array $params)
    {
        $flag = [];
        try {
            Db::startTrans();
            if ($this->checkAccountRegister($params)) {
                return $this->checkAccountRegister($params);
            }
            //剔除空
            $where = array_filter($params, function ($v) {
            if (is_numeric($v) && ($v == 0)) {
                return true;
            }
                return !empty($v);
            });
            //创建
            $sysuserAccountData = [
                'usertruename'     => $params['usertruename'],
                'username'         => $params['usertruename'],
                'useremail'        => $params['useremail'],
                'mobile'           => $params['mobile'],
                'type'             => $params['type'],
                'userpassword'     => $params['userpassword'], // passwd($params['login_password']),
                'status'           => 0,
                'userregip'        => $_SERVER["REMOTE_ADDR"],
                'userregtime'      => date('Y-m-d H:i:s'),
                'userlogtime'      => date('Y-m-d H:i:s'),
                'update_time'      => date('Y-m-d H:i:s'),
            ];

            $flag = Db::table('x2_user')->insert($sysuserAccountData);
            if ($flag === false) {
                $code =103;
                throw new \Exception("创建用户失败", 1);
            }
            $userId        = Db::table('x2_user')->getLastInsID();
            $accountNumber = $this->setAccountNumber($userId);
            $flag          = Db::table('x2_user')->where(['userid' => $userId])->update(['account' => $accountNumber]);
            if ($flag === false) {
                $code = 104;
                throw new \Exception( "更新account_number失败", 1);           
            }
        } catch (\Exception $e) {
            Db::rollback();
            Monolog::error('创建用户失败,[Api.Passport.createUser]:' . $e->getMessage(), [$params]);
            return $code;
        }
        return 0;
    }
    //得到用户信息
    public function getUserInfo(array $params)
    {
        $userData = Db::table('x2_user')->where([
            'mobile'             => $params['mobile'],
            'is_del'           => 0,
        ])->find();

        if (empty($userData)){
            return false;
        }
        return $userData;
    }

    //用户编号
    private function setAccountNumber($userId)
    {
        $accountNumber = '1' . str_pad($userId, 7, 0, STR_PAD_LEFT);
        $accountData   = Db::table('x2_user_account')->where(['account_number' => $accountNumber])->count();
        if (!empty($accountData)) {
            $this->setAccountNumber($userId);
        }
        ($accountData > 0) && $accountNumber = $this->setAccountNumber($userId);
        return 'DY-'.$accountNumber;
    }

    /**
     * 检测用户是否被注册
     * [checkAccount description]
     * @return [type] bool，存在返回true,否则返回false
     */
    private function checkAccountRegister(array $params)
    {
        $email_flag = Db::table('x2_user')->where([
            'useremail'  => $params['useremail'],
        ])->count();        
        $mobile_flag = Db::table('x2_user')->where([
            'mobile'     => $params['mobile'],
        ])->count();
        if ($email_flag > 0) {
            return 101; 
        } else if ($mobile_flag > 0) {
            return 102;
        }
        return false;
    }
}
