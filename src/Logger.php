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
    /** @var  DefineLog 日志格式 */
    protected $define;

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
     */
    public function __construct()
    {
        if (empty(self::$path)) {
            $dirname = dirname(ini_get('error_log'));
            self::$path =
                ($dirname ? $dirname . "/" : '') .
                basename(dirname(dirname(dirname((new \ReflectionClass(ClassLoader::class))
                    ->getFileName())))) .
                ".log";
        }
    }


    /**
     * 写入文件系统,如果是错误信息,会在写入另外一个 error结尾的文件
     */
    final public function __invoke()
    {
        echo "<pre>-->";
        print_r(self::$path);
        echo "<--@in " . __FILE__ . " on line " . __LINE__ . "\n";
        if ($this->getDefine()->getType() == LogLevel::ERROR) {
            error_log($this->getDefine() . "\n", 3, self::$path . ".error");
        }
        error_log($this->getDefine() . "\n", 3, self::$path);
    }
}
