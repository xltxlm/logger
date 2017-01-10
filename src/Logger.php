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
    protected $define;
    /** @var int 运行时间超过3秒的,记录为需要优化的类型 */
    protected $outtime = 6;

    /**
     * @return int
     */
    public function getOuttime(): int
    {
        return $this->outtime;
    }

    /**
     * @param int $outtime
     * @return Logger
     */
    public function setOuttime(int $outtime): Logger
    {
        $this->outtime = $outtime;
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
    public function getDefine()
    {
        return $this->define;
    }

    /**
     * @param DefineLog $define
     * @return Logger
     */
    public function setDefine(DefineLog $define)
    {
        $this->define = $define;
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
                ".log";
        }
        if ($define) {
            $this->setDefine($define);
        }
    }


    /**
     * 写入文件系统,如果是错误信息,会在写入另外一个 error结尾的文件
     */
    public function __invoke()
    {
        //如果是错误日志,多开一个记录文件
        if ($this->getDefine()->getType() == LogLevel::ERROR) {
            ob_start();
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $trace = ob_get_clean();
            $this->getDefine()->setTrace($trace);
            error_log($this->getDefine()."\n", 3, self::$path.".error");
        }
        //检测紧急的,都是运行时间超时的,并且不是在命令行下运行的
        if ($this->getDefine()->getRunTime() > $this->getOuttime() && php_sapi_name() != 'cli') {
            error_log($this->getDefine()."\n", 3, self::$path.".emergency");
        }
        error_log($this->getDefine()."\n", 3, self::$path.$this->getSuffix());
    }
}
