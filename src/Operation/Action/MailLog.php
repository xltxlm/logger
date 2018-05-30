<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/18
 * Time: 14:45
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\logger\Log\BasicLog;
use xltxlm\logger\Operation\EnumResource;

/**
 * 发送邮件日志
 * Class MailLog
 * @package xltxlm\logger\Operation\Action
 */
class MailLog extends BasicLog
{

    /**
     * MailLog constructor.
     */
    public function __construct($message = null)
    {
        $this->setReource(EnumResource::YOUJ_IAN);
        parent::__construct($message);
    }
}