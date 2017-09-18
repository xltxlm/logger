<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/18
 * Time: 17:24
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\logger\Log\BasicLog;
use xltxlm\logger\Operation\EnumResource;

/**
 * 网址请求耗时日志
 * Class HttpLog
 */
class HttpLog extends BasicLog
{

    /**
     * HttpLog constructor.
     */
    public function __construct($message = null)
    {
        $this->setReource(EnumResource::HTTP);
        parent::__construct($message);
    }
}