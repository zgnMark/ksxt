<?php
namespace app\api\controller\v1;

use app\vendor\cache\Cache;
use app\vendor\log\Monolog;
use Ramsey\Uuid\Uuid;
use think\Db;
use think\Loader;
use \think\Validate;

class Passport extends Base
{
    /**
     * 注册
     * @return [type] [description]
     */
    public function register()
    {
        $mobile         = input('param.mobile', '');
        $email          = input('param.email', '');
        $loginPassword  = input('param.password', '');
        $usertruename   = input('param.usertruename', '');
        $type           = input('param.type', '');//0pc 1移动端


        //qq, wechat, sina ,mobile
        //$type = input('param.type', 'mobile');
        //如果第三方登录，先判断之前有没注册过,有则跳转至登录

        $sysuserAccountData = [
            'mobile'        => $mobile,
            'useremail'     => $email,
            'userpassword'  => md5($loginPassword),
            'usertruename'  => $usertruename,
            'type'          => $type
        ];
        $validate = new Validate([
                'usertruename'  => 'require|max:25',
                'useremail' => 'email'
        ]);
        if (!$validate->check($sysuserAccountData)) {
            return $this->packReturn([
                'code' => 100,
                'msg'  => $validate->getError(),
            ]);
        }
        $flag = Loader::model('Passport', 'logic')->createUser($sysuserAccountData);
        if ($flag === 0) {
            return $this->packReturn([
                'code' => 0,
                'msg'  => '注册成功！',
            ]);
        } else {
            return $this->packReturn([
                'code' => $flag,
                'msg'  => '注册失败',
            ]);
        }
    }

    /**
     * 登录
     * @return [type] [description]
     */
    public function login()
    {
        try {
            $account        = input('param.account', '');
            $loginPassword  = input('param.password', '');
            $type           = input('param.type', 0);

            $sysuserAccountData = [
                'account'        => $account,
                'userpassword'   => md5($loginPassword),
                'type'           => $type
            ];
            //登录
            $flag = Loader::model('Passport', 'logic')->login($sysuserAccountData);

            if ($flag['code'] === 0) {
                $userdata = Loader::model('Passport', 'logic')->getUserInfo($flag['data']);
                $uuid4 = Uuid::uuid4();
                $uuid = $uuid4->toString() . $userdata['userid'];
                $cache = new Cache([]);
                $sessionflag = $cache->setSession($uuid, 'user', $userdata);
                if ($userdata === false || $sessionflag === false) {
                    throw new \Exception("保存用户信息失败", 1);
                } else {

                    return $this->packReturn([
                        'code'    => 0,
                        'token'   => $uuid,
                        'userdata'=> $userdata,
                        'msg'     => '登录成功',
                    ]);
                }
            } else {
                throw new \Exception($flag['msg'], 1);
            }
        } catch (\Exception $e) {
            Monolog::error('登录失败,[Api.Passport.login]:' . $e->getMessage(), []);
            return $this->packReturn([
                'code' => 100,
                'msg'  => '登录失败'.$e->getMessage(),
            ]);
        }
    }

    /**
     * 退出登录
     * @return [type] [description]
     */
    public function logOut()
    {
        $cache = new Cache([]);
        $token = $this->getToken();
        $count = $cache->delete($token);
        return $this->packReturn([
            'code' => (!empty($token) && $count > 0) ? 0 : 100,
            'msg'  => (!empty($token) && $count > 0) ? '退出成功' : '退出失败',
        ]);        
/*        return $this->packReturn([
            'code' => (!empty($token)) ? 0 : 100,
            'msg'  => (!empty($token)) ? '退出成功' : '退出失败',
        ]);*/
    }
}
