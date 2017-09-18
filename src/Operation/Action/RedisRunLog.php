<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/20
 * Time: 10:24
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\Connect\RedisConnectLog;

/**
 * 查询日志
 * Class RedisRunLog
 * @package xltxlm\redis\Logger
 */
class RedisRunLog extends RedisConnectLog
{
    protected $method = "";

    /**
     * RedisRunLog constructor.
     */
    public function __construct($message)
    {
        parent::__construct($message);
        $this->setAction(DefineLog::ZHEN_CHANG);
    }


    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return RedisRunLog
     */
    public function setMethod(string $method): RedisRunLog
    {
        $this->method = $method;
        return $this;
    }


}