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
    /** @var string key */
    protected $key = "";
    /** @var bool 是否命中缓存 */
    protected $Cached = false;

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
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return RedisRunLog
     */
    public function setKey(string $key): RedisRunLog
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCached(): bool
    {
        return $this->Cached;
    }

    /**
     * @param bool $Cached
     * @return RedisRunLog
     */
    public function setCached(bool $Cached): RedisRunLog
    {
        $this->Cached = $Cached;
        return $this;
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