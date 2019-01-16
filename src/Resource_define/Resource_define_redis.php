<?php

namespace xltxlm\logger\Resource_define;

use \xltxlm\logger\Resource_define\Resource_define_TraitClass;
use xltxlm\resources\Resources\Define;

/**
 * 链接redis服务;
 */
class Resource_define_redis extends Resource_define_redis\Resource_define_redis_implements
{

    /**
     * Resource_define_redis constructor.
     */
    public function __construct()
    {
        $this->setresources_type(Define::REDIS);
        parent::__construct();
    }
}
