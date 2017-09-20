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
use xltxlm\logger\Operation\EnumResource;

/**
 * 常规日志记录,记录一个请求的耗时
 * Class LoadClassLogger.
 */
class LoadClassLog extends BasicLog
{
    protected $className = '';

    /**
     * LoadClassLog constructor.
     */
    public function __construct()
    {
        $this->setReource(EnumResource::WAN_ZHI);
        $this->setAction(DefineLog::ZHEN_CHANG);
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
