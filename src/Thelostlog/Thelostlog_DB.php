<?php

namespace xltxlm\logger\Thelostlog;

use xltxlm\resources\Resources\Define;

/**
 * 记录各种日志;
 */
class Thelostlog_DB extends Thelostlog_DB\Thelostlog_DB_implements
{

    /**
     * Thelostlog_DB constructor.
     */
    public function __construct()
    {
        $this->setresources_type(Define::SHU_JU_KU);
        parent::__construct();
    }
}
