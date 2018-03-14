<?php
/**
 * @Author     SuJun (351699382@qq.com)
 * @time       2017-12-04
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\admin\controller\v1;

use app\admin\model\ActionLog as AL;
use app\admin\model\Monolog as MonologModel;
use app\admin\model\Schedule as S;
use app\admin\model\ScheduleLog as SL;
use think\Db;
use \think\Loader;

//use app\vendor\log\Monolog;

class System extends Common
{

    /**
     * 获取系统日志
     * @return [type] [description]
     */
    public function getSystemLog()
    {
        $createTimeMax = input('datemax');
        $createTimeMin = input('datemin');
        $message       = input('message');
        $channel       = input('channel');
        $level         = input('level');

        $where   = [];
        $whereOr = [];

        if (!empty($channel)) {
            $where['channel'] = array('eq', $channel);
        }
        if (!empty($message)) {
            $where['message'] = array('like', '%' . $message . '%');
        }
        if (!empty($level)) {
            $where['level'] = $level;
        }
        if (!empty($createTimeMin)) {
            $where['create_time'] = array('egt', $createTimeMin . ' 00:00:00');
        }
        if (!empty($createTimeMax)) {
            $where['create_time'] = array('elt', $createTimeMax . ' 23:59:59');
        }
        if (!empty($createTimeMin) && !empty($createTimeMax)) {
            $where['create_time'] = array('between', $createTimeMin . ' 00:00:00' . ',' . $createTimeMax . ' 23:59:59');
        }
        $order    = input('order', 'DESC');
        $order_by = input('orderBy', 'id');
        $pageSize = input('pageSize', 20);
        $orders   = [
            $order_by => $order,
        ];

        $data = (new MonologModel())->searchs($where, $whereOr, $orders, $pageSize);
        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '获取系统日志', 'post' => $_POST]);

        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['data'],
            'total' => $data['total'],
            'start' => $data['start'],
        ]);
    }

    /**
     * 任务列表
     * @return [type] [description]
     */
    public function getScheduleList()
    {

        $where    = [];
        $whereOr  = [];
        $order    = input('order', 'DESC');
        $order_by = input('orderBy', 'id');
        $pageSize = input('pageSize', 20);
        $orders   = [
            $order_by => $order,
        ];
        $data = (new S())->searchs($where, $whereOr, $orders, $pageSize);
        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '获取任务列表', 'post' => $_POST]);
        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['data'],
            'total' => $data['total'],
            'start' => $data['start'],
        ]);
    }

    /**
     * 执行日志列表
     * @return [type] [description]
     */
    public function getScheduleLogList()
    {

        $createTimeMax = input('post.datemax');
        $createTimeMin = input('post.datemin');

        $standardOutput = input('post.standard_output');
        $errorOutput    = input('post.error_output');
        $id             = input('post.id');

        $where   = [];
        $whereOr = [];

        if (!empty($standardOutput)) {
            $where['standard_output'] = array('like', '%' . $standardOutput . '%');
        }

        if (!empty($errorOutput)) {
            $where['error_output'] = array('like', '%' . $errorOutput . '%');
        }

        if (!empty($createTimeMin)) {
            $where['start_time'] = array('egt', $createTimeMin . ' 00:00:00');
        }

        if (!empty($createTimeMax)) {
            $where['start_time'] = array('elt', $createTimeMax . ' 23:59:59');
        }

        if (!empty($createTimeMin) && !empty($createTimeMax)) {
            $where['start_time'] = array('between', $createTimeMin . ' 00:00:00' . ',' . $createTimeMax . ' 23:59:59');
        }
        $where['schedule_id'] = array('eq', $id);
        $order                = input('order', 'DESC');
        $order_by             = input('orderBy', 'start_time');
        $pageSize             = input('pageSize', 20);
        $orders               = [
            $order_by => $order,
        ];
        $data = (new SL())->searchs($where, $whereOr, $orders, $pageSize);
        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '执行日志列表', 'post' => $_POST]);
        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['data'],
            'total' => $data['total'],
            'start' => $data['start'],
        ]);
    }

    /**
     * 行为日志
     * @return [type] [description]
     */
    public function getActionLogList()
    {

        $createTimeMax = input('datemax');
        $createTimeMin = input('datemin');
        $adminId       = input('admin_id');

        $where   = [];
        $whereOr = [];

        if (!empty($adminId)) {
            $where['admin_id'] = array('eq', $adminId);
        }
        if (!empty($createTimeMin)) {
            $where['create_time'] = array('egt', $createTimeMin . ' 00:00:00');
        }
        if (!empty($createTimeMax)) {
            $where['create_time'] = array('elt', $createTimeMax . ' 23:59:59');
        }
        if (!empty($createTimeMin) && !empty($createTimeMax)) {
            $where['create_time'] = array('between', $createTimeMin . ' 00:00:00' . ',' . $createTimeMax . ' 23:59:59');
        }

        $order    = input('order', 'DESC');
        $order_by = input('orderBy', 'create_time');
        $pageSize = input('pageSize', 20);
        $orders   = [
            $order_by => $order,
        ];
        $data = (new AL())->searchs($where, $whereOr, $orders, $pageSize);

        //管理员行为日志
        $actionlog = Loader::model('action', 'logic')->actionlog(['title' => '获取管理员行为操作日志', 'post' => $_POST]);

        //获取admin详细信息
        $ids       = array_column($data['data'], 'admin_id');
        $adminData = Db::table('j_admin')->where(['id' => ['in', $ids]])->select();
        $adminData = array_column($adminData, null, 'id');

        //转换
        array_walk($data['data'], function (&$v) use ($adminData) {
            $v['admin_id'] = isset($adminData[$v['admin_id']]) ? $adminData[$v['admin_id']]['username'] : null;
            $log           = unserialize($v['log']);
            $v['title']    = $log['title'];
            $v['post']     = isset($log['post']) ? $log['post'] : [];
        });

        return $this->packReturn([
            'code'  => 0,
            'list'  => $data['data'],
            'total' => $data['total'],
            'start' => $data['start'],
        ]);
    }

}
