<?php

namespace xltxlm\logger\Thelostlog;

use \xltxlm\logger\Thelostlog\TraitClass;
use xltxlm\resources\Resources\Define;

/**
 * 记录发送邮件的日志;
 */
class Thelostlog_Email extends Thelostlog_Email\Thelostlog_Email_implements
{
    public function __construct()
    {
        $this->setresources_type(Define::YOU_JIAN);
        parent::__construct();
    }

}
