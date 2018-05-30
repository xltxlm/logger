<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/23
 * Time: 14:07.
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\logger\Log\BasicLog;
use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\Connect\PdoConnectLog;
use xltxlm\logger\Operation\EnumResource;

/**
 * 常规日志记录,记录一个请求的耗时
 * Class LoadClassLogger.
 */
class LoadClassLog extends PdoConnectLog
{
    protected $className = '';
    /** @var bool 是否是最终的日志 */
    protected $end = false;
    protected $_POST;
    protected $_GET;
    protected $_COOKIE;

    /**
     * LoadClassLog constructor.
     */
    public function __construct(bool $end = false)
    {
        $this->end = $end;
        if ($end) {
            $this->_COOKIE = $_COOKIE;
            $this->_POST = $_POST;
            $this->_GET = $_GET;
        }
        $this
            ->setReource(EnumResource::WAN_ZHI)
            ->setAction(EnumResource::DAIMA);
        parent::__construct();
    }


    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     *
     * @return LoadClassLog
     */
    public function setClassName(string $className): LoadClassLog
    {
        $this->className = $className;

        return $this;
    }
}
