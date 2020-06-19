<?php

namespace xltxlm\logger\test\LoggerTrack;

use PHPUnit\Framework\TestCase;
use xltxlm\logger\flow;
use xltxlm\logger\LoggerTrack;

/**
 *
 */
class LoggerTrack_noflow_238_0Test extends TestCase
{
    use LoggerTrack_noflow_238_0Test\LoggerTrack_noflow_238_0Provider; #<---本次测试的数据供给来源

    /**
     * @test
     * @dataProvider MyProvider <---本次测试的数据供给来源,3个索引分别对准本函数的3个参数
     * $input 输入值
     * $expected 期望的结果
     */
    public function __invoke($input, $expected, $args)
    {

        $result = $this->runcode($input, $args);
        //最终进行判断
        $this->assertEquals($expected, $result);
    }

    /**
     * 真正的逻辑计算
     * $input 输入值
     * $expected 期望的结果
     */
    private function runcode($input, $args)
    {
        flow::clean();
        (new LoggerTrack())
            ->setresource_type($input)
            ->__invoke();
        return true;
    }

}

