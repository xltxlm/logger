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
use xltxlm\logger\Logger;
use xltxlm\logger\tests\Resource\DemoDefineLog;

class LogTest extends TestCase
{
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
}
