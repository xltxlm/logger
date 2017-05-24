<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 7:26
 */

namespace xltxlm\logger\Log;

use Psr\Log\LogLevel;
use xltxlm\helper\Ctroller\LoadClass;
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

    /** @var  array  业务的相关记录 */
    protected static $businessObject = [];

    /** @var string  运行的类名称 */
    protected $logClassName = "";
    /** @var string 运行的类名称 */
    protected $callClass = "";
    /** @var array  运行的类名称 */
    protected $runClass = [];
    /** @var array  运行的函数名称 */
    protected $runFunction = [];
    /** @var string 资源名称 */
    private $reource = "";
    /** @var string 本次日志前后运行的时间差 */
    private $runTime = 0;

    /** @var string 日志的类型 */
    protected $type = LogLevel::INFO;

    /** @var string $_SERVER ['SERVER_NAME']运行sql的客户端名称 */
    private $hostname = "";
    /** @var string 触发这条sql运行的客户端ip */
    private $remote_addr = "";
    /** @var string 当前请求的网址 */
    private $url = "";
    /** @var string 来源网址 */
    private $referer = "";
    /** @var string 进程唯一id */
    private $uniqid = "";
    /** @var string 日志的唯一id */
    private $logid = "";
    /** @var false|float|string 日志记录的时间点 */
    private $timestamp = "";

    /** @var array 代码执行的堆栈路径 */
    protected $trace = [];

    /**
     * DefineLog constructor.
     */
    public function __construct()
    {
        include_once __DIR__.'/dk_get_dt_id.php';
        static $uniqid = "";
        if (!$uniqid) {
            $uniqid = uniqid();
        }
        $this->logClassName = static::class;
        $this->callClass = LoadClass::$runClass;
        $debug_backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($debug_backtrace as $item) {
            if ($item['class']) {
                $this->runClass[] = $item['class'];
            }
            if ($item['function']) {
                $this->runFunction[] = $item['class'].'::'.$item['function'];
            }
        }
        $this->runClass = array_reverse($this->runClass);
        $this->callClass = $this->callClass ?: current($this->runClass);
        $this->runFunction = array_reverse($this->runFunction);

        $this->uniqid = $uniqid;
        $this->logid = \dk_get_dt_id();
        $this->timestamp = date('c');
        $this->hostname = $_SERVER ['SERVER_NAME'] ?: '';
        $this->remote_addr = $_SERVER['REMOTE_ADDR'] ?: '127.0.0.1';
        $this->url = ($_SERVER['HTTPS'] ? "https" : "http")."://".
            ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_ADDR']).
            $_SERVER['REQUEST_URI'];
        $this->referer = $_SERVER['HTTP_REFERER'] ?: '';

        //追加全局参数记录
        foreach (self::$businessObject as $key => $item) {
            $this->$key = $item;
        }
    }

    /**
     * @return string
     */
    public function getCallClass(): string
    {
        return $this->callClass;
    }


    /**
     * @return string
     */
    public function getLogid(): string
    {
        return $this->logid;
    }

    /**
     * @param string $logid
     * @return static
     */
    public function setLogid(string $logid)
    {
        $this->logid = $logid;
        return $this;
    }


    /**
     * @param string $key
     * @param string $value
     */
    public static function setBusinessObject(string $key, string $value)
    {
        self::$businessObject[$key] = $value;
    }

    /**
     * @param string $key
     */
    public static function unsetBusinessObject(string $key)
    {
        unset(self::$businessObject[$key]);
    }

    /**
     * @return string
     */
    public function getReource(): string
    {
        return $this->reource;
    }


    /**
     * @param string $reource
     * @return static
     */
    public function setReource(string $reource)
    {
        $this->reource = $reource;
        return $this;
    }

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
     * @return array
     */
    public function getTrace():array
    {
        return $this->trace;
    }

    /**
     * @param array $trace
     *
     * @return static
     */
    public function setTrace(array $trace)
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getRemoteaddr(): string
    {
        return $this->remote_addr;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getReferer(): string
    {
        return $this->referer;
    }

    /**
     * @return string
     */
    public function getUniqid(): string
    {
        return $this->uniqid;
    }

    /**
     * @return false|float|string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param string $hostname
     * @return static
     */
    public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;
        return $this;
    }

    /**
     * @param string $remote_addr
     * @return static
     */
    public function setRemoteaddr(string $remote_addr)
    {
        $this->remote_addr = $remote_addr;
        return $this;
    }

    /**
     * @param string $url
     * @return static
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $referer
     * @return static
     */
    public function setReferer(string $referer)
    {
        $this->referer = $referer;
        return $this;
    }

    /**
     * @param string $uniqid
     * @return static
     */
    public function setUniqid(string $uniqid)
    {
        $this->uniqid = $uniqid;
        return $this;
    }

    /**
     * @param false|float|string $timestamp
     * @return static
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
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
        (new Logger($this))();
    }
}
