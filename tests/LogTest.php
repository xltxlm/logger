<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 8:55
 */

namespace xltxlm\logger\tests;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use xltxlm\logger\Log\BasicLog;
use xltxlm\logger\Logger;
use xltxlm\logger\tests\Resource\DemoDefineLog;

class LogTest extends TestCase
{
    protected function setUp()
    {
        ini_set('error_log', __DIR__ . "/php_errors.log");
    }

    /**
     * 写入普通的日志
     */
    public function test1()
    {
        //写入日志
        (new Logger())
            ->setDefine(
                (new DemoDefineLog())
                    ->setType(LogLevel::EMERGENCY)
            )
            ->__invoke();
        $this->assertFileExists(__DIR__ . '/logger.log');
    }

    /**
     * 写入错误的日志
     */
    public function test2()
    {
        //写入日志
        (new Logger())
            ->setDefine(
                (new DemoDefineLog())
                    ->setType(LogLevel::ERROR)
            )
            ->__invoke();
        $this->assertFileExists(__DIR__ . '/logger.log');
        $this->assertFileExists(__DIR__ . '/logger.log.error');
    }

    /**
     * 测试基础的日志类
     */
    public function test3()
    {
        (new Logger(new BasicLog("测试日志")))();
    }
}
