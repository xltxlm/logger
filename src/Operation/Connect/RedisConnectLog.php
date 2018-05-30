<?php

namespace xltxlm\logger\Operation\Connect;

use xltxlm\logger\Log\BasicLog;
use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\EnumResource;
use xltxlm\redis\RedisClient;

/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/16
 * Time: 10:14.
 */
class RedisConnectLog extends BasicLog
{

    /**
     * RedisConnect constructor.
     */
    public function __construct($message)
    {
        $this
            ->setReource(EnumResource::REDIS)
            ->setAction(DefineLog::LIAN_JIE);
        parent::__construct($message);
    }
}
