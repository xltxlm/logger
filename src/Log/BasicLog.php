<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-18
 * Time: 下午 12:06
 */

namespace xltxlm\logger\Log;

/**
 * 最基础的日志统计:记录一个字符串
 * Class BasicLog
 * @package xltxlm\logger\Log
 */
class BasicLog extends DefineLog
{
    protected $message = "";

    protected function __selfConstruct($message = "")
    {
        if ($message) {
            $this->setMessage($message);
        }
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return BasicLog
     */
    public function setMessage(string $message): BasicLog
    {
        $this->message = $message;
        return $this;
    }
}
