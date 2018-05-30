<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-18
 * Time: 下午 12:06.
 */

namespace xltxlm\logger\Log;

use xltxlm\helper\Hclass\ConvertObject;

/**
 * 最基础的日志统计:记录一个字符串
 * Class BasicLog.
 */
class BasicLog extends DefineLog
{

    /** @var  string 文字性的描述*/
    protected $messageDescribe = "";

    /**
     * @return string
     */
    public function getMessageDescribe(): string
    {
        return $this->messageDescribe;
    }

    /**
     * @param string $messageDescribe
     * @return BasicLog
     */
    public function setMessageDescribe(string $messageDescribe)
    {
        $this->messageDescribe = $messageDescribe;
        return $this;
    }


}
