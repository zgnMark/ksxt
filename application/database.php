<?php

if (isInnerDomain()) {
    return require_once __DIR__ . '/database_dev.php';
} else {
    return require_once __DIR__ . '/database_prod.php';
}

/**
 * 判断是否内网
 * @return bool
 */
function isInnerDomain()
{
    $ip     = $_SERVER['SERVER_ADDR'];
    $ip_int = ip2long($ip);
    if (
        ($ip_int == ip2long('127.0.0.1'))
        ||
        ($ip_int >= ip2long('10.0.0.0') && $ip_int <= ip2long('10.255.255.255'))
        // ||
        // ($ip_int >= ip2long('172.16.0.0') && $ip_int <= ip2long('172.31.255.255'))
         ||
        ($ip_int >= ip2long('192.168.0.0') && $ip_int <= ip2long('192.168.255.255'))

    ) {
        return true;
    }
    return false;
}
