<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 7:26
 */

namespace xltxlm\logger\Log;

use Psr\Log\LogLevel;
use xltxlm\helper\Basic\Str;
use xltxlm\helper\Ctroller\LoadClass;
use xltxlm\helper\Hclass\ConvertObject;
use xltxlm\helper\Hclass\ObjectToJson;
use xltxlm\helper\Ctroller\SetExceptionHandler;
use xltxlm\orm\Config\PdoConfig;

/**
 * 日志的基础结构，子类提供__selfConstruct构造函数
 * Class DefineLog
 * @package xltxlm\logger\Log
 */
abstract class DefineLog
{
    const LIAN_JIE = "链接";
    const ZHEN_CHANG = "正常";
    const DU_QU = "读取";
    const CUO_WU = "错误";

    use ObjectToJson;

    public static $writelog = true;

    /** @var  array  业务的相关记录 */
    protected static $businessObject = [];
    /** @var int 日志的顺序id */
    protected static $i = [];
    /** @var array */
    protected static $uniqids = [];
    /** @var string 最后一次异常的字符串 */
    public static $Exceptionstring = "";


    /** @var int 在整个进程中，日志的记录顺序，从时间排序是看不出来的，同一秒 */
    protected $logi = 0;

    /**
     * @return int
     */
    public function getLogi(): int
    {
        return $this->logi;
    }

    /**
     * @param int $logi
     * @return DefineLog
     */
    public function setLogi(int $logi): DefineLog
    {
        $this->logi = $logi;
        return $this;
    }


    /** @var bool 本次日志是否已经存档，在异常情况下可以确保再次存档 */
    protected $haveloged = false;
    /** @var string  运行的类名称 */
    protected $logClassName = "";
    /** @var string 运行的类名称 */
    protected $callClass = "";
    /** @var  mixed 要记录的类,错误日志等 */
    protected $message;
    /** @var  string 异常错误 */
    protected $Exception = "";
    /** @var string 资源名称 */
    protected $reource = "";
    /** @var string 操作方式 */
    protected $action = self::LIAN_JIE;
    /** @var string 本次日志前后运行的时间差 */
    protected $runTime = 0;
    /** @var string 本次日志到这个点的总耗时 */
    protected $runTimetoHere = 0;

    /** @var string 日志的类型 */
    protected $type = LogLevel::INFO;

    /** @var string $_SERVER ['SERVER_NAME']运行sql的客户端名称 */
    protected $hostname = "";
    protected $dockername = "";
    /** @var string 触发这条sql运行的客户端ip */
    protected $remote_addr = "";

    /** @var string 当前请求的网址 */
    protected $url = "";
    /** @var string 来源网址 */
    protected $referer = "";
    /** @var string 进程唯一id */
    protected $uniqid = "";
    /** @var string 日志的唯一id */
    protected $logid = "";
    protected $add_time = '';
    /** @var float 日志记录的时间点 */
    protected $timestamp_start = 0.0;
    /** @var false|float|string 日志记录的时间点 */
    protected $timestamp_end = 0.0;

    /** @var array 代码执行的堆栈路径 */
    protected $trace = [];

    /** @var string 服务器类型:测试，线上 */
    protected $HOST_TYPE = '';
    /** @var string 项目名称 */
    protected $projectname = '';

    /**
     * @return string
     */
    public function getProjectname(): string
    {
        return $this->projectname;
    }

    /**
     * @param string $projectname
     * @return DefineLog
     */
    public function setProjectname(string $projectname): DefineLog
    {
        $this->projectname = $projectname;
        return $this;
    }

    protected $from_event = '';

    /**
     * @return string
     */
    public function getFromEvent(): string
    {
        return $this->from_event;
    }

    /**
     * @param string $from_event
     * @return $this
     */
    public function setFromEvent(string $from_event)
    {
        $this->from_event = $from_event;
        return $this;
    }


    /** @var string 服务器ip */
    protected $HOST_IP = '';

    /**
     * @return string
     */
    public function getHOSTIP(): string
    {
        return $this->HOST_IP;
    }

    /**
     * @param string $HOST_IP
     * @return $this
     */
    public function setHOSTIP(string $HOST_IP)
    {
        $this->HOST_IP = $HOST_IP;
        return $this;
    }

    protected $posix_getpid = 0;
    protected $PHP_SAPI = PHP_SAPI;

    /** @var float 内存使用 */
    protected $memory = 0.0;
    /** @var string nginx'生成的日志id */
    protected $eventid = '';

    protected $username;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return DefineLog
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }


    /**
     * DefineLog constructor.
     */
    public function __construct($message = null)
    {
        SetExceptionHandler::setLogOnject($this);

        if ($message) {
            $this->setMessage($message);
        }
        $this->add_time = date('Y-m-d H:i:s');
        include_once __DIR__ . '/dk_get_dt_id.php';
        $this->logClassName = static::class;
        $this->callClass = LoadClass::$runClass;
        if (!$this->callClass) {
            $debug_backtrace = array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
            foreach ($debug_backtrace as $item) {
                if ($item['class']) {
                    $this->callClass = $item['class'];
                    break;
                }
            }
        }
        $this->setUsername($_COOKIE['username']);

        if (PHP_SAPI == 'cli') {
            $this->setFromEvent('任务');
        } else {
            if ($_GET['c'] && (new Str())->setValue($_GET['c'])->Strpos('Grpc/')) {
                $this->setFromEvent('Grpc');
            } else {
                $this->setFromEvent('网页');
            }
        }


        ob_start();
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $trace = explode('#', ob_get_clean());
        $this->setTrace($trace);

        $this->logid = $_SERVER['logid'] ?: \dk_get_dt_id();
        $this->timestamp_start = microtime(true);
        $this->hostname = $_SERVER ['SERVER_NAME'] ?: '';
        $this->remote_addr = (string)($_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR']) ?? '';
        $this->url = $_SERVER['HTTP_X_FORWARDED_PROTO'] . "://" .
            ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_ADDR']) .
            $_SERVER['REQUEST_URI'];
        $this->referer = $_SERVER['HTTP_REFERER'] ?: '';
        $this->dockername = (string)($_SERVER['dockername']);
        $this->HOST_IP = $_SERVER['HOST_IP'];
        $this->HOST_TYPE = $_SERVER['HOST_TYPE'];
        $this->projectname = $_SERVER['projectname'];
        $this->posix_getpid = posix_getpid();
        $this->uniqid = self::getUniqid_static();
        $this->memory = round(memory_get_usage() / 1048576, 2);
        $this->eventid = strval($_SERVER['logid']);

        //追加全局参数记录
        foreach (self::$businessObject as $key => $item) {
            $this->$key = $item;
        }
    }

    /**
     * @return string
     */
    public function getEventid(): string
    {
        return $this->eventid;
    }

    /**
     * @param string $eventid
     * @return $this
     */
    public function setEventid(string $eventid)
    {
        $this->eventid = $eventid;
        return $this;
    }


    /**
     * @return float
     */
    public function getMemory(): float
    {
        return $this->memory;
    }

    /**
     * @param float $memory
     * @return $this
     */
    public function setMemory(float $memory)
    {
        $this->memory = $memory;
        return $this;
    }


    /**
     * @return bool
     */
    public static function isWritelog(): bool
    {
        return self::$writelog;
    }

    /**
     * @param bool $writelog
     */
    public static function setWritelog(bool $writelog)
    {
        self::$writelog = $writelog;
    }


    public static function getUniqid_static(): string
    {
        $posix_getpid = posix_getpid();
        //如果是开启多进程，那么每个进程分叉的记录分开
        if (!self::$uniqids[$posix_getpid]) {
            self::$uniqids[$posix_getpid] = uniqid();
        }
        return self::$uniqids[$posix_getpid];
    }

    /**
     * @return string
     */
    public function getException(): string
    {
        return $this->Exception;
    }

    /**
     * @param string $Exception
     * @return $this
     */
    public function setException(string $Exception)
    {
        $this->Exception = $Exception;
        return $this;
    }


    /**
     * @return int
     */
    public function getPosixGetpid(): int
    {
        return $this->posix_getpid;
    }


    /**
     * @param int $posix_getpid
     * @return DefineLog
     */
    public function setPosixGetpid(int $posix_getpid)
    {
        $this->posix_getpid = $posix_getpid;
        return $this;
    }

    /**
     * @return string
     */
    public function getDockername(): string
    {
        return $this->dockername;
    }


    /**
     * @param string $dockername
     * @return DefineLog
     */
    public function setDockername(string $dockername): DefineLog
    {
        $this->dockername = $dockername;
        return $this;
    }

    /**
     * 如果是处理队列类型的数据，每处理一次数据，重置一下日志的唯一标志
     */
    public static function resetUniqids()
    {
        $posix_getpid = posix_getpid();
        unset(self::$uniqids[$posix_getpid]);
        unset(self::$i[$posix_getpid]);
        //重新设置数据库的值
        PdoConfig::unsetAllinstance();
    }


    /**
     * @return string
     */
    public function getRunTimetoHere(): string
    {
        return $this->runTimetoHere;
    }

    /**
     * @param string $runTimetoHere
     * @return DefineLog
     */
    public function setRunTimetoHere(string $runTimetoHere): DefineLog
    {
        $this->runTimetoHere = $runTimetoHere;
        return $this;
    }


    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return static
     */
    public function setAction(string $action)
    {
        $this->action = $action;
        return $this;
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
    public function getTrace(): array
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
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        if (is_object($message)) {
            $message = (new ConvertObject($message))
                ->toArray();
        }
        $this->message = $message;
        return $this;
    }

    /**
     * 记录日志
     */
    public function __invoke()
    {
        SetExceptionHandler::setLogOnject(null);
        $this->runTimetoHere = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
        self::$i[$this->posix_getpid]++;
        $this->logi = self::$i[$this->posix_getpid];
        $this->timestamp_end = microtime(true);
        $this->runTime = sprintf('%.4f', $this->timestamp_end - $this->timestamp_start);
        $this->haveloged = true;
    }

    /**
     * 如果是异常退出，保证记录下数据
     */
    public function __destruct()
    {
        if (!$this->haveloged) {
            $this->type = LogLevel::ERROR;
            $this->setException(self::$Exceptionstring);
            $this->__invoke();
        }
    }

}
