<?php

namespace xltxlm\logger\test\LoggerTrack;

use PHPUnit\Framework\TestCase;
use xltxlm\logger\flow;
use xltxlm\logger\LoggerTrack;

/**
 *
 */
class LoggerTrack_context_239_0Test extends TestCase
{
    use LoggerTrack_context_239_0Test\LoggerTrack_context_239_0Provider; #<---本次测试的数据供给来源

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
        $return = false;
        flow::setcallback_function(function (array $arr) use (&$return, $input, $args) {
            //证明有给回调了。且值也都传递进来了。
            $return = $arr['context'] == $args[0] + $args[1];
        });
        $loggerTrack = (new LoggerTrack())
            ->setresource_type($input);
        $loggerTrack
            ->setcontext($args[0]);
        $loggerTrack
            ->setcontext($args[1]);

        $loggerTrack
            ->__invoke();
        return $return;
    }

}

