<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-18
 * Time: 下午 1:06
 */

namespace xltxlm\logger\tests;

use PHPUnit\Framework\TestCase;
use xltxlm\logger\Qps;

/**
 * Class QpsTest
 * @package xltxlm\logger\tests
 */
class QpsTest extends TestCase
{
    public function test1()
    {
        $qps = (new Qps(__DIR__ . '/logger.log'))
            ->setLines(20)
            ->__invoke();
        echo "<pre>-->";
        print_r($qps);
        echo "<--@in " . __FILE__ . " on line " . __LINE__ . "\n";
        $this->assertNotEmpty($qps);
    }
}
