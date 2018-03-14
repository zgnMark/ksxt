<?php
/**
 * @Author     SuJun (351699382@qq.com)
 * @time       2017-12-04
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\Common\logic;

use think\Config;
use think\Db;

class Currency
{

    /**
     * 更新，添加或减少金币
     * @param  array  $params [
     *     user_id,
     *     currency, //变动金币
     *     type_id, //类型，配置文件查看
     *     remarks
     * ]
     * @return [type]         [description]
     */
    public function updated(array $params)
    {
        try {
            Db::startTrans();
            //获取原值
            $userData = Db::table('j_sysuser_user')->where(['user_id' => $params['user_id']])->lock(true)->find();
            //获取类型配置
            $currencyConfig = Config::get('param.currency');

            //检测
            if (!isset($currencyConfig[$params['type_id']])) {
                throw new \Exception("没有该变动类型", 1);
            }
            if (empty($userData)) {
                throw new \Exception("没有指定更新用户", 1);
            }
            if ($params['type'] == 1 && ($params['currency'] > $userData['currency'])) {
                throw new \Exception("金币不足以抵扣", 1);
            }

            //设置余额
            if ($currencyConfig[$params['type_id']]['type'] == 0) {
                $currencyBalance = $userData['currency'] + $params['currency'];
            } else {
                $currencyBalance = $userData['currency'] - $params['currency'];
            }

            //添加日志
            Db::table('j_currency_log')
                ->insert([
                    'user_id'          => $params['user_id'],
                    'currency'         => $params['currency'],
                    'currency_balance' => $currencyBalance,
                    'type'             => $currencyConfig[$params['type_id']]['type'], //0增加，1扣除
                    'type_id'          => $params['type_id'], //根据配置状态
                    'amount'           => $params['currency'] * 1, //按当时的比例增加
                    'remarks'          => isset($params['remarks']) ? $params['remarks'] : $currencyConfig[$params['type_id']]['title'],
                    'is_del'           => 0,
                    'update_time'      => date('Y-m-d H:i:s'),
                    'create_time'      => date('Y-m-d H:i:s'),
                ]);
            //更新用户表
            Db::table('j_sysuser_user')
                ->where(['user_id' => $params['user_id']])->update(['currency' => $currencyBalance]);

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            Monolog::error('更新失败,[Common.Currency.updated]:' . $e->getMessage(), [$params]);
        }
        return false;
    }

}
