<?php

namespace xltxlm\logger;


/**
 * 指定日志流向的工厂;
 */
class flow extends flow\flow_implements
{
    public static function setcallback_function(callable $callback_function)
    {
        self::$callback_function = $callback_function;
        self::$getready = true;
    }

    public static function clean()
    {
        self::$callback_function = null;
        self::$getready = false;
    }


}