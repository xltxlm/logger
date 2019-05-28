<?php

namespace xltxlm\logger\Thelostlog;

use xltxlm\logger\Log\Destruct_Log;

/**
 * 记录业务的逻辑意义;
 */
class Thelostlog_Business extends Thelostlog_Business\Thelostlog_Business_implements
{
    public function __construct(string $message = "")
    {
        Destruct_Log::$log_cout['logic']++;
        if ($message) {
            $this->setFunction_name($message);
        }
        $this->setresources_type('逻辑');
        parent::__construct();
    }

}
