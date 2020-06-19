<?php

namespace xltxlm\logger\Writer;


/**
 * 通用的日志记录，不再详细到每种分类，相关信息全部一个数组，需要的话，自己到日志服务端拆开;
 */
class Nginx_Logger extends Nginx_Logger\Nginx_Logger_implements
{

    public function __invoke()
    {
        $debug_backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $str_arr = $this->getcontext() + $debug_backtrace;
        $Content_string = json_encode($str_arr, JSON_UNESCAPED_UNICODE);
        if ($this->getloggerhost()) {
            $parse_url = parse_url($this->getloggerhost());
            $fp = fsockopen($parse_url["host"], $parse_url['port'], $errno, $errstr, 0.09);
            if ($fp) {
                // 转换到非阻塞模式
                stream_set_blocking($fp, 0);

                $header = "POST {$this->getpath()}  HTTP/1.0\r\n";
                $header .= "Referer: {$this->getentrance()}\r\n";
                $header .= "User-Agent: {$_SERVER['dockername']}\r\n";
                $header .= "Content-Length: " . strlen($Content_string) . "\r\n";
                $header .= "Connection: Close\r\n\r\n";
                fwrite($fp, $header);
                fwrite($fp, $Content_string);
                fclose($fp);
                return;
            }
        }
        error_log($Content_string . "\n", 3, "/opt/logs/logger.log");
    }

}