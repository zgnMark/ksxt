<?php
/**
 * @Author     yhz
 * @time       2017-12-27
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
namespace app\api\service\netease\payssion;

class Manager
{

    public static function call($api, array $params)
    {
        $namespace = '\\app\\api\\service\\netease\\payssion\\';
        $class     = camelize($api, '.');

        if (!class_exists($namespace . $class)) {
            throw new \Exception('不存在' . $namespace . $class);
        }
        $reflectedClass = new \ReflectionClass($namespace . $class);
        $obj            = $reflectedClass->newInstance();
        return $obj->request($params);
    }

}
