<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-18
 * Time: 下午 12:06.
 */

namespace xltxlm\logger\Log;

use xltxlm\helper\Hclass\ConvertObject;

/**
 * 最基础的日志统计:记录一个字符串
 * Class BasicLog.
 */
class BasicLog extends DefineLog
{
    protected $message = '';

    public function __construct($message = '')
    {
        parent::__construct();
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
     * @param mixed $message
     *
     * @return BasicLog
     */
    public function setMessage($message): BasicLog
    {
        if (is_object($message)) {
            $message = (new ConvertObject($message))
                ->toJson();
        }
        $debug_backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($debug_backtrace as $item) {
            if ($debug_backtrace[1]['class'] <> BasicLog::class) {
                $this->setLogClassName($debug_backtrace[1]['class']);
                break;
            }
        }
        $this->message = $message;

        return $this;
    }
}
