<?php

namespace xltxlm\logger\test\LoggerTrack;

use PHPUnit\Framework\TestCase;
use xltxlm\logger\flow;
use xltxlm\logger\LoggerTrack;
use function foo\func;

/**
 *
 */
class LoggerTrack_237_0Test extends TestCase
{
    use LoggerTrack_237_0Test\LoggerTrack_237_0Provider; #<---本次测试的数据供给来源

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
        $context = ['name' => 'ok'];
        flow::setcallback_function(function ($arr) use (&$return, $input, $context) {
            //证明有给回调了。且值也都传递进来了。
            if ($arr['context'] == $context && $arr['resource_type'] == $input) {
                $return = true;
            }
        });
        (new LoggerTrack())
            ->setresource_type($input)
            ->setcontext($context)
            ->__invoke();
        return $return;
    }

}

