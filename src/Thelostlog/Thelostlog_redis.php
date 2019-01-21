<?php

namespace xltxlm\logger\Thelostlog;

use xltxlm\logger\Log\Destruct_Log;
use \xltxlm\logger\Thelostlog\TraitClass;
use xltxlm\resources\Resources\Define;

/**
 * Redis执行日志;
 */
class Thelostlog_redis extends Thelostlog_redis\Thelostlog_redis_implements
{

    /**
     * Thelostlog_redis constructor.
     */
    public function __construct(string $message = "")
    {
        Destruct_Log::$log_cout['redis']++;
        if ($message) {
            $this->setFunction_name($message);
        }
        $this->setresources_type(Define::REDIS);
        parent::__construct();
    }
}
