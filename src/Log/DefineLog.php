<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 7:26
 */

namespace xltxlm\logger\Log;

use Psr\Log\LogLevel;
use xltxlm\helper\Hclass\ObjectToKeyVar;

/**
 * 日志的基础结构
 * Class DefineLog
 * @package xltxlm\logger\Log
 */
abstract class DefineLog
{
    use ObjectToKeyVar;
    /** @var string  运行的类名称 */
    private $logClassName = "";

    /** @var string 日志的类型 */
    protected $type = LogLevel::INFO;

    /** @var string $_SERVER ['SERVER_NAME']运行sql的客户端名称 */
    private $hostname = "";
    /** @var string 触发这条sql运行的客户端ip */
    private $clientip = "";
    /** @var string 当前请求的网址 */
    private $url = "";
    /** @var string 来源网址 */
    private $referer = "";
    /** @var float 代码段运行的耗时 */
    private $logtime = 0.0;
    /** @var false|float|string 日志记录的时间点 */
    private $logtimeshow = 0.0;

    /**
     * DefineLog constructor.
     */
    final public function __construct()
    {
        $this->logClassName = static::class;
        $this->logtime = microtime(true);
        $this->logtimeshow = date('Y-m-d H:i:s');
        $this->hostname = $_SERVER ['SERVER_NAME'];
        $this->clientip = $_SERVER['REMOTE_ADDR'];
        $this->url = ($_SERVER['HTTPS'] ? "https" : "http") . "://" .
            ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_ADDR']) .
            $_SERVER['REQUEST_URI'];
        $this->referer = $_SERVER['HTTP_REFERER'];
    }

    /**
     * @return string
     */
    final public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return DefineLog
     */
    final public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
