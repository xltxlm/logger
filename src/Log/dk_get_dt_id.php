<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/23
 * Time: 11:37
 */


if (!function_exists('dk_get_dt_id')) {
    function dk_get_dt_id()
    {
        $microtime = microtime(true);
        return date('YmdHis').substr($microtime, 0, strpos($microtime, '.')).uniqid();
    }
}