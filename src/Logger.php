<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 7:25
 */

namespace xltxlm\logger;

use Composer\Autoload\ClassLoader;
use Psr\Log\LogLevel;
use xltxlm\logger\Log\DefineLog;

/**
 * 将日志写入文件中
 * Class Logger
 * @package xltxlm\logger
 */
final class Logger
{
    /** @var string 日志存储的路径 */
    private static $path = "";
    /** @var string 文件的后缀 */
    private $suffix = "";
    /** @var  DefineLog 日志格式 */
    protected $logDefine;
    /** @var int 运行时间超过3秒的,记录为需要优化的类型 */
    protected $timeout = 6;

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return Logger
     */
    public function setTimeout(int $timeout): Logger
    {
        $this->timeout = $timeout;
        return $this;
    }


    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param string $suffix
     * @return Logger
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }


    /**
     * @return DefineLog
     */
    public function getLogDefine()
    {
        return $this->logDefine;
    }

    /**
     * @param DefineLog $logDefine
     * @return Logger
     */
    public function setLogDefine(DefineLog $logDefine)
    {
        $this->logDefine = $logDefine;
        return $this;
    }

    /**
     * @desc   设置默认的文件日志存储位置
     * @param null|DefineLog $define
     */
    public function __construct($define = null)
    {
        if (empty(self::$path)) {
            $dirname = dirname(ini_get('error_log'));
            //如果没有设置 error_log 写到项目的目录上
            self::$path =
                ($dirname ? $dirname."/" : '').
                basename(dirname(dirname(dirname((new \ReflectionClass(ClassLoader::class))
                    ->getFileName())))).
                date('Ymd').
                ".log";
        }
        if ($define) {
            $this->setLogDefine($define);
        }
    }


    /**
     * 写入文件系统,如果是错误信息,会在写入另外一个 error结尾的文件
     */
    public function __invoke()
    {
        ob_start();
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $trace = strtr(ob_get_clean(), ["#" => "\n#"]);
        $this->getLogDefine()->setTrace($trace);
        //如果是错误日志,多开一个记录文件
        if ($this->getLogDefine()->getType() == LogLevel::ERROR) {
            error_log($this->getLogDefine()."\n", 3, self::$path.".error");
        }
        //检测紧急的,都是运行时间超时的,并且不是在命令行下运行的
        if ($this->getLogDefine()->getRunTime() > $this->getTimeout() && php_sapi_name() != 'cli') {
            error_log($this->getLogDefine()."\n", 3, self::$path.".emergency");
        }
        error_log($this->getLogDefine()."\n", 3, self::$path.$this->getSuffix());
    }
}
