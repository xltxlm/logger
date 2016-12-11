<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 7:26
 */

namespace xltxlm\logger\Log;

use Psr\Log\LogLevel;
use xltxlm\helper\Hclass\ObjectToKeyVar;

/**
 * 日志的基础结构
 * Class DefineLog
 * @package xltxlm\logger\Log
 */
abstract class DefineLog
{
    use ObjectToKeyVar;
    /** @var string 日志的类型 */
    protected $type = LogLevel::INFO;

    /**
     * @return string
     */
    final public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return DefineLog
     */
    final public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
