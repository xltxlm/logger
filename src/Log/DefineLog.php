<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 7:26
 */

namespace xltxlm\logger\Log;

use Psr\Log\LogLevel;
use xltxlm\helper\Hclass\ObjectToJson;
use xltxlm\logger\Logger;

/**
 * 日志的基础结构，子类提供__selfConstruct构造函数
 * Class DefineLog
 * @package xltxlm\logger\Log
 */
abstract class DefineLog
{
    use ObjectToJson;
    /** @var string  运行的类名称 */
    private $logClassName = "";
    /** @var string 本次日志前后运行的时间差 */
    private $runTime = 0;

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
    /** @var string 进程唯一id */
    private $uniqid = "";
    /** @var false|float|string 日志记录的时间点 */
    private $logtimeshow = 0.0;

    /** @var string 代码执行的堆栈路径 */
    protected $trace = '';

    /**
     * @return string
     */
    public function getRunTime(): string
    {
        return $this->runTime;
    }

    /**
     * @param string $runTime
     * @return static
     */
    public function setRunTime(string $runTime)
    {
        $this->runTime = $runTime;
        return $this;
    }


    /**
     * @return string
     */
    public function getTrace(): string
    {
        return $this->trace;
    }

    /**
     * @param string $trace
     *
     * @return static
     */
    public function setTrace(string $trace): DefineLog
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * DefineLog constructor.
     */
    final public function __construct()
    {
        static $uniqid = "";
        if (!$uniqid) {
            $uniqid = uniqid();
        }
        $this->logClassName = static::class;
        $this->uniqid = $uniqid;
        $this->logtimeshow = date('Y-m-d H:i:s');
        $this->hostname = $_SERVER ['SERVER_NAME'];
        $this->clientip = $_SERVER['REMOTE_ADDR'];
        $this->url = ($_SERVER['HTTPS'] ? "https" : "http")."://".
            ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_ADDR']).
            $_SERVER['REQUEST_URI'];
        $this->referer = $_SERVER['HTTP_REFERER'];
        if (method_exists($this, '__selfConstruct')) {
            call_user_func_array([$this, '__selfConstruct'], func_get_args());
        }
    }

    /**
     * @param string $logClassName
     */
    final public function setLogClassName(string $logClassName)
    {
        $this->logClassName = $logClassName;
    }

    /**
     * @param string $hostname
     */
    final public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @param string $clientip
     */
    final public function setClientip(string $clientip)
    {
        $this->clientip = $clientip;
    }

    /**
     * @param string $url
     */
    final public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param string $referer
     */
    final public function setReferer(string $referer)
    {
        $this->referer = $referer;
    }

    /**
     * @param false|float|string $logtimeshow
     */
    final public function setLogtimeshow($logtimeshow)
    {
        $this->logtimeshow = $logtimeshow;
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
     * @return $this
     */
    final public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * 记录日志
     */
    final public function __invoke()
    {
        (new Logger())
            ->setDefine($this)
            ->__invoke();
    }
}
