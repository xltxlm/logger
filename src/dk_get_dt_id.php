<?php

if (!function_exists('\dk_get_next_id')) {
    function dk_get_next_id()
    {
        $microtime = microtime(true);
        return date('YmdHis').substr($microtime, 0, strpos($microtime, '.')).uniqid();
    }

}